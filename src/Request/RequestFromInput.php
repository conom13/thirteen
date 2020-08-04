<?php

declare(strict_types = 1);

namespace Request;

use Service\Bin;
use Service\Rate;

class RequestFromInput implements Request 
{

    private $infile;
    private $transaction;
    private $exchangeRates;
    

    public function __construct(string $infile, array $exchangeRates)
    {
	$this->infile = $infile;
	$this->exchangeRates = $exchangeRates;
    }

    public function execute(): array 
    {
	$this->transaction = array_map(function( $line ) {
	    $binObj = new Bin((int)$line['bin'], EU_INDEXES);
	    $rateObj = new Rate($this->exchangeRates, floatval($line['amount']), $line['currency']);
	    return $this->calculate($binObj->getInfo()['IS_EU'], $rateObj->getInfo());
	}, $this->readLines());
	return $this->transaction;
    }

    private function readLines(): array 
    {
	if (!($handle = fopen($this->infile, 'r'))) {
	    throw new \RuntimeException('Failed to open file');
	}

	$items = [];
	while (($buffer = fgets($handle)) !== false) {
	    $items[] = json_decode($buffer, TRUE);
	}

	return $items;
    }

    private function calculate(bool $isEu = true, $rate = 100): float 
    {
	$commision = $rate * ($isEu ? 0.01 : 0.02);
	return $this->ceilingValue($commision, 2);
    }
    
    public function ceilingValue(float $val = 0, int $decimal = 2) : float
    {
	$pow = pow(10, $decimal);
	return ( ceil($pow * $val) + ceil($pow * $val - ceil($pow * $val)) ) / $pow;
    }    

}
