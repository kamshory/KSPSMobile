<?php

use KSPSMobile\ApiClient;
use MagicObject\SecretObject;

require_once dirname(__DIR__) . "/inc.lib/vendor/autoload.php";

$appConfig = new SecretObject();
$appConfig->loadYamlFile(dirname(__DIR__)."/.deployment/config.yml", true, true, true);

$apiConfig = new SecretObject($appConfig->getApi());

$api = new ApiClient($apiConfig);
