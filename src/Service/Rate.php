<?php

declare(strict_types = 1);

namespace Service;

class Rate 
{

    protected $rate;
    protected $exchRates;
    protected $amount;
    protected $fixedAmount;
    protected $currency;

    public function __construct(array $exchangeRates = [], float $amount = 00.00, string $currency = 'EUR') 
    {
	$this->exchRates = $exchangeRates;
	$this->amount = $amount;
	$this->currency = $currency;
    }

    public function getInfo(): float 
    {
	if ($this->currency == 'EUR')
	    return $this->amount;
	$this->rate = $this->exchRates[$this->currency];
	$this->checkAmount();
	return $this->fixedAmount;
    }

    private function checkAmount() 
    {
	if ($this->rate == 0) {
	    $this->fixedAmount = $this->amount;
	}
	if ($this->currency != 'EUR' || $this->rate > 0) {
	    $this->fixedAmount = $this->amount / $this->rate;
	}
    }

}
