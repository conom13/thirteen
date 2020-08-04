<?php

declare(strict_types = 1);

namespace Service;

use Service\Downloader;

class ExchangeRates 
{

    protected $rates;

    public function __construct() 
    {
	
    }

    public function getInfo(): array 
    {
	$downloaderObj = new Downloader(EXCHANGE_RATES_URL, true);
	$parsedResponce = $downloaderObj->getInfo();
	$this->rates = $parsedResponce['rates'];
	
	return $this->rates;
    }

}
