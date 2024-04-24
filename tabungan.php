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

$request = array(	
	"command"=>"inquiry-rekening",
	"data"=>array(
		"require"=> array(
			"data_mutasi"=>array(
				"nomor_rekening"=> $rekening,
				"data_from"=>date("Y-m-d 00:00:00"),
				"data_to"=>date("Y-m-d 23:59:59.99999999")
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
			  <h4>Mutasi Hari Ini</h4>
				<div class="data-selector">
					<script type="text/javascript">
					$(document).ready(function(e){
						$(document).on('change', '#rekening', function(e2){
							$(this).closest('form').submit();
						});
					});
					</script>
					<form action="" method="GET">
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
				<?php
				if(isset($remote_data['data']['data_mutasi']))
				{
				?>
				<table class="table-block" width="100%" border="1" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<td>Tanggal</td>
						<td>Transaksi</td>
						<td>Nominal</td>
						<td>Saldo</td>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach($remote_data['data']['data_mutasi'] as $data)
				{
					
				?>
					<tr>
						<td><?php echo GlobalFunction::translateDate(date('d M Y', strtotime($data['waktu_buat'])));?></td>
						<td><?php echo $data['jenis_transaksi'];?></td>
						<td align="right"><?php if($data['debit'] > 0) echo GlobalFunction::formatBilangan($data['debit']).' (D)'; if($data['kredit'] > 0) echo GlobalFunction::formatBilangan($data['kredit']).' (K)';?></td>
						<td align="right"><?php echo GlobalFunction::formatBilangan($data['saldo_akhir']);?></td>
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
				<div class="message">Tidak ada transaksi hari ini</div>
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