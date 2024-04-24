<?php

use KSPSMobile\GlobalFunction;
use MagicObject\Request\InputGet;
use MagicObject\Request\PicoFilterConstant;
use MagicObject\Request\PicoRequest;

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
			),
			"data_produk_simpanan"=>array(
				"nomor_rekening"=> $rekening
			)
		)
	)
);

$remote_data = json_decode($api->getData(json_encode($request)), true);
require_once __DIR__."/inc.app/header.php";
require_once __DIR__."/inc.app/header-tabungan.php";
?>

  <main id="main">

      <div class="container">
        <div class="row no-gutters">
			<div class="main-comtent">
			<script type="text/javascript">
				$(document).ready(function(e){
					$(document).on('change', '#rekening', function(e2){
						var nomor_rekening = $(this).val();
						$.ajax({
							url:'ajax/ajax-load-saldo.php',
							type:'get',
							dataType:'html',
							data:{nomor_rekening:nomor_rekening},
							success:function(data){
								$('#data-saldo').empty().append(data);
							}
						});
					});
				});
			</script>
			<h4>Saldo Tabungan</h4>
			
			<div class="data-selector">
				<select id="rekening" class="form-control">
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
			</div>
			<div id="data-saldo">
				<table class="table-two-side" width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td>Saldo Rekening</td>
						<td><?php echo format_bilangan($remote_data['data']['data_rekening'][0]['saldo']);?></td>
					</tr>
					<tr>
						<td>Saldo Efektif</td>
						<td><?php echo format_bilangan($remote_data['data']['data_rekening'][0]['saldo'] - $remote_data['data']['data_rekening'][0]['saldo_tertahan'] - $remote_data['data']['data_produk_simpanan'][0]['biaya_penutupan']);?></td>
					</tr>
					<tr>
						<td>Transaksi Terakhir</td>
						<td><?php echo GlobalFunction::translate_date(date('j M Y H:i:s', strtotime($remote_data['data']['data_rekening'][0]['transaksi_terakhir'])));?></td>
					</tr>
												
					</tbody>
				</table>
			</div>
        </div>
      </div>
  </main><!-- End #main -->

  <?php
require_once __DIR__."/inc.app/footer.php";
?>