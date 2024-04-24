<?php

use KSPSMobile\GlobalFunction;
use MagicObject\Request\InputGet;
use MagicObject\Request\PicoFilterConstant;

require_once __DIR__."/inc.app/auth-with-form.php";
require_once __DIR__."/inc.app/api.php";


$nasabah_id = $profile['nasabah'];

$inputGet = new InputGet();
$nomor_pembiayaan = $inputGet->getNomorPembiayaan(PicoFilterConstant::FILTER_SANITIZE_SPECIAL_CHARS);
if($nomor_pembiayaan == '')
{
	if(isset($profile['daftar_pembiayaan']) && count($profile['daftar_pembiayaan']) > 0)
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
}

$request = array(	
	"command"=>"inquiry-pembiayaan",
	"data"=>array(
		"nasabah"=> $nasabah_id,
		"require"=> array(
			"data_pembiayaan"=>array(
				"nomor_pembiayaan"=>$nomor_pembiayaan
			),
			"data_tagihan"=>array(
				"nomor_pembiayaan"=>$nomor_pembiayaan
			),
			"data_denda"=>array(
				"nomor_pembiayaan"=>$nomor_pembiayaan
			),
			"data_agunan"=>array(
				"nomor_pembiayaan"=>$nomor_pembiayaan
			)
		)
	)
);
$response = $api->getData(json_encode($request));
$remote_data = json_decode($response, true);

