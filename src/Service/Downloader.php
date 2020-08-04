<?php

declare(strict_types = 1);

namespace Service;

class Downloader 
{

    private $url;
    private $response;

    public function __construct(string $url = null, bool $toArray = false) 
    {
	if (!extension_loaded('curl')) {
	    throw new \ErrorException('cURL library is not loaded');
	}
	$this->url = $url;
	$this->toArray = $toArray;
    }

    public function getInfo() 
    {
	$handler = curl_init($this->url);
	curl_setopt($handler, CURLOPT_HEADER, false);
	curl_setopt($handler, CURLOPT_HTTPHEADER, array("Accept-Language: es-es,en"));
	curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($handler, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($handler, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
	curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($handler, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($handler, CURLOPT_TIMEOUT, 60);
	curl_setopt($handler, CURLOPT_AUTOREFERER, TRUE);

	$response = curl_exec($handler);
	if (curl_errno($handler)) {
	    throw new \RuntimeException('Failed to execute cURL' . $this->url);
	}
	curl_close($handler);

	if (strlen($response) > 0) {
	    $this->response = json_decode($response, $this->toArray);
	}

	return $this->response;
    }

}
