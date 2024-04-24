<?php

use KSPSMobile\GlobalFunction;

require_once __DIR__."/config.php";
require_once __DIR__."/aes.php";
require_once __DIR__."/session.php";

$stored_session = GlobalFunction::read_session('count', 'SES_KEY');
if($stored_session === null || !isset($stored_session['u']) || !isset($stored_session['p']))
{
	include_once dirname(dirname(__FILE__))."/login.php";
	exit();
}

$auth_nasabah = $app->auth($stored_session['u'], $stored_session['p']);

if($auth_nasabah === null || @$auth_nasabah['nasabah_id'] == 0)
{
	include_once dirname(dirname(__FILE__))."/login.php";
	exit();
}
$data_rekening = $app->get_data_from_db("select * from rekening where nasabah_id = '".$auth_nasabah['nasabah_id']."' order by utama desc");
$data_pembiayaan = $app->get_data_from_db("select * from pembiayaan where nasabah_id = '".$auth_nasabah['nasabah_id']."' order by utama desc");
$data_rekening_tujuan = $app->get_data_from_db("select * from rekening_tujuan where nasabah_id = '".$auth_nasabah['nasabah_id']."' order by utama desc");

$profile = array(
	'nasabah'=>$auth_nasabah['nasabah_id'],
	'nik'=>$auth_nasabah['nik'],
	'username'=>$auth_nasabah['username'],
	'daftar_rekening'=>$data_rekening,
	'daftar_pembiayaan'=>$data_pembiayaan,
	'daftar_rekening_tujuan'=>$data_rekening_tujuan
);
