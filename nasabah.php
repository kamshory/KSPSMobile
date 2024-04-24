<?php
require_once __DIR__."/inc.app/auth-with-form.php";
require_once __DIR__."/inc.app/api.php";

$request = array(	
	"command"=>"inquiry-rekening",
	"data"=>array(
		"require"=> array(
			"data_nasabah"=>array(
				"nomor_rekening"=> $profile['daftar_rekening'][0]['nomor_rekening']
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
				<h4>Informasi Nasabah</h4>
				
				<table class="table-two-side" width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td>Cabang </td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['cabang'];?></td>
					</tr>
					<tr>
						<td>NIK</td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['nik'];?></td>
					</tr>
					<tr>
						<td>NKK</td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['nkk'];?></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['nama'];?></td>
					</tr>
					<tr>
						<td>Anggota</td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['anggota']?'Ya':'Tidak';?></td>
					</tr>
					<?php
					if($remote_data['data']['data_nasabah'][0]['anggota'])
					{
					?>
					<tr>
						<td>Nomor Anggota</td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['nomor_anggota'];?></td>
					</tr>
					<?php
					}
					?>
					<tr>
						<td>Tempat Lahir</td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['tempat_lahir'];?></td>
					</tr>
					<tr>
						<td>Tanggal Lahir</td>
						<td><?php echo GlobalFunction::translate_date(date('j F Y', strtotime($remote_data['data']['data_nasabah'][0]['tanggal_lahir'])));?></td>
					</tr>
					<tr>
						<td>Jenis Kelamin</td>
						<td><?php if($remote_data['data']['data_nasabah'][0]['jenis_kelamin'] == 'L') echo 'Laki-laki'; if($remote_data['data']['data_nasabah'][0]['jenis_kelamin'] == 'P') echo 'Perempuan'; ?></td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['alamat'];?></td>
					</tr>
					<tr>
						<td>Status Rumah </td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['status_rumah'];?></td>
					</tr>
					<tr>
						<td>Telepon</td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['telepon'];?></td>
					</tr>
					<?php
					if(isset($remote_data['data']['data_nasabah'][0]['telepon_sekunder']) && strlen($remote_data['data']['data_nasabah'][0]['telepon_sekunder']) > 0)
					{
					?>
					<tr>
						<td>Telepon Sekunder</td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['telepon_sekunder'];?></td>
					</tr>
					<?php
					}
					?>
					<?php
					if(isset($remote_data['data']['data_nasabah'][0]['telepon_sekunder']) && strlen($remote_data['data']['data_nasabah'][0]['telepon_sekunder']) > 0)
					{
					?>
					<tr>
						<td>Telepon Tersier</td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['telepon_tersier'];?></td>
					</tr>
					<?php
					}
					?>
					<?php
					if(isset($remote_data['data']['data_nasabah'][0]['telepon_sekunder']) && strlen($remote_data['data']['data_nasabah'][0]['telepon_sekunder']) > 0)
					{
					?>
					<tr>
						<td>Email</td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['email'];?></td>
					</tr>
					<?php
					}
					?>
					<tr>
						<td>Status Pernikahan </td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['status_pernikahan'];?></td>
					</tr>
					<tr>
						<td>Nama Pasangan</td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['nama_pasangan'];?></td>
					</tr>
					<tr>
						<td>Tanggungan</td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['jumlah_tanggungan'];?></td>
					</tr>
					<tr>
						<td>Pekerjaan </td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['pekerjaan'];?></td>
					</tr>
					<tr>
						<td>Pendapatan</td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['pendapatan'];?></td>
					</tr>
					<tr>
						<td>NPWP</td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['npwp'];?></td>
					</tr>
					<tr>
						<td>Pendidikan </td>
						<td><?php echo $remote_data['data']['data_nasabah'][0]['pendidikan'];?></td>
					</tr>
					<tr>
						<td>Entri Data</td>
						<td><?php echo GlobalFunction::translate_date(date('j M Y H:i:s', strtotime($remote_data['data']['data_nasabah'][0]['waktu_buat'])));?></td>
					</tr>
					<tr>
						<td>Pembaruan Data</td>
						<td><?php echo GlobalFunction::translate_date(date('j M Y H:i:s', strtotime($remote_data['data']['data_nasabah'][0]['waktu_ubah'])));?></td>
					</tr>
					
				</tbody></table>
			</div>
        </div>

      </div>
	
  </main><!-- End #main -->

<?php
require_once __DIR__."/inc.app/footer.php";
?>
  