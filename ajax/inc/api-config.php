<?php

$apiConfig = new StdClass();
$apiConfig->url = "https://ksu.albasiko-2.com/api/";
$apiConfig->username = "YfgYTDtrsOISewswI";
$apiConfig->password = "uitu7iYTDIUydtrst";
$apiConfig->signature_key = "yuIUTiyDTfdUOuoOIyOop";

function format_bilangan($bilangan)
{
	return number_format($bilangan, 0, ",", ".");
}
function api_get($apiConfig, $request)
{
	$request_body = json_encode($request);
	$length = strlen($request_body);
	$timestamp = date("Y-m-d\\TH:i:s").".000Z";
	
	$curl = curl_init($apiConfig->url);
	$request_headers = array(
		'X-timestamp: '.$timestamp,
		'Content-length: '.$length
	);
	$signature = api_signature($apiConfig, $request_headers, $request_body);
	$request_headers[] = 'X-signature: '.$signature;
	
	curl_setopt($curl, CURLOPT_FAILONERROR, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);  //Post Fields
	
	curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
	
	$result = curl_exec($curl);
	$json = json_decode($result, true); 
	return $json;
}
function api_signature($apiConfig, $request_headers, $request_body)
{
	$headers = array();
	foreach($request_headers as $val)
	{
		$arr = explode(':', $val, 2);
		$key = strtoupper(str_replace('-', '_', trim($arr[0])));
		$value = trim($arr[1]);
		$headers[$key] = $value;
	}
	$timestamp = $headers['X_TIMESTAMP'];
	$path = parse_url($apiConfig->url, PHP_URL_PATH);
	$string_to_sign = $path.':'.hash('sha256', $request_body).':'.$timestamp;
	return bin2hex(
		hash_hmac('sha256', $string_to_sign, $apiConfig->signature_key, true)
    );
}

?>