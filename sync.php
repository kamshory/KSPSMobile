<?php
require_once __DIR__."/inc.app/config.php";
require_once __DIR__."/inc.app/aes.php";
require_once __DIR__."/inc.app/api.php";

$request = array(	
	"command"=>"database-content",
	"data"=>array(
		"table"=> array(
			"cabang"=>array(
				"where"=>"aktif = 1",
				"order_by"=>"sort_order asc"
				),
			"hari_kerja"=>array(
				"where"=>"aktif = 1",
				"order_by"=>"sort_order asc"
				)
		)
	)
);

$response = $api->get_data(json_encode($request));
$remote_data = json_decode($response, true);

foreach($remote_data['data']['table'] as $table=>$data)
{
	$app->write_profile($table, json_encode($data));
}

?>