<?php

declare(strict_types = 1);

namespace Service;

class Bin 
{

    protected $info = ['BIN' => '000000',
	'BRAND' => '',
	'BANK' => '',
	'CARD_TYPE' => '',
	'CARD_CATEGORY' => '',
	'COUNTRY' => '',
	'CC_ISO3166_1' => '',
	'CC_ISO_A3' => '',
	'COUNTRY_NUM' => '',
	'WEBSITE' => '',
	'PHONE' => ''];
    private $euIndexes;
    private $bin;
    private $url;

    public function __construct(int $bin = 0, array $euIndexes = []) 
    {
	$this->bin = $bin;
	$this->euIndexes = $euIndexes;
    }

    public function getInfo(): array 
    {
	$downloaderObj = new Downloader(BINLIST_URL . $this->bin);
	$binlist = $downloaderObj->getInfo();
	$this->info['BIN'] = $this->bin;
	$this->info['BRAND'] = (isset($binlist->brand) ? $binlist->brand : '');
	$this->info['BANK'] = (isset($binlist->bank->name) ? $binlist->bank->name : '');
	$this->info['CARD_TYPE'] = (isset($binlist->type) ? $binlist->type : '');
	$this->info['CARD_CATEGORY'] = (isset($binlist->scheme) ? $binlist->scheme : '');
	$this->info['COUNTRY'] = (isset($binlist->country->name) ? $binlist->country->name : '');
	$this->info['CC_ISO3166_1'] = (isset($binlist->country->alpha2) ? $binlist->country->alpha2 : '');
	$this->info['CC_ISO_A3'] = "";
	$this->info['COUNTRY_NUM'] = (isset($binlist->country->numeric) ? $binlist->country->numeric : '');
	$this->info['WEBSITE'] = (isset($binlist->bank->url) ? $binlist->bank->url : '');
	$this->info['PHONE'] = (isset($binlist->bank->phone) ? $binlist->bank->phone : '');
	$this->info['IS_EU'] = $this->isEu($this->info['CC_ISO3166_1']);

	return $this->info;
    }

    private function isEu(string $countryIndex = ''): bool
    {
	return in_array($countryIndex, $this->euIndexes);
    }

}
