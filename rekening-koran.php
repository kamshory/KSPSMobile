<?php

use KSPSMobile\GlobalFunction;
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


$mulai = $inputGet->getMulai();
$hingga = $inputGet->getHingga();

if($mulai == '')
{
	$mulai = date('Y-m-d');
}
if($hingga == '')
{
	$hingga = date('Y-m-d');
}

$mulai_jam = $mulai.' 00:00:00';
$hingga_jam = $hingga.' 23:59:59.999999';

$request = array(	
	"command"=>"inquiry-rekening",
	"data"=>array(
		"require"=> array(
			"data_mutasi"=>array(
				"nomor_rekening"=> $rekening,
				"data_from"=>$mulai_jam,
				"data_to"=>$hingga_jam
			)
		)
	)
);


$response = $api->getData(json_encode($request));
$remote_data = json_decode($response, true);



require_once __DIR__."/inc.app/header.php";
require_once __DIR__."/inc.app/header-tabungan.php";
?>
  
  <main id="main">

      <div class="container">
		

        <div class="row no-gutters">
			<div class="main-comtent">
			<h4>Rekening Koran</h4>
			<form action="" method="GET">
			<table class="table-two-side" width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td>Rekening</td>
					<td>
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
					</td>
				</tr>
				<tr>
					<td>Mulai</td>
					<td><input type="date" class="form-control" id="mulai" name="mulai"
					   value="<?php echo $mulai;?>"
					   min="<?php echo date('Y-m-d', strtotime('-1 year'));?>" max="<?php echo date('Y-m-d');?>">
					</td>
				</tr>
				<tr>
					<td>Hingga</td>
					<td><input type="date" class="form-control" id="hingga" name="hingga"
					   value="<?php echo $hingga;?>"
					   min="<?php echo date('Y-m-d', strtotime('-31 days'));?>" max="<?php echo date('Y-m-d');?>">
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" class="btn btn-success" value="Tampilkan">
					</td>
				</tr>
			
				</tbody>
			</table>
			</form>
			<?php
			if(isset($remote_data['data']['data_mutasi']))
			{
			?>
			<table class="table-block" border="1" width="100%" cellspacing="0" cellpadding="0" data-table-sort="true" data-self-name="cetak-transaksi-tabungan.php">
				<thead>
					<tr>
						<td class="col-sort" data-col-name="waktu_buat">Waktu</td>
						<td class="col-sort" data-col-name="cabang_id">Cabang</td>
						<td class="col-sort" data-col-name="jenis_transaksi_id">Transaksi</td>
						<td class="col-sort" align="right" data-col-name="debit">Debit</td>
						<td class="col-sort" align="right" data-col-name="kredit">Kredit</td>
						<td class="col-sort" align="right" data-col-name="saldo_akhir">Saldo</td>
						<td class="col-sort" data-col-name="nomor_referensi">No. Referensi</td>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($remote_data['data']['data_mutasi'] as $data)
					{
					?>
					<tr>
						<td><?php echo GlobalFunction::translate_date(date('j M Y H:i:s', strtotime($data['waktu_buat']))); ?></td>
						<td><?php echo $data['cabang'];?></td>
						<td><?php echo $data['jenis_transaksi'];?></td>
						<td align="right"><?php echo format_bilangan($data['debit']);?></td>
						<td align="right"><?php echo format_bilangan($data['kredit']);?></td>
						<td align="right"><?php echo format_bilangan($data['saldo_akhir']);?></td>
						<td><?php echo $data['nomor_referensi'];?></td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>	
			<?php
			}
			else
			{
			?>
				<div class="message">Tidak ada transaksi pada rentang waktu ini</div>
			<?php
			}
			?>
			</div>
        </div>

      </div>
	
  </main><!-- End #main -->

  <?php
require_once __DIR__."/inc.app/footer.php";
?>