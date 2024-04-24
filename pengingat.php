<?php

use MagicObject\Request\InputGet;
use MagicObject\Request\PicoFilterConstant;

date_default_timezone_set("Asia/Jakarta");
require_once __DIR__."/inc.app/auth-with-form.php";
require_once __DIR__."/inc.app/api.php";

function get_jam_loket_buka($remote_data, $hari)
{
	if(isset($remote_data['data']['data_jam_loket']) 
		&& count($remote_data['data']['data_jam_loket']) > 0)
	{
		foreach($remote_data['data']['data_jam_loket'] as $data)
		{
			if($data['kode_huruf'] == $hari)
			{
				return $data['jam_buka_teller'];
			}
		}
	}
	return "06:00:00";
}
function get_jam_loket_tutup($remote_data, $hari)
{
	if(isset($remote_data['data']['data_jam_loket']) 
		&& count($remote_data['data']['data_jam_loket']) > 0)
	{
		foreach($remote_data['data']['data_jam_loket'] as $data)
		{
			if($data['kode_huruf'] == $hari)
			{
				return $data['jam_tutup_teller'];
			}
		}
	}
	return "18:00:00";
}
function is_loket_buka($remote_data, $hari)
{
	if(isset($remote_data['data']['data_jam_loket']) 
		&& count($remote_data['data']['data_jam_loket']) > 0)
	{
		foreach($remote_data['data']['data_jam_loket'] as $data)
		{
			if($data['kode_huruf'] == $hari)
			{
				return $data['teller_buka'];
			}
		}
	}
}

function download_calendar($str)
{
	$str = str_replace("\n", "\r\n", $str);
	$str = str_replace("\r\r\n", "\r\n", $str);

	$str = str_replace("\r", "\r\n", $str);
	$str = str_replace("\r\n\n", "\r\n", $str);
	$str = str_replace("\r\n", "\\n", $str);

	

$calendarData = json_decode($str, true);
$calendarData['data']['beginTime'] = gmdate('Y-m-d H:i:s', strtotime($calendarData['data']['beginTime']));
$calendarData['data']['endTime'] = gmdate('Y-m-d H:i:s', strtotime($calendarData['data']['endTime']));

$ical = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
BEGIN:VEVENT
UID:" . md5(uniqid(mt_rand(), true)) . "
DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z
DTSTART:".str_replace(array(' ', '-',':'), array('T', '', ''), $calendarData['data']['beginTime'])."Z
DTEND:".str_replace(array(' ', '-',':'), array('T', '', ''), $calendarData['data']['endTime'])."Z
LOCATION:".$calendarData['data']['eventLocation']."
SUMMARY:".$calendarData['data']['description']."
END:VEVENT
END:VCALENDAR";

return $ical;
}

if(isset($_POST['download']) && isset($_POST['data']))
{
	header("Content-Type: text/x-vCalendar");
	header("Content-Disposition: attachment; filename=\"Pengingat Cicilan.ics\"");
	echo download_calendar($_POST['data']);
	exit();
}
$nasabah_id = $profile['nasabah'];

$inputGet = new InputGet();
$nomor_pembiayaan = $inputGet->getNomorPembiayaan(PicoFilterConstant::FILTER_SANITIZE_SPECIAL_CHARS);

if($nomor_pembiayaan == '')
{
	if(isset($profile['daftar_pembiayaan']) 
		&& count($profile['daftar_pembiayaan']) > 0)
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
			"data_tagihan"=>array(
				"nomor_pembiayaan"=>$nomor_pembiayaan
			),
			"data_loket_pembayaran"=>array(
				"nomor_pembiayaan"=>$nomor_pembiayaan
			)
		)
	)
);
$response = $api->getData(json_encode($request));
$remote_data = json_decode($response, true);

