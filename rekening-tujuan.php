<?php

use MagicObject\Request\InputGet;
use MagicObject\Request\PicoFilterConstant;

require_once __DIR__."/inc.app/auth-with-form.php";
require_once __DIR__."/inc.app/api.php";

$inputGet = new InputGet();


if($inputGet->getAction() == 'inquiry-rekening')
{
	
	$rekening = $inputGet->getRekening(PicoFilterConstant::FILTER_SANITIZE_SPECIAL_CHARS);

	if(strlen($rekening))
	{
		$request = array(	
			"command"=>"inquiry-rekening",
			"data"=>array(
				"require"=> array(
					"nama_pemilik"=>array(
						"nomor_rekening"=> $rekening
					)
				)
			)
		);
		
		$response = $api->getData(json_encode($request));
		$remote_data = json_decode($response, true);
		$remote_data['data']['data_asli'] = base64_encode(json_encode($remote_data['data']['data_rekening']));
		echo json_encode($remote_data, JSON_PRETTY_PRINT);
	}
	exit();
}
if($inputGet->getAction() == 'tambah-rekening' && isset($_POST['rekening_tujuan']) && isset($_POST['pemilik_rekening']))
{
	$nasabah_id = $profile['nasabah'];
	$rekening_tujuan = addslashes(htmlspecialchars(trim(@$_POST['rekening_tujuan'])));
	$pemilik_rekening = addslashes(htmlspecialchars(trim(@$_POST['pemilik_rekening'])));
	$datastr = $inputGet->getData();
	$mata_uang_id = 'IDR';
	$dorman = 0;
	$tutup = 0;
	$aktif = 1;
	try
	{
		$data = json_decode(base64_decode($datastr), true);
		$mata_uang_id = addslashes(trim(@$data[0]['mata_uang_id']));
		$dorman = addslashes(trim(@$data[0]['dorman']));
		$tutup = addslashes(trim(@$data[0]['tutup']));
		$aktif = addslashes(trim(@$data[0]['aktif']));
		
	}
	catch(Exception $e)
	{
		// do nothing
	}
	$sql = "select * from rekening_tujuan where nasabah_id = '$nasabah_id' and nomor_rekening = '$rekening_tujuan' ";
	if($app->get_num_row_from_db($sql))
	{
		$sql = "UPDATE `rekening_tujuan` SET 
		`nasabah_id` = '$nasabah_id', `nomor_rekening` = '$rekening_tujuan', 
		`nama` = '$pemilik_rekening', `dorman` = '$dorman',
		`tutup` = '$tutup', `waktu_ubah` = now(),`aktif` = '$aktif'
		WHERE nasabah_id = '$nasabah_id' and nomor_rekening = '$rekening_tujuan';
		";
		$app->execute_sql($sql);
	}
	else
	{
		$utama = 0;
		$sql = "INSERT INTO `rekening_tujuan` 
			(nasabah_id, nomor_rekening, nama, utama, dorman, tutup, waktu_buat, waktu_ubah, aktif) VALUES
			('$nasabah_id', '$rekening_tujuan', '$pemilik_rekening', '$utama', '$dorman', '$tutup', now(), now(), '$aktif');
		";
		$app->execute_sql($sql);
	}
	header('Location: '.basename($_SERVER['PHP_SELF']));
}

