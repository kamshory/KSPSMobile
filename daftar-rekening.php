<?php

use MagicObject\Request\InputGet;
use MagicObject\Request\PicoFilterConstant;

require_once __DIR__."/inc.app/auth-with-form.php";
require_once __DIR__."/inc.app/api.php";


$inputGet = new InputGet();

$rekening = $inputGet->getRekening(PicoFilterConstant::FILTER_SANITIZE_SPECIAL_CHARS);


if($rekening == '')
{
	foreach($profile['daftar_rekening'] as $data)
	{
		if($data['utama'])
		{
			$rekening = $data['nomor_rekening'];
			break;
		}
	}
	if($rekening == '')
	{
		$rekening = $profile['daftar_rekening'][0]['nomor_rekening'];
	}
}

$request = array(	
	"command"=>"inquiry-rekening",
	"data"=>array(
		"require"=> array(
			"data_rekening"=>array(
				"nomor_rekening"=> $rekening
			)
		)
	)
);
$remote_data = json_decode($api->get_data(json_encode($request)), true);
require_once __DIR__."/inc.app/header.php";
require_once __DIR__."/inc.app/header-nasabah.php";
?>

  <main id="main">

      <div class="container">
		

        <div class="row no-gutters">
			<div class="main-comtent">
				<h4>Daftar Rekening</h4>
				<div class="data-selector">
					<script type="text/javascript">
					$(document).ready(function(e){
						$(document).on('change', '#rekening', function(e2){
							$(this).closest('form').submit();
						});
					});
					</script>
					<form action="" method="get">
					<select id="rekening" name="rekening" class="form-control">
						<?php
						foreach($profile['daftar_rekening'] as $data)
						{
							$nomor_rekening = $data['nomor_rekening'];
						?>
						<option value="<?php echo $nomor_rekening;?>"<?php if($rekening == $nomor_rekening) echo ' selected="selected"';?>><?php echo $nomor_rekening;?></option>
						<?php
						}
						?>
					</select>
					</form>
				</div>
				<table class="table-two-side" width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td>Cabang </td>
						<td><?php echo $remote_data['data']['data_rekening'][0]['cabang'];?></td>
					</tr>
					<tr>
						<td>Produk Simpanan </td>
						<td><?php echo $remote_data['data']['data_rekening'][0]['produk_simpanan'];?></td>
					</tr>
					<tr>
						<td>Nomor Rekening</td>
						<td><?php echo $remote_data['data']['data_rekening'][0]['nomor_rekening'];?></td>
					</tr>
					<tr>
						<td>Nama Pemilik</td>
						<td><?php echo $remote_data['data']['data_rekening'][0]['nama'];?></td>
					</tr>
					<tr>
						<td>Mata Uang </td>
						<td><?php echo $remote_data['data']['data_rekening'][0]['mata_uang'];?></td>
					</tr>
					<tr>
						<td>Sumber Dana </td>
						<td><?php echo $remote_data['data']['data_rekening'][0]['sumber_dana'];?></td>
					</tr>
					<tr>
						<td>Tujuan Penggunaan</td>
						<td><?php echo $remote_data['data']['data_rekening'][0]['tujuan_penggunaan'];?></td>
					</tr>
					<tr>
						<td>Saldo</td>
						<td><?php echo format_bilangan($remote_data['data']['data_rekening'][0]['saldo']);?></td>
					</tr>
					<tr>
						<td>Saldo Tertahan</td>
						<td><?php echo format_bilangan($remote_data['data']['data_rekening'][0]['saldo_tertahan']);?></td>
					</tr>
					<tr>
						<td>Terima Bagi Hasil</td>
						<td><?php echo $remote_data['data']['data_rekening'][0]['terima_bagi_hasil']?'Ya':'Tidak';?></td>
					</tr>
					<tr>
						<td>Waktu Buka</td>
						<td><?php echo GlobalFunction::translate_date(date('j M Y', strtotime($remote_data['data']['data_rekening'][0]['waktu_buka'])));?></td>
					</tr>
					<tr>
						<td>Blokir Tabungan</td>
						<td><?php echo $remote_data['data']['data_rekening'][0]['blokir_tabungan']?'Ya':'Tidak';?></td>
					</tr>
						<tr>
						<td>Blokir Pembiayaan</td>
						<td><?php echo $remote_data['data']['data_rekening'][0]['blokir_pembiayaan']?'Ya':'Tidak';?></td>
					</tr>
						<tr>
						<td>Dorman</td>
						<td><?php echo $remote_data['data']['data_rekening'][0]['dorman']?'Ya':'Tidak';?></td>
					</tr>
						<tr>
						<td>Tutup</td>
						<td><?php echo $remote_data['data']['data_rekening'][0]['tutup']?'Ya':'Tidak';?></td>
					</tr>
						<tr>
						<td>Transaksi Terakhir</td>
						<td><?php echo GlobalFunction::translate_date(date('j M Y H:i', strtotime($remote_data['data']['data_rekening'][0]['transaksi_terakhir'])));?></td>
					</tr>
					<tr>
						<td>Entri Data</td>
						<td><?php echo GlobalFunction::translate_date(date('j M Y H:i', strtotime($remote_data['data']['data_rekening'][0]['waktu_buat'])));?></td>
					</tr>
					<tr>
						<td>Pembaruan Data</td>
						<td><?php echo GlobalFunction::translate_date(date('j M Y H:i', strtotime($remote_data['data']['data_rekening'][0]['waktu_ubah'])));?></td>
					</tr>
					
				</tbody>
				</table>
				<div>
				<input type="button" name="default" class="btn btn-success" value="Jadikan Utama">
				<input type="button" name="synchronize" class="btn btn-primary" value="Sinkronkan">
				</div>
			</div>
        </div>

      </div>
	
  </main><!-- End #main -->

<?php
require_once __DIR__."/inc.app/footer.php";
?>
  