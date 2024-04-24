<?php

/*
REQUEST
{
	"command":"inquiry-transaksi-tabungan",
	"data":{
		"nomor_rekening":"1288234523467",
		"date_time":"2020-10-10T10:10:10.123Z",
		"require":[
			{
				"data":"rekening_koran",
				"filter":{
					"date_start":"2020-10-10",
					"date_end":"2020-10-10",
					"jenis_transaksi_id":""
				}
			}
		]
	}
}
*/

$command = "inquiry-transaksi-tabungan";
$nomor_rekening = trim(@$_GET['nomor_rekening']);
$nomor_rekening = preg_replace("/[^0-9.]/", "", $nomor_rekening);
$date_time = date('Y-m-d\\TH:i:s').".000Z";
$date_begin = date('Y-m-d');
$date_end = date('Y-m-d');

$request = array(
	"command"=>$command,
	"data"=>array(
		"nomor_rekening"=>$nomor_rekening,
		"date_time"=>$date_time,
		"require"=>array(
			array(
				"data"=>"rekening_koran",
				"filter"=>array(
					"date_begin"=>$date_begin,
					"date_end"=>$date_end,
					"jenis_transaksi_id"=>""
				)
			)
		)
	)
);

$response = api_get($apiConfig, $request);
/*
{
	"command":"inquiry-transaksi-tabungan",
	"data":{
		"nomor_rekening":"1288234523467",
		"date_time":"2020-10-10T10:10:10.123Z",
		"rekening_koran":{
			"caption":{
				"waktu_buat":"Waktu",
				"jenis_transaksi_id":"Jenis Transaksi ID",
				"jenis_transaksi":"Jenis Transaksi",
				"debit":"Debit",
				"kredit":"Kredit",
				"saldo_awal":"Saldo Awal",
				"saldo_akhir":"Saldo Akhir",
			},
			"data":[
				{
					"waktu_buat":"2020-10-10T02:33:10.000Z",
					"jenis_transaksi_id":"001",
					"jenis_transaksi":"Setoran Tunai",
					"debit":"0",
					"kredit":"200.000",
					"saldo_awal":"20.000",
					"saldo_akhir":"220.000"
				}
			]
		]
	},
	"response_code":"001",
	"response_text":"Sukses"
}
*/

$data1 = $response['data'];
$data2 = $response['data']['rekening_koran']['data'];

?>
<table class="table-two-side" width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td>Saldo Rekening</td>
			<td>70.200.000</td>
		</tr>
		<tr>
			<td>Saldo Efektif</td>
			<td>60.200.000</td>
		</tr>
		<tr>
			<td>Mata Uang</td>
			<td>Rupiah (IDR)</td>
		</tr>								
	</tbody>
</table>