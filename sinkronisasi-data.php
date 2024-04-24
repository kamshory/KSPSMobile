<?php
require_once __DIR__."/inc.app/auth-with-form.php";
require_once __DIR__."/inc.app/api.php";

$rekening_tujuan = array();
if(isset($profile['daftar_rekening_tujuan']) && is_array($profile['daftar_rekening_tujuan']))
{
	foreach($profile['daftar_rekening_tujuan'] as $tujuan)
	{
		$rekening_tujuan[] = $tujuan['nomor_rekening'];
	}
}
$nasabah_id = $profile['nasabah'];
$request = array(	
	"command"=>"sinkronisasi-akun",
	"data"=>array(
		"nasabah"=> $nasabah_id,
		"require"=>array(
			"data_nasabah"=>array("nasabah_id"=>$nasabah_id),
			"data_rekening"=>array("nasabah_id"=>$nasabah_id),
			"data_pembiayaan"=>array("nasabah_id"=>$nasabah_id),
			"data_rekening_tujuan"=>array("nomor_rekening"=>$rekening_tujuan),
		)
	)
);


$response = $api->getData(json_encode($request));
$remote_data = json_decode($response, true);
if($remote_data['response_code'] == '001')
{	
	$nama = addslashes($remote_data['data']['data_nasabah'][0]['nama']);
	$username = addslashes($remote_data['data']['data_nasabah'][0]['username']);
	$nik = addslashes($remote_data['data']['data_nasabah'][0]['nik']);
	$nkk = addslashes($remote_data['data']['data_nasabah'][0]['nkk']);
	$email = addslashes($remote_data['data']['data_nasabah'][0]['email']);
	$telepon = addslashes($remote_data['data']['data_nasabah'][0]['telepon']);
	$telepon_sekunder = addslashes($remote_data['data']['data_nasabah'][0]['telepon_sekunder']);
	$telepon_tersier = addslashes($remote_data['data']['data_nasabah'][0]['telepon_tersier']);
	$jenis_kelamin = addslashes($remote_data['data']['data_nasabah'][0]['jenis_kelamin']);
	$tanggal_lahir = addslashes($remote_data['data']['data_nasabah'][0]['tanggal_lahir']);
	$aktif = 1 * $remote_data['data']['data_nasabah'][0]['aktif'];
	
	$sql = "select * from nasabah where nasabah_id = '$nasabah_id' ";
	
	if($app->get_num_row_from_db($sql))
	{
		$sql = "UPDATE `nasabah` SET 
			`username` = '$username', `nama` = '$nama', 
			`jenis_kelamin` = '$jenis_kelamin', `tanggal_lahir` = '$tanggal_lahir', 
			`email` = '$email', `telepon` = '$telepon', `telepon_sekunder` = '$telepon_sekunder', 
			`telepon_tersier` = '$telepon_tersier', `nik` = '$nik', `nkk` = '$nkk', 
			`waktu_ubah` = now(), `blokir` = '0', `aktif` = '1' 
			WHERE `nasabah_id` = '$nasabah_id';
			";	
		$app->execute_sql($sql);
	}
	
	if(isset($remote_data['data']['data_rekening']) && count($remote_data['data']['data_rekening']) > 0)
	{
		foreach($remote_data['data']['data_rekening'] as $data)
		{
			$rekekning_id = 1 * $data['rekening_id'];
			$nomor_rekening = addslashes($data['nomor_rekening']);
			$nama = addslashes($data['nama']);
			$utama = 0;
			$blokir_tabungan = 1 * $data['blokir_tabungan'];
			$blokir_pembiayaan = 1 * $data['blokir_pembiayaan'];
			$dorman = 1 * $data['dorman'];
			$tutup = 1 * $data['tutup'];
			$aktif = 1 * $data['aktif'];
			$waktu_buat = addslashes($data['waktu_buat']);
			$waktu_ubah = addslashes($data['waktu_ubah']);

			$sql = "select * from rekekning where rekekning_id = '$rekekning_id' ";
			if($app->get_num_row_from_db($sql))
			{
				$sql = "UPDATE `rekening` SET 
				`nasabah_id` = '$nasabah_id', `nomor_rekening` = '$nomor_rekening', 
				`nama` = '$nama', `blokir_tabungan` = '$blokir_tabungan', 
				`blokir_pembiayaan` = '$blokir_pembiayaan', `dorman` = '$dorman',
				`tutup` = '$tutup',`waktu_ubah` = now(),`aktif` = '$aktif'
				WHERE `rekekning_id` = '$rekekning_id';
				";
				$app->execute_sql($sql);
			}
			else
			{
				$sql = "INSERT INTO `rekening` 
					(rekekning_id, nasabah_id, nomor_rekening, nama, utama, blokir_tabungan, 
					blokir_pembiayaan, dorman, tutup, waktu_buat, waktu_ubah, aktif) VALUES
					('$rekekning_id', '$nasabah_id', '$nomor_rekening', '$nama', '$utama', '$blokir_tabungan', 
					'$blokir_pembiayaan', '$dorman', '$tutup', '$waktu_buat', '$waktu_ubah', '$aktif');
				";
				$app->execute_sql($sql);
			}
		}
	}
	if(isset($remote_data['data']['data_pembiayaan']) && count($remote_data['data']['data_pembiayaan']) > 0)
	{
		foreach($remote_data['data']['data_pembiayaan'] as $data)
		{
			$pembiayaan_id = 1 * $data['pembiayaan_id'];
			$nomor_pembiayaan = addslashes($data['nomor_pembiayaan']);
			$nama = addslashes($data['nama']);
			$utama = 0;
			$lunas = 1 * $data['lunas'];
			$aktif = 1 * $data['aktif'];
			$waktu_buat = addslashes($data['waktu_buat']);
			$waktu_ubah = addslashes($data['waktu_ubah']);

			$sql = "select * from pembiayaan where pembiayaan_id = '$pembiayaan_id' ";
			if($app->get_num_row_from_db($sql))
			{
				$sql = "UPDATE `pembiayaan` SET 
				`nomor_pembiayaan` = '$nomor_pembiayaan',`nama` = '$nama', `lunas` = '$lunas', `waktu_ubah` = now(), `aktif` = 1 
				WHERE `pembiayaan_id` = '$pembiayaan_id';
				";
				$app->execute_sql($sql);
			}
			else
			{
				$sql = "INSERT INTO `pembiayaan` 
					(pembiayaan_id, nasabah_id, nomor_pembiayaan, nama, utama, 
					lunas, waktu_buat, waktu_ubah, aktif) VALUES
					('$pembiayaan_id', '$nasabah_id', '$nomor_pembiayaan', '$nama', '$utama', 
					'$lunas', '$waktu_buat', '$waktu_ubah', '$aktif');
				";
				$app->execute_sql($sql);
			}
		}
	}
	if(isset($remote_data['data']['data_rekening_tujuan']) && count($remote_data['data']['data_rekening_tujuan']) > 0)
	{
		foreach($remote_data['data']['data_rekening_tujuan'] as $data)
		{
			$nomor_rekening = addslashes($data['nomor_rekening']);
			$nama = addslashes($data['nama']);
			$blokir_tabungan = 1 * $data['blokir_tabungan'];
			$blokir_pembiayaan = 1 * $data['blokir_pembiayaan'];
			$dorman = 1 * $data['dorman'];
			$tutup = 1 * $data['tutup'];
			$aktif = 1 * $data['aktif'];
			$waktu_buat = addslashes($data['waktu_buat']);
			$waktu_ubah = addslashes($data['waktu_ubah']);

			$sql = "select * from rekekning where rekekning_id = '$rekekning_id' ";
			if($app->get_num_row_from_db($sql))
			{
				$sql = "UPDATE `rekening` SET 
				`blokir_tabungan` = '$blokir_tabungan', 
				`blokir_pembiayaan` = '$blokir_pembiayaan', `dorman` = '$dorman',
				`tutup` = '$tutup',`waktu_ubah` = now(),`aktif` = '$aktif'
				WHERE `nasabah_id` = '$nasabah_id' and `nomor_rekening` = '$nomor_rekening';
				";
				$app->execute_sql($sql);
			}
		}
	}		
}
else
{
	
}

?>