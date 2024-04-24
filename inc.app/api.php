<?php

use KSPSMobile\ApiClient;
use MagicObject\SecretObject;

require_once dirname(__DIR__) . "/inc.lib/vendor/autoload.php";



$apiConfig = new SecretObject($appConfig->getApi());

$api = new ApiClient($apiConfig);
