<?php
use MagicObject\Session\PicoSession;

require_once dirname(__DIR__) . "/inc.lib/vendor/autoload.php";

$sessions = new PicoSession($sessionConfig);
$sessions->startSession();