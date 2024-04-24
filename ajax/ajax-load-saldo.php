<?php
require_once __DIR__."/inc/api-config.php";

/*
REQUEST
{
	"command":"inquiry-rekening",
	"data":{
		"nomor_rekening":"1288234523467",
		"date_time":"2020-10-10T10:10:10.123Z",
		"require":[
			{
				"data":"data_rekening"
			}
		]
	}
}
*/

$command = "inquiry-transaksi-tabungan";
$nomor_rekening = trim(@$_GET['nomor_rekening']);
$nomor_rekening = preg_replace("/[^0-9.]/", "", $nomor_rekening);
$date_time = date('Y-m-d\\TH:i:s').".000Z";

$request = array(
	"command"=>$command,
	"data"=>array(
		"nomor_rekening"=>$nomor_rekening,
		"date_time"=>$date_time,
		"require"=>array(
			array(
				"data"=>"data_rekening"
			),
			array(
				"data"=>"jenis_transaksi"
			)
		)
	)
);

$response = api_get($apiConfig, $request);
/*
{
	"command":"inquiry-rekening",
	"data":{
		"nomor_rekening":"1288234523467",
		"date_time":"2020-10-10T10:10:10.123Z",
		"data_rekening":{
			"nomor_rekening":"1288234523467",
			"nama":"Joko Susilo",
			"produk_simpanan_id":"092",
			"produk_simpanan":"Taspen",
			"saldo":120000000,
			"saldo_tertahan":5000000,
		},
		"data_jenis_transaksi":{
			"jenis_transaksi_id":"092",
			"nama":"Taspen",
			"produk_simpanan_id":"092",
			"produk_simpanan":"Taspen",
			"biaya_penutupan":10000
		}
	},
	"response_code":"001",
	"response_text":"Sukses"
}
*/
$data1 = $response['data'];
$data2 = $response['data']['data_rekening'];
$data3 = $response['data']['data_produk_simpanan'];

$saldo = $data2['saldo'];
$saldo_efektif = $data2['saldo'] - $data2['saldo_tertahan'] - $data3['biaya_penutupan'];
$mata_uang_id = $data2['mata_uang_id'];
$transaksi_terakhir = $data2['transaksi_terakhir'];
?>
<table class="table-two-side" width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td>Saldo Rekening</td>
			<td data-text="Saldo Rekening"><?php echo $mata_uang_id;?> <?php echo format_bilangan($saldo);?></td>
		</tr>
		<tr>
			<td>Saldo Efektif</td>
			<td data-text="Saldo Efektif"><?php echo $mata_uang_id;?> <?php echo format_bilangan($saldo_efektif);?></td>
		</tr>
		<tr>
			<td>Transaksi Terakhir</td>
			<td data-text="Saldo Efektif"><?php echo date('d M Y H:i:s', strtotime($transaksi_terakhir));?></td>
		</tr>
	</tbody>
</table>