require_once __DIR__."/inc.app/header.php";
require_once __DIR__."/inc.app/header-pengingat.php";
?>
  <style type="text/css">
  .pengingat-tagihan{
	  list-style-type:none;
	  margin:0;
	  padding:0;
  }
  .pengingat-tagihan li{
	  margin: 0 0 10px 0;
	  padding: 2px 0 10px 0;
	  border-bottom:1px dotted #DDDDDD;
  }
  .pengingat-tagihan li a{
	  color:#FFFFFF;
  }
  .float-right{
	float:right;
	margin-top:-8px;
  }
  </style>
  <script type="text/javascript">
	function downloadCalendar(calendarData)
	{
        if(typeof Android !== "undefined" && Android !== null) 
		{
            Android.getCalendar(calendarData);
		} 
		else 
		{
			$('#calendar #data').val(calendarData);
			$('#calendar').submit();
        }
	}
  </script>
  <main id="main">
	  <form action="pengingat.php" id="calendar" method="post">
		<input type="hidden" name="download" value="download">
		<input type="hidden" name="data" id="data">
	  </form>
      <div class="container">
		

        <div class="row no-gutters">
			<div class="main-comtent">
				<div class="content-tabs">
					<div class="content-tab active" data-id="cicilan">
					  <h4>Pengingat Cicilan</h4>
					  <ul class="pengingat-tagihan">
						<?php
						$loket = '';
						$alamat = '';
						$tanggal_sekarang = date('Y-m-d');
						if(isset($remote_data['data']['data_loket_pembayaran']) 
							&& count($remote_data['data']['data_loket_pembayaran']) > 0)
						{
							$alamat = $remote_data['data']['data_loket_pembayaran'][0]['alamat'];
						}
						if(isset($remote_data['data']['data_loket_pembayaran']) 
							&& count($remote_data['data']['data_loket_pembayaran']) > 0)
						{
							$loket = $remote_data['data']['data_loket_pembayaran'][0]['nama_cabang'];
							if($loket != '')
							{
								$loket = $loket."\r\nAlamat : ";
							}
						}
						if(isset($remote_data['data']['data_tagihan']) 
							&& count($remote_data['data']['data_tagihan']) > 0
						)
						{
							$hari_ini = date('Y-m-d');
							foreach($remote_data['data']['data_tagihan'] as $data)
							{
								if($data['lunas'] == 0 || $data['denda_sisa'] > 0)
								{
									$jatuh_tempo = strtotime($data['jatuh_tempo']);
									$kode_hari = strtoupper(date('D', $jatuh_tempo));
									while(!is_loket_buka($remote_data, $kode_hari))
									{
										$jatuh_tempo -= 86400;
										$kode_hari = strtoupper(date('D', $jatuh_tempo));
									};
									$jam_buka = get_jam_loket_buka($remote_data, $kode_hari);
									$jam_tutup = get_jam_loket_tutup($remote_data, $kode_hari);
									$calendar = array(
										"command"=> "add-calendar",
										"data"=> array(
											"title"=> "Pembayaran Cicilan Ke ".$data['ke'],
											"description"=> "Pembayaran Cicilan Koperasi Albasiko Sebesar Rp "
												.format_bilangan($data['total_sisa']+$data['denda']),
											"eventLocation"=>trim($loket." ".$alamat),
											"beginTime"=> date('Y-m-d', $jatuh_tempo)." ".$jam_buka,
											"endTime"=> date('Y-m-d', $jatuh_tempo)." ".$jam_tutup,
											"displayColor"=> "#339944"
											)
										);
										$tanggal_jatuh_tempo = date('Y-m-d', $jatuh_tempo);
							?>
								<li><?php echo GlobalFunction::translate_date(date('l, j M Y', $jatuh_tempo));?><?php

								if($tanggal_jatuh_tempo	> $hari_ini)
								{
									?>
									<span class="reminder btn btn-success float-right"><a 
									href="javascript:downloadCalendar('<?php 
									echo htmlspecialchars(json_encode($calendar));?>');">Ingatkan</a></span>
									<?php
								}
								else if($tanggal_jatuh_tempo == $hari_ini)
								{
									?>
									<span class="float-right btn btn-primary">Pembayaran Hari Ini</span>
									<?php
								}
								else
								{
									?>
									<span class="float-right btn btn-primary">Denda <?php echo format_bilangan($data['denda_sisa']);?></span>
									<?php
								}
								?>
									</li>
							<?php
								}
							}
						}
						?>						
						
					  </ul>
					</div>  
				</div>
			</div>
        </div>

      </div>
	
  </main><!-- End #main -->

  <?php
require_once __DIR__."/inc.app/footer.php";
?>