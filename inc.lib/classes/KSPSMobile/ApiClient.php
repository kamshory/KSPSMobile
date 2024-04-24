<?php

namespace KSPSMobile;

use MagicObject\SecretObject;

class ApiClient{

	/**
	 * SecretObject
	 *
	 * @var SecretObject
	 */
	private $config;
	public function __construct($config)
	{
		$this->config = $config;
	}
	public function createSignature($request, $timestamp1, $secret1)
	{
		$payload = str_replace(array(" ", "\r", "\n", "\t"), "", strtolower($request)).':'.$timestamp1.':'.$secret1;
		return hash('sha256', $payload);
	}
	public function getData($request_body, $request_header = null)
	{
		$date = date('Y-m-d H:i:s');
		$timestamp = date('Y-m-d\TH:i:s'.substr((string)microtime(), 1, 4).'\Z', strtotime($date));
		$signature = $this->createSignature($request_body, $timestamp, $this->config->getSecret());
		if($request_header == null)
		{
			$request_header = array();
		}
		$request_header[] = 'Authorization: Basic '.base64_encode($this->config->getUsername().":".$this->config->getPassword());
		$request_header[] = 'X-Timestamp: '.$timestamp;
		$request_header[] = 'X-Signature: '.$signature;
		$request_header[] = 'User-agent: API Client';
		$request_header[] = 'Content-length: '.strlen($request_body);
		$request_header[] = 'Content-type: application/json';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $this->config->getUrl());
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //NOSONAR
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST , 0); //NOSONAR
		curl_setopt($ch, CURLOPT_POST, 1);		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);  			
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_header);	
		$res = curl_exec($ch);
		curl_close($ch);
		return $res;
	}
}