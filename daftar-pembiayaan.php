<?php

use KSPSMobile\GlobalFunction;
use MagicObject\Request\InputGet;
use MagicObject\Request\PicoFilterConstant;

require_once __DIR__."/inc.app/auth-with-form.php";
require_once __DIR__."/inc.app/api.php";
$inputGet = new InputGet();
$nomor_pembiayaan = $inputGet->getNomorPembiayaan(PicoFilterConstant::FILTER_SANITIZE_SPECIAL_CHARS);

if($nomor_pembiayaan == '')
{
	foreach($profile['daftar_pembiayaan'] as $data)
	{
		if($data['utama'])
		{
			$nomor_pembiayaan = $data['nomor_pembiayaan'];
			break;
		}
	}
	if($nomor_pembiayaan == '')
	{
		$nomor_pembiayaan = $profile['daftar_pembiayaan'][0]['nomor_pembiayaan'];
	}
}

$request = array(	
	"command"=>"inquiry-pembiayaan",
	"data"=>array(
		"require"=> array(
			"data_pembiayaan"=>array(
				"nomor_pembiayaan"=>$nomor_pembiayaan
			)
		)
	)
);
$remote_data = json_decode($api->getData(json_encode($request)), true);
require_once __DIR__."/inc.app/header.php";
require_once __DIR__."/inc.app/header-nasabah.php";
?>

  <main id="main">

      <div class="container">
		

        <div class="row no-gutters">
			<div class="main-comtent">
				<h4>Daftar Pembiayaan</h4>
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
						foreach($profile['daftar_pembiayaan'] as $data)
						{
							$nomor = $data['nomor_pembiayaan'];
						?>
						<option value="<?php echo $nomor;?>"<?php if($nomor == $nomor_pembiayaan) echo ' selected="selected"';?>><?php echo $nomor;?></option>
						<?php
						}
						?>
					</select>
					</form>
				</div>
				<?php
						if(isset($remote_data['data']['data_pembiayaan']) && count($remote_data['data']['data_pembiayaan']) > 0)
						{
						?>
						<table class="table-two-side" width="100%" cellspacing="0" cellpadding="0" border="0">
						<tbody>
						<tr>
							<td>Cabang </td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['cabang']; ?></td>
						</tr>
						<tr>
							<td>Jenis Akad </td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['jenis_akad']; ?></td>
						</tr>
						<tr>
							<td>No. Rekening</td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['nomor_rekening']; ?></td>
						</tr>
						<tr>
							<td>No. Pembiayaan</td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['nomor_pembiayaan']; ?></td>
						</tr>
						<tr>
							<td>No. Pembiayaan Lengkap</td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['nomor_pembiayaan_lengkap']; ?></td>
						</tr>
						<tr>
							<td>Pembiayaan</td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['nama']; ?></td>
						</tr>
						<tr>
							<td>Deskripsi</td>
							<td><?php echo nl2br($remote_data['data']['data_pembiayaan'][0]['deskripsi']); ?></td>
						</tr>
						<tr>
							<td>Tujuan Penggunaan</td>
							<td><?php echo nl2br($remote_data['data']['data_pembiayaan'][0]['tujuan_penggunaan']); ?></td>
						</tr>
						<tr>
							<td>Sumber Pelunasan </td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['sumber_dana']; ?></td>
						</tr>
						<tr>
							<td>Autodebit</td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['autodebit']?"Ya":"Tidak"; ?></td>
						</tr>
						<?php
						if($remote_data['data']['data_pembiayaan'][0]['autodebit'])
						{
						?>
						<tr>
							<td>No. Rekening Autodebit</td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['nomor_rekening_autodebit']; ?></td>
						</tr>
						<?php
						}
						?>
						<tr>
							<td>Mata Uang </td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['mata_uang']; ?></td>
						</tr>
						<tr>
							<td>Waktu Pengajuan</td>
							<td><span class="compare"><?php echo GlobalFunction::translateDate(date('j M Y H:i', strtotime($remote_data['data']['data_pembiayaan'][0]['waktu_pengajuan']))); ?></span></td>
						</tr>
						<tr>
							<td>Jumlah Pengajuan</td>
							<td><?php echo GlobalFunction::formatBilangan($remote_data['data']['data_pembiayaan'][0]['jumlah_pengajuan']); ?></td>
						</tr>
						<tr>
							<td>Jasa Pengajuan</td>
							<td><?php echo GlobalFunction::formatBilangan($remote_data['data']['data_pembiayaan'][0]['jasa_pengajuan']); ?></td>
						</tr>
						<tr>
							<td>Tenor Pengajuan</td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['tenor_pengajuan']; ?> bulan</td>
						</tr>
						<tr>
							<td>Catatan Pengajuan</td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['catatan_pengajuan']; ?></td>
						</tr>
						<tr>
							<td>Waktu Disetujui</td>
							<td><?php echo GlobalFunction::translateDate(date('j M Y H:i', strtotime($remote_data['data']['data_pembiayaan'][0]['waktu_disetujui']))); ?></td>
						</tr>
						<tr>
							<td>Jumlah Disetujui</td>
							<td><?php echo GlobalFunction::formatBilangan($remote_data['data']['data_pembiayaan'][0]['jumlah_disetujui']); ?></td>
						</tr>
						<tr>
							<td>Tenor Disetujui</td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['tenor_disetujui']; ?> bulan</td>
						</tr>
						<tr>
							<td>Catatan Disetujui</td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['catatan_disetujui']; ?></td>
						</tr>
						<tr>
							<td>Pokok</td>
							<td><?php echo GlobalFunction::formatBilangan($remote_data['data']['data_pembiayaan'][0]['pokok']); ?></td>
						</tr>
						<tr>
							<td>Pokok Dibayar</td>
							<td><?php echo GlobalFunction::formatBilangan($remote_data['data']['data_pembiayaan'][0]['pokok_dibayar']); ?></td>
						</tr>
						<tr>
							<td>Pokok Sisa</td>
							<td><?php echo GlobalFunction::formatBilangan($remote_data['data']['data_pembiayaan'][0]['pokok_sisa']); ?></td>
						</tr>
						<tr>
							<td>Jasa</td>
							<td><?php echo GlobalFunction::formatBilangan($remote_data['data']['data_pembiayaan'][0]['jasa']); ?></td>
						</tr>
						<tr>
							<td>Jasa Dibayar</td>
							<td><?php echo GlobalFunction::formatBilangan($remote_data['data']['data_pembiayaan'][0]['jasa_dibayar']); ?></td>
						</tr>
						<tr>
							<td>Jasa Sisa</td>
							<td><?php echo GlobalFunction::formatBilangan($remote_data['data']['data_pembiayaan'][0]['jasa_sisa']); ?></td>
						</tr>
						<tr>
							<td>Total</td>
							<td><?php echo GlobalFunction::formatBilangan($remote_data['data']['data_pembiayaan'][0]['total']); ?></td>
						</tr>
						<tr>
							<td>Total Dibayar</td>
							<td><?php echo GlobalFunction::formatBilangan($remote_data['data']['data_pembiayaan'][0]['total_dibayar']); ?></td>
						</tr>
						<tr>
							<td>Total Sisa</td>
							<td><?php echo GlobalFunction::formatBilangan($remote_data['data']['data_pembiayaan'][0]['total_sisa']); ?></td>
						</tr>
						<tr>
							<td>Tenor</td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['tenor']; ?> bulan</td>
						</tr>
						<tr>
							<td>Status</td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['status']; ?></td>
						</tr>
						<tr>
							<td>Lunas</td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['lunas']?"Sudah":"Belum"; ?></td>
						</tr>
						<?php
						if($remote_data['data']['data_pembiayaan'][0]['lunas'])
						{
						?>
						<tr>
							<td>Waktu Pelunasan</td>
							<td><?php echo $remote_data['data']['data_pembiayaan'][0]['waktu_pelunasan']; ?></td>
						</tr>
						<tr>
							<td>Catatan Pelunasan</td>
							<td><?php echo nl2br($remote_data['data']['data_pembiayaan'][0]['catatan_pelunasan']); ?></td>
						</tr>
						<?php
						}
						?>
						<tr>
							<td>Entri Data</td>
							<td><?php echo GlobalFunction::translateDate(date('j M Y H:i', strtotime($remote_data['data']['data_pembiayaan'][0]['waktu_buat']))); ?></td>
						</tr>
						<tr>
							<td>Pembaruan Data</td>
							<td><?php echo GlobalFunction::translateDate(date('j M Y H:i', strtotime($remote_data['data']['data_pembiayaan'][0]['waktu_ubah']))); ?></td>
						</tr>
						
					</tbody>
					</table>
						<?php
						}
						?>
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
  