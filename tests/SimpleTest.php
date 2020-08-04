<?php

namespace App\Tests;

use Service\Rate;
use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase 
{

    public function testGetInfo() 
    {
	$rate = new Rate([], 100.00, 'EUR');
	$this->assertSame(100.00, $rate->getInfo());
    }

    public function testGetInfoDifferentCurrencies() 
    {
	$currencies = [
	    'BGN' => 0,
	    'USD' => 1.1,
	];

	$rate = new Rate($currencies, 11, 'USD');
	$this->assertEquals(10, $rate->getInfo());

	//TODO Uncomment this -> it finds an error in your business logic
	//$rateBgn = new Rate($currencies, 15.487, 'BGN');
	//$this->assertEquals(15.487, $rateBgn->getInfo());
    }

    public function testErrorMissingCurrency() 
    {
	//TODO Uncomment this -> there is an Error: Undefined index: BGN
	//$rate = new Rate([], 123.00, 'BGN');
	//$this->assertEquals('WHAT DO WE EXPECT HERE?', $rate->getInfo());
    }

}
