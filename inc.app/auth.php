<?php
require_once __DIR__."/config.php";
require_once __DIR__."/aes.php";
require_once __DIR__."/session.php";
$sored_session = read_session('count', SES_KEY);
$profil_nasabah = $app->auth($sored_session['u'], $sored_session['p']);