require_once __DIR__."/inc.app/header.php";
require_once __DIR__."/inc.app/header-pembiayaan.php";
?>
  
  <main id="main">

      <div class="container">
		

        <div class="row no-gutters">
			<div class="main-comtent">
				<div class="content-tabs">
					<div class="content-tab active" data-id="tagihan">
					  <h4>Tagihan</h4>
					  <?php 
						if(isset($remote_data['data']['data_tagihan']) && count($remote_data['data']['data_tagihan']) > 0)
						{
						?>					  
					  <table class="table-block" width="100%" border="1" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<td>Periode</td>
								<td>Pokok</td>
								<td>Po. Dibayar</td>
								<td>Po. Sisa</td>
								<td>Jasa</td>
								<td>Ja. Dibayar</td>
								<td>Ja. Sisa</td>
								<td>Tabarru</td>
								<td>Ta. Dibayar</td>
								<td>Ta. Sisa</td>
								<td>Total</td>
								<td>To. Dibayar</td>
								<td>To. Sisa</td>
								<td>Tgl. Bayar</td>
							</tr>
						</thead>
						<tbody>
						<?php
						foreach($remote_data['data']['data_tagihan'] as $data)
						{
						?>
							<tr>
								<td><?php echo GlobalFunction::periodStr($data['periode_id']);?></td>
								<td align="right"><?php echo GlobalFunction::formatBilangan($data['pokok']);?></td>
								<td align="right"><?php echo GlobalFunction::formatBilangan($data['pokok_dibayar']);?></td>
								<td align="right"><?php echo GlobalFunction::formatBilangan($data['pokok_sisa']);?></td>
								<td align="right"><?php echo GlobalFunction::formatBilangan($data['jasa']);?></td>
								<td align="right"><?php echo GlobalFunction::formatBilangan($data['jasa_dibayar']);?></td>
								<td align="right"><?php echo GlobalFunction::formatBilangan($data['jasa_sisa']);?></td>
								<td align="right"><?php echo GlobalFunction::formatBilangan($data['tabarru']);?></td>
								<td align="right"><?php echo GlobalFunction::formatBilangan($data['tabarru_dibayar']);?></td>
								<td align="right"><?php echo GlobalFunction::formatBilangan($data['tabarru_sisa']);?></td>
								<td align="right"><?php echo GlobalFunction::formatBilangan($data['total']);?></td>
								<td align="right"><?php echo GlobalFunction::formatBilangan($data['total_dibayar']);?></td>
								<td align="right"><?php echo GlobalFunction::formatBilangan($data['total_sisa']);?></td>
								<td><?php if($data['waktu_pelunasan']) echo GlobalFunction::translateDate(date('d M Y H:i', strtotime($data['waktu_pelunasan']))); else echo '&nbsp;';?></td>
							</tr>
						<?php
						}
						
						?>						
						</tbody>
					  </table>
					  <?php
					  }
					  ?>
					</div>  
					
					<div class="content-tab" data-id="denda">
					  <h4>Denda</h4>
					  <?php						
					  if(isset($remote_data['data']['data_denda']) && count($remote_data['data']['data_denda']) > 0)
					  {
						?>
					  <table class="table-block" width="100%" border="1" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<td>Periode</td>
								<td>Trelambat</td>
								<td>Denda</td>
								<td>D. Dibayar</td>
								<td>D. Sisa</td>
							</tr>
						</thead>
						<tbody>
						<?php
						foreach($remote_data['data']['data_denda'] as $data)
						{
						?>
							<tr>
								<td><?php echo GlobalFunction::periodStr($data['periode_id']);?></td>
								<td align="right"><?php echo $data['keterlambatan'];?> hari</td>
								<td align="right"><?php echo GlobalFunction::formatBilangan($data['denda']);?></td>
								<td align="right"><?php echo GlobalFunction::formatBilangan($data['denda_dibayar']);?></td>
								<td align="right"><?php echo GlobalFunction::formatBilangan($data['denda_sisa']);?></td>
							</tr>
						<?php
						}
						
						?>						
						</tbody>
					  </table>
					  <?php
					  }
					  ?>
					</div>  
					
					<div class="content-tab" data-id="pembiayaan">
					<h4>Pembiayaan</h4>
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
					</div>
					<div class="content-tab" data-id="agunan">
					<h4>Agunan</h4>
					<?php
					if(isset($remote_data['data']['data_agunan']) && count($remote_data['data']['data_agunan']) > 0)
					{
					foreach($remote_data['data']['data_agunan'] as $data)
					{
					?>
					<table class="table-two-side" width="100%" cellspacing="0" cellpadding="0" border="0">
						<tbody>
						
							<tr>
								<td>Cabang</td>
								<td><?php echo $data['cabang_id']; ?></td>
							</tr>
							<tr>
								<td>Nomor Agunan</td>
								<td><?php echo $data['nomor_agunan']; ?></td>
							</tr>
							<tr>
								<td>Objek Agunan</td>
								<td><?php echo $data['nama']; ?></td>
							</tr>
							<tr>
								<td>Tanggal Pembelian</td>
								<td><?php echo GlobalFunction::translateDate(date('j M Y', strtotime($data['tanggal_pembelian']))); ?></td>
							</tr>
							<tr>
								<td>Masa Berlaku</td>
								<td><?php echo $data['masa_berlaku']; ?></td>
							</tr>
							<tr>
								<td>Jumlah</td>
								<td><?php echo $data['jumlah']; ?></td>
							</tr>
							<tr>
								<td>Satuan</td>
								<td><?php echo $data['satuan']; ?></td>
							</tr>
							<tr>
								<td>Spesifikasi</td>
								<td><?php echo nl2br($data['spesifikasi']); ?></td>
							</tr>
							<tr>
								<td>Deskripsi</td>
								<td><?php echo nl2br($data['deskripsi']); ?></td>
							</tr>
							<tr>
								<td>Taksiran Harga</td>
								<td><?php echo GlobalFunction::formatBilangan($data['taksiran_harga']); ?></td>
							</tr>
							<tr>
								<td>Mata Uang </td>
								<td><?php echo $data['mata_uang']; ?></td>
							</tr>
							<tr>
								<td>Dokumen</td>
								<td><?php echo $data['dokumen']; ?></td>
							</tr>
							<tr>
								<td>Ditahan</td>
								<td><?php echo $data['ditahan']?"Ya":"Tidak"; ?></td>
							</tr>
							<tr>
								<td>Entri Data</td>
								<td><?php echo GlobalFunction::translateDate(date('j M Y H:i', strtotime($data['waktu_buat']))); ?></td>
							</tr>
							<tr>
								<td>Pembaruan Data</td>
								<td><?php echo GlobalFunction::translateDate(date('j M Y H:i', strtotime($data['waktu_ubah']))); ?></td>
							</tr>
													
						</tbody>
					</table>
					<?php
					}
					}
					?>
					</div>
				</div>
			</div>
        </div>

      </div>
	
  </main><!-- End #main -->

  <?php
require_once __DIR__."/inc.app/footer.php";
?>