require_once __DIR__."/inc.app/header.php";
require_once __DIR__."/inc.app/header-transfer-dana.php";
?>
  <script type="text/javascript">
  $(document).ready(function(e){
	  $(document).on('change', '[name="rekening_tujuan"]', function(e2){
		  var rekening_tujuan = $(this).val();
		  if(rekening_tujuan.length > 0)
		  {
			  $.ajax({
				  'url':'rekening-tujuan.php',
				  'type':'get',
				  'dataType':'json',
				  'data':{'action':'inquiry-rekening','rekening':rekening_tujuan},
				  'success':function(data){
					  if(typeof  data.data.data_rekening != 'undefined')
					  {
						  var nama = data.data.data_rekening[0].nama || '';
						  $('[name="pemilik_rekening"]').val(nama);
						  $('[name="data"]').val(data.data.data_asli);
						  if(nama.length > 0)
						  {
							  $('.simpan-rekening').css({'display':'inline'});
						  }
						  else
						  {
							  $('.simpan-rekening').css({'display':'none'});
						  }
					  }
					  else
					  {
						  $('[name="pemilik_rekening"]').val('');
						  $('[name="data"]').val('');
						  $('.simpan-rekening').css({'display':'none'});
					  }
				  }
			  });
		  }
	  });
	  $(document).on('click', '.simpan-rekening', function(e2){
		  $('form[name="formrekeningtujuan"]').submit();
	  });
	  
  });
  function showDialogRekeningTujuan()
  {
	  $('.simpan-rekening').css({'display':'none'});
	  $('#tambah-rekening').modal();
  }
  </script>
  <main id="main">

      <div class="container">
        <div class="row no-gutters">
			<div class="main-comtent">
				<h4>Rekening Tujuan</h4>
				<?php
				if($inputGet->getAction() == 'tambah-rekening')
				{
					$rekening_tujuan = htmlspecialchars(trim($_GET['rekening_tujuan']));
					$pemilik_rekening = htmlspecialchars(trim($_GET['pemilik_rekening']));
				?>
				
				<script type="text/javascript" src="assets/js/base64.js"></script>
				<script type="text/javascript">
				function getSMS() 
				{
					var sms = null;
					if(typeof Android !== "undefined" && Android !== null) 
					{
						sms = Android.getSMS();
					} 
					else 
					{
						console.log("Not viewing in webview");
					}
					return sms;
				}
				function clearSMS()
				{
					if(typeof Android !== "undefined" && Android !== null) 
					{
						Android.clearSMS();
					} 
					else 
					{
						console.log("Not viewing in webview");
					}
				}
				var timeInterval = 200;
				var interval = setInterval('', 10000000);
				var isNumeric = /^[-+]?(\d+|\d+\d*|\d*\d+)$/;
				function validOTP(message)
				{
					var otp = null;
					message = message.split("\r").join(" ");
					message = message.split("\n").join(" ");
					message = message.split("\t").join(" ");
					message = message.replace(/\s\s+/g, ' ');
					var msg = "";
					if(message.indexOf(">>>") != -1 && message.indexOf("<<<") != -1)
					{
						var messages = message.split(" ");
						for(i = 0; i<messages.length; i++)
						{
							if(isNumeric.test(messages[i]) && messages[i].length == 6)
							{
								otp = messages[i];
								break;
							}
						}
					}
					return otp;
				}
				$(document).ready(function(e){				
					listenSMS();
					$(document).on('keyup', '.otp-control', function(e2){
						if($(this).val().length == 1)
						{
							if($(this).next().length)
							{
								$(this).next().select();
							}
						}
						if(e2.keyCode == 8)
						{
							if($(this).val().length == 0)
							{
								if($(this).prev().length)
								{
									var val = $(this).prev().val();
									$(this).prev().select();
								}
							}
						}
					});	
				});
				function listenSMS()
				{
					clearTimeout(interval);
					interval = setInterval(function(){
						var sms = getSMS();
						if(sms != null)
						{
							if(sms.length > 10)
							{
								var otp = validOTP(sms);
								if(otp.length == 6)
								{
									var arr = otp.split('');
									var j = 1;
									for(var i in arr)
									{
										$('#otp'+j).val(arr[i]);
										j++;
									}
									clearSMS();
									timeInterval = 1000;
								}
							}
						}			
					}, timeInterval);
				}
				</script>
				<form action="" method="post">
				<table class="table-two-side" width="100%" border="0" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td>Nomor</td>
						<td><input type="text"class="form-control" name="rekening_tujuan" value="<?php echo $rekening_tujuan;?>" required></td>
					</tr>
					<tr>
						<td>Atas Nama</td>
						<td><input type="text"class="form-control" name="pemilik_rekening" value="<?php echo $pemilik_rekening;?>" required></td>
					</tr>
					<tr>
						<td>Kode OTP</td>
						<td style="whitespace:nowrap">
							<input type="number" min="0" max="9" length="1" id="otp1" name="otp1" class="otp-control">
							<input type="number" min="0" max="9" length="1" id="otp2" name="otp2" class="otp-control">
							<input type="number" min="0" max="9" length="1" id="otp3" name="otp3" class="otp-control">
							<input type="number" min="0" max="9" length="1" id="otp4" name="otp4" class="otp-control">
							<input type="number" min="0" max="9" length="1" id="otp5" name="otp5" class="otp-control">
							<input type="number" min="0" max="9" length="1" id="otp6" name="otp6" class="otp-control">
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit"class="btn btn-success" name="simpan" value="Simpan"> <input type="button"class="btn btn-primary" name="batal" value="Batalkan"></td>
					</tr>
				</tbody>
				</table>
				</form>
				<?php
				}
				else if($inputGet->getAction() == 'kelola')
				{
					?>
				<table class="table-block" width="100%" border="1" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<td>Nomor</td>
						<td>Atas Nama</td>
						<td>Status</td>
					</tr>
				</thead>
				<tbody>
					<?php
					if(isset($profile['daftar_rekening_tujuan']) && count($profile['daftar_rekening_tujuan']) > 0)
					{
					foreach($profile['daftar_rekening_tujuan'] as $data)
					{
					?>
					<tr>
						<td data-text="Nomor"><?php echo $data['nomor_rekening'];?></td>
						<td data-text="Atas Nama"><?php echo $data['nama'];?></td>
						<td data-text="Atas Nama"><?php 
						if($data['aktif'] == 1 
							&& $data['blokir_tabungan'] == 0
							&& $data['tutup'] == 0
						)
						{
							echo "Aktif";
						}
						else 
						{
							echo "Nonaktif";
						}
						?></td>
					</tr>
					<?php
					}
					}
					?>
				</tbody>
				</table>
				<div class="button-area">
				<input type="button" class="btn btn-success" name="tambah" id="tambah" value="Tambah Rekening" onclick="showDialogRekeningTujuan()">
				<input type="button" class="btn btn-primary" name="kelola" id="kelola" value="Kembali" onclick="window.location='<?php echo basename($_SERVER['PHP_SELF']);?>'">
				</div>
				
				<div class="modal fade" id="hapus-rekening" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Hapus Rekening Tujuan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						<form action="" method="get" name="formrekeningtujuan">
						<table class="table-two-side" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td>Nomor</td>
								<td><input type="hidden" name="action" value="tambah-rekening">
								<input type="text"class="form-control" name="rekening_tujuan" value=""></td>
							</tr>
							<tr>
								<td>Nama</td>
								<td><input type="text"class="form-control" name="pemilik_rekening" value=""><input type="hidden" name="data" value="{}"></td>
							</tr>
						</tbody>
						</table>
						</form>
					  </div>
					  <div class="modal-footer">						
						<button type="button" class="btn btn-primary hapus-rekening">Hapus</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
					  </div>
					</div>
				  </div>
				</div>
				<?php
				}
				else
				{
				?>
				<table class="table-block" width="100%" border="1" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<td>Nomor</td>
						<td>Atas Nama</td>
						<td>Status</td>
					</tr>
				</thead>
				<tbody>
					<?php
					if(isset($profile['daftar_rekening_tujuan']) && count($profile['daftar_rekening_tujuan']) > 0)
					{
					foreach($profile['daftar_rekening_tujuan'] as $data)
					{
					?>
					<tr>
						<td data-text="Nomor"><?php echo $data['nomor_rekening'];?></td>
						<td data-text="Atas Nama"><?php echo $data['nama'];?></td>
						<td data-text="Atas Nama"><?php 
						if($data['aktif'] == 1 
							&& $data['blokir_tabungan'] == 0
							&& $data['tutup'] == 0
						)
						{
							echo "Aktif";
						}
						else 
						{
							echo "Nonaktif";
						}
						?></td>
					</tr>
					<?php
					}
					}
					?>
				</tbody>
				</table>
				<div class="button-area">
				<input type="button" class="btn btn-success" name="tambah" id="tambah" value="Tambah Rekening" onclick="showDialogRekeningTujuan()">
				<input type="button" class="btn btn-primary" name="kelola" id="kelola" value="Kelola Rekening" onclick="window.location='<?php echo basename($_SERVER['PHP_SELF']);?>?action=kelola'">
				</div>
				
				
				<?php
				}
				?>
			</div>
			<div class="modal fade" id="tambah-rekening" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Tambah Rekening Tujuan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					</div>
					<div class="modal-body">
					<form action="" method="get" name="formrekeningtujuan">
					<table class="table-two-side" width="100%" border="0" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<td>Nomor</td>
							<td><input type="hidden" name="action" value="tambah-rekening">
							<input type="text"class="form-control" name="rekening_tujuan" value=""></td>
						</tr>
						<tr>
							<td>Nama</td>
							<td><input type="text"class="form-control" name="pemilik_rekening" value=""><input type="hidden" name="data" value="{}"></td>
						</tr>
					</tbody>
					</table>
					</form>
					</div>
					<div class="modal-footer">						
					<button type="button" class="btn btn-primary simpan-rekening">Simpan</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
					</div>
				</div>
				</div>
			</div>
        </div>

      </div>
	
  </main><!-- End #main -->

  <?php
require_once __DIR__."/inc.app/footer.php";
?>