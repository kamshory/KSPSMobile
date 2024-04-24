<?php

use MagicObject\Request\InputGet;

require_once __DIR__."/inc.app/auth-with-form.php";
require_once __DIR__."/inc.app/api.php";

require_once __DIR__."/inc.app/header.php";
require_once __DIR__."/inc.app/header-transfer-dana.php";

$inputGet = new InputGet();
function transferInquiry($api, $auth_nasabah, $rekening_asal, $rekening_tujuan, $jumlah, $session_id)
{
	global $apiConfig;
	$nik = $auth_nasabah['nik'];
	$nasabah_id = $auth_nasabah['nasabah_id'];
	$username = $auth_nasabah['username'];
	$msisdn = $auth_nasabah['telepon'];
	$request = array(	
		"command"=>"nasabah-transfer-inquiry",
		"data"=>array(
			"sessi_id" => $session_id,
			"msisdn" => $msisdn,
			"nasabah_id" => $nasabah_id,
			"nik" => $nik,
			"username" => $username,
			"nomor_rekening_asal"=>$rekening_asal,
			"nomor_rekening_tujuan"=>$rekening_tujuan,
			"jumlah" => $jumlah

		)
	);
	
	return $api->get_data(json_encode($request));
}
function transferKonfirmasi($api, $auth_nasabah, $rekening_asal, $rekening_tujuan, $jumlah, $session_id, $otp)
{
	global $apiConfig;
	$nik = $auth_nasabah['nik'];
	$nasabah_id = $auth_nasabah['nasabah_id'];
	$username = $auth_nasabah['username'];
	$msisdn = $auth_nasabah['telepon'];
	$request = array(	
		"command"=>"nasabah-transfer-konfirmasi",
		"data"=>array(
			"sessi_id" => $session_id,
			"msisdn" => $msisdn,
			"nasabah_id" => $nasabah_id,
			"nik" => $nik,
			"username" => $username,
			"nomor_rekening_asal"=>$rekening_asal,
			"nomor_rekening_tujuan"=>$rekening_tujuan,
			"oto"=>$otp,
			"jumlah" => $jumlah

		)
	);
	
	return $api->get_data(json_encode($request));
}
?>
  
  <main id="main">
      <div class="container">
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
		$(document).on('submit', '#transferdana', function(e2){
			var nama = $('#rekening_tujuan').find('option:selected').attr('data-nama');
			var rekening_asal = $('#rekening_asal').val();
			var rekening_tujuan = $('#rekening_tujuan').val();
			var jumlah = $('#jumlah').val();
			var data = {ra:rekening_asal,na:nama,no:rekening_tujuan,ju:jumlah};
			$('#data').val(Base64.encode(JSON.stringify(data)));
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

        <div class="row no-gutters">
			<div class="main-comtent">
				<h4>Transfer Dana</h4>
				<?php
				if($inputGet->getAction() == 'konfirmasi' && $inputGet->getData() != '')
				{
					$rekening_asal = $inputGet->getRekeningAsal();;
					if($rekening_asal == '')
					{
						$rekening_asal = $profile['daftar_rekening'][0]['nomor_rekening'];
					}
					$request = array(	
						"command"=>"request-otp",
						"data"=>array(
							"nomor_rekening"=> $rekening_asal
						)
					);
					
					$response = $api->get_data(json_encode($request));
					$remote_data = json_decode($response, true);
					
					try
					{
						$data = json_decode(base64_decode($inputGet->getData()), true);
						transferInquiry($api, $auth_nasabah, @$data['ra'], @$data['no'], @$data['ju'], session_id());
					}
					catch(Exception $e)
					{
						$data = array('ra'=>'', 'na'=>'', 'no'=>'', 'ju'=>0);
					}
				?>
				<form name="transferdana" id="transferdana" method="post" action="">
					<table class="table-two-side" width="100%" cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr>
								<td>Rekening Asal</td>
								<td><input type="text" class="form-control" name="rekening_asal" value="<?php echo @$data['ra'];?>" readonly></td>
							</tr>
							<tr>
								<td>Rekening Tujuan</td>
								<td><input type="text" class="form-control" name="rekening_tujuan" value="<?php echo @$data['no'];?>" readonly></td>
							</tr>
							<tr>
								<td>Atas Nama</td>
								<td><input type="text" class="form-control" name="pemilik_rekening" value="<?php echo @$data['na'];?>" readonly></td>
							</tr>
							<tr>
								<td>Jumlah</td>
								<td><input type="number" step="any" min="10000" max="5000000" class="form-control" name="jumlah" value="<?php echo @$data['ju']*1;?>" readonly></td>
							</tr>
							<tr>
								<td>Kode Konfirmasi</td>
								<td style="white-space: nowrap;">
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
								<td>
								<input type="hidden" name="action" value="konfirmasi">
								<input type="hidden" name="data" id="data" value="">
								<input type="submit" class="btn btn-success" name="transfer" id="transfer" value="Transfer">
								<input type="button" class="btn btn-primary" name="batal" id="batal" value="Batalkan">
								</td>
							</tr>
						</body>
					</table>
				</form>	
				
				<?php
				}
				else
				{
				?>
				<form name="transferdana" id="transferdana" method="get" action="">
					<table class="table-two-side" width="100%" cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr>
								<td>Rekening Asal</td>
								<td><select id="rekening_asal" class="form-control">
								<?php
								foreach($profile['daftar_rekening'] as $data)
								{
									if($data['aktif'] == 1 
										&& $data['blokir_tabungan'] == 0
										&& $data['tutup'] == 0
									)
									{
								?>
									<option value="<?php echo $data['nomor_rekening'];?>" data-nama="<?php echo $data['nama'];?>"><?php echo $data['nomor_rekening'];?> - <?php echo $data['nama'];?></option>
								<?php
									}
								}
								?>								
								</select>
								</td>
							</tr>
							<tr>
								<td>Rekening Tujuan</td>
								<td><select id="rekening_tujuan" class="form-control">
								<?php
								foreach($profile['daftar_rekening_tujuan'] as $data)
								{
									if($data['aktif'] == 1 
										&& $data['blokir_tabungan'] == 0
										&& $data['tutup'] == 0
									)
									{
								?>
									<option value="<?php echo $data['nomor_rekening'];?>" data-nama="<?php echo $data['nama'];?>"><?php echo $data['nomor_rekening'];?> - <?php echo $data['nama'];?></option>
								<?php
									}
								}
								?>								
								</select>
								</td>
							</tr>
							<tr>
								<td>Jumlah</td>
								<td><input type="number" step="any" min="10000" max="5000000" class="form-control" id="jumlah"></td>
							</tr>
							<tr>
								<td>PIN Anda</td>
								<td><input type="password" class="form-control" id="in"></td>
							</tr>
							<tr>
								<td></td>
								<td>
									<input type="hidden" name="action" value="konfirmasi">
									<input type="hidden" name="data" id="data" value="">
									<input type="submit" class="btn btn-success" name="transfer" id="transfer" value="Transfer">
								</td>
							</tr>
						</body>
					</table>
				</form>	
				<?php
				}
				?>
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