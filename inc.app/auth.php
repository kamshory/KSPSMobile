<?php

use KSPSMobile\GlobalFunction;

require_once __DIR__."/config.php";
require_once __DIR__."/aes.php";
require_once __DIR__."/session.php";

$soredSession = GlobalFunction::readSession('count', 'SES_KEY');
$profil_nasabah = $app->auth($soredSession['u'], $soredSession['p']);
