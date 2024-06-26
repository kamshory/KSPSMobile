<?php

use KSPSMobile\Config\AppDatabaseConfig;
use KSPSMobile\Config\AppSessionConfig;
use KSPSMobile\MobileApp;
use MagicObject\Database\PicoDatabase;
use MagicObject\SecretObject;

require_once dirname(__DIR__) . "/inc.lib/vendor/autoload.php";

$appConfig = new SecretObject();
$appConfig->loadYamlFile(dirname(__DIR__)."/.deployment/config.yml", true, true, true);

$databaseConfig = new AppDatabaseConfig($appConfig->getDatabase(), function(){
    return bin2hex("783ery238rfhicihsc8ys9cw3sfuifh8");
});
$sessionConfig = new AppSessionConfig($appConfig->getSession(), function(){
    return bin2hex("783ery238rfhicihsc8ys9cw3sfuifh8");
});

$database = new PicoDatabase($databaseConfig);

try
{
	$database->connect();
}
catch(Exception $e)
{
	// do nothing
}

$app = new MobileApp($database);
