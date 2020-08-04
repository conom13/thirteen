<?php

require_once 'vendor/autoload.php';

if (!isset($argv[1]) || !is_file($inputFile = $argv[1])) {
    printf("php %s inputFile \n", __FILE__);
    exit();
}

define('BINLIST_URL', 'https://lookup.binlist.net/');
define('EU_INDEXES', ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK']);
define('EXCHANGE_RATES_URL', 'https://api.exchangeratesapi.io/latest');

$exchangeRatesObj = new Service\ExchangeRates();
$exchangeRates = $exchangeRatesObj->getInfo();

$transactionsRequest = new \Request\RequestFromInput($inputFile, $exchangeRates);

try {
    $transactions = $transactionsRequest->execute();
    echo implode("\n", $transactions);
} catch (Exception $ex) {
    echo $ex->getMessage();
    exit();
}