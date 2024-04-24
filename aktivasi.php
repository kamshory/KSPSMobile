<?php

use KSPSMobile\GlobalFunction;
use MagicObject\Request\InputGet;
use MagicObject\Request\InputPost;
use MagicObject\Request\PicoFilterConstant;

require_once __DIR__ . "/lib.inc/config.php";
require_once __DIR__ . "/lib.inc/session.php";
require_once __DIR__ . "/lib.inc/aes.php";
require_once __DIR__ . "/lib.inc/api.php";

$inputGet = new InputGet();
$inputPost = new InputPost();

if ($inputPost->getAction() == 'aktivasi' && $inputPost->issetData()) {
	$kode_aktivasi = $inputPost->getData();
	$request = array(
		"command" => "aktivasi-akun",
		"data" => array(
			"kode_aktivasi" => $kode_aktivasi
		)
	);
	$response = $api->getData(json_encode($request));
	
	$remote_data = json_decode($response, true);
	if ($remote_data['response_code'] == '001') {
		$aktivasi = hash('sha256', $kode_aktivasi . "-" . time() . "-" . mt_rand(111111, 999999));
		$token_aktivasi = hash('sha256', $aktivasi);
		$nasabah_id = $remote_data['data']['data_nasabah'][0]['nasabah_id'];

		$nama = addslashes(@$remote_data['data']['data_nasabah'][0]['nama']);
		$username = addslashes(@$remote_data['data']['data_nasabah'][0]['username']);
		$nik = addslashes(@$remote_data['data']['data_nasabah'][0]['nik']);
		$nkk = addslashes(@$remote_data['data']['data_nasabah'][0]['nkk']);
		$email = addslashes(@$remote_data['data']['data_nasabah'][0]['email']);
		$telepon = addslashes(@$remote_data['data']['data_nasabah'][0]['telepon']);
		$telepon_sekunder = addslashes(@$remote_data['data']['data_nasabah'][0]['telepon_sekunder']);
		$telepon_tersier = addslashes(@$remote_data['data']['data_nasabah'][0]['telepon_tersier']);
		$jenis_kelamin = addslashes(@$remote_data['data']['data_nasabah'][0]['jenis_kelamin']);
		$tanggal_lahir = addslashes(@$remote_data['data']['data_nasabah'][0]['tanggal_lahir']);
		$aktif = (@$remote_data['data']['data_nasabah'][0]['aktif'])?'true':'false';

		$sql = "select * from nasabah where nasabah_id = '$nasabah_id' ";
		

		if ($app->get_num_row_from_db($sql)) {
			$sql = "UPDATE `nasabah` SET 
				`username` = '$username', `token_aktivasi` = '$token_aktivasi', `nama` = '$nama', 
				`jenis_kelamin` = '$jenis_kelamin', `tanggal_lahir` = '$tanggal_lahir', 
				`email` = '$email', `telepon` = '$telepon', `telepon_sekunder` = '$telepon_sekunder', 
				`telepon_tersier` = '$telepon_tersier', `nik` = '$nik', `nkk` = '$nkk', 
				`waktu_ubah` = now(), `blokir` = '0', `aktif` = true
				WHERE `nasabah_id` = '$nasabah_id';
				";

			$app->execute_sql($sql);
		} else {
			$sql = "insert into nasabah
				(nasabah_id, nama, nik, nkk, email, telepon, telepon_sekunder, username, token_aktivasi,
					telepon_tersier, jenis_kelamin, tanggal_lahir, waktu_buat, aktif) values
				('$nasabah_id', '$nama', '$nik', '$nkk', '$email', '$telepon', '$telepon_sekunder', '$username', '$token_aktivasi',
					'$telepon_tersier', '$jenis_kelamin', '$tanggal_lahir', now(), $aktif);
				";

			$app->execute_sql($sql);
		}
		if (isset($remote_data['data']['data_rekening']) && count($remote_data['data']['data_rekening']) > 0) {
			foreach ($remote_data['data']['data_rekening'] as $data) {
				$rekening_id = 1 * $data['rekening_id'];
				$nomor_rekening = addslashes($data['nomor_rekening']);
				$nama = addslashes($data['nama']);
				$utama = 0;
				$blokir_tabungan = 1 * $data['blokir_tabungan'];
				$blokir_pembiayaan = 1 * $data['blokir_pembiayaan'];
				$dorman = $data['dorman']?'true':'false';
				$tutup = $data['tutup']?'true':'false';
				$aktif = $data['aktif']?'true':'false';
				$waktu_buat = addslashes($data['waktu_buat']);
				$waktu_ubah = addslashes($data['waktu_ubah']);

				$sql = "select * from rekening where rekening_id = '$rekening_id' ";

				if ($app->get_num_row_from_db($sql)) {
					$sql = "UPDATE `rekening` SET 
					`nasabah_id` = '$nasabah_id', `nomor_rekening` = '$nomor_rekening', 
					`nama` = '$nama', `blokir_tabungan` = '$blokir_tabungan', 
					`blokir_pembiayaan` = '$blokir_pembiayaan', `dorman` = '$dorman',
					`tutup` = '$tutup',`waktu_ubah` = now(),`aktif` = $aktif
					WHERE `rekening_id` = '$rekening_id';
					";
					$app->execute_sql($sql);

				} else {
					$sql = "INSERT INTO `rekening` 
						(rekening_id, nasabah_id, nomor_rekening, nama, utama, blokir_tabungan, 
						blokir_pembiayaan, dorman, tutup, waktu_buat, waktu_ubah, aktif) VALUES
						('$rekening_id', '$nasabah_id', '$nomor_rekening', '$nama', '$utama', $blokir_tabungan, 
						'$blokir_pembiayaan', $dorman, $tutup, '$waktu_buat', '$waktu_ubah', $aktif);
					";

					$app->execute_sql($sql);
				}
			}
		}
		if (isset($remote_data['data']['data_pembiayaan']) && count($remote_data['data']['data_pembiayaan']) > 0) {
			foreach ($remote_data['data']['data_pembiayaan'] as $data) {
				$pembiayaan_id = $data['pembiayaan_id'];
				$nomor_pembiayaan = addslashes($data['nomor_pembiayaan']);
				$nama = addslashes($data['nama']);
				$utama = 'false';
				$lunas = $data['lunas']?'true':'false';
				$aktif = $data['aktif']?'true':'false';
				$waktu_buat = addslashes($data['waktu_buat']);
				$waktu_ubah = addslashes($data['waktu_ubah']);

				$sql = "select * from pembiayaan where pembiayaan_id = '$pembiayaan_id' ";

				if ($app->get_num_row_from_db($sql)) {
					$sql = "UPDATE `pembiayaan` SET 
					`nomor_pembiayaan` = '$nomor_pembiayaan',`nama` = '$nama', `lunas` = '$lunas', `waktu_ubah` = now(), `aktif` = 1 
					WHERE `pembiayaan_id` = '$pembiayaan_id';
					";
					$app->execute_sql($sql);

				} else {
					$sql = "INSERT INTO `pembiayaan` 
						(pembiayaan_id, nasabah_id, nomor_pembiayaan, nama, utama, 
						lunas, waktu_buat, waktu_ubah, aktif) VALUES
						('$pembiayaan_id', '$nasabah_id', '$nomor_pembiayaan', '$nama', $utama, 
						$lunas, '$waktu_buat', '$waktu_ubah', $aktif);
					";
 
					$app->execute_sql($sql);
				}
			}
		}

		header("Location: aktivasi.php?action=set-password&auth=$token_aktivasi");
	} 
	else 
	{
		header("Location: aktivasi.php");
	}
} 
else if ($inputGet->getAction() == 'set-password' && $inputGet->issetAuth()) 
{
	$auth = $input->getAuth(PicoFilterConstant::FILTER_SANITIZE_SPECIAL_CHARS);
	if ($auth != '') {
		$sql = "select * from nasabah where token_aktivasi = '$auth' ";
		$data = $app->get_data_from_db($sql);
		if (!empty($data)) {
			if (isset($_POST['password']) && isset($_POST['password_repeat']) && @$_POST['password'] == @$_POST['password_repeat'] && strlen(trim($_POST['password'])) >= 6) {
				$password = trim(@$_POST['password']);
				$options = [
					'cost' => 11
				];
				$hash = addslashes(password_hash($password, PASSWORD_BCRYPT, $options));

				$nasabah_id = $data[0]['nasabah_id'];
				$username = $data[0]['username'];

				$sql = "update nasabah set otorisasi = '$hash' 
					where token_aktivasi = '$auth' and nasabah_id = '$nasabah_id' ";
				$app->execute_sql($sql);

				$session = array('u' => $username, 'p' => $password);
				GlobalFunction::write_session('count', 'SES_KEY', $session);

				header('Location: index.php');
			} else {
				include_once dirname(__FILE__) . "/sandi-pertama.php";
				exit();
			}
		} else {
			header("Location: aktivasi.php");
			exit();
		}
	} else {
		header("Location: aktivasi.php");
		exit();
	}
} else {
?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<title><?php echo $app->get_app_name(); ?></title>
		<!-- Favicons -->
		<link rel="icon" href="favicon.png">
		<link rel="apple-touch-icon" href="apple-touch-icon.png">
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/style.css">
		<link rel="stylesheet" href="assets/css/login.css">

		<script src="assets/vendor/jquery/jquery.min.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="assets/js/jsQR.js"></script>

		<style>
			#githubLink {
				position: absolute;
				right: 0;
				top: 12px;
				color: #2D99FF;
			}

			h1 {
				margin: 10px 0;
				font-size: 40px;
			}

			#loadingMessage {
				text-align: center;
				padding: 40px;
				background-color: #eee;
			}

			#canvas {
				width: 280px;
			}

			#output {
				margin-top: 20px;
				background: #eee;
				padding: 10px;
				padding-bottom: 0;
			}

			#output div {
				padding-bottom: 10px;
				word-wrap: break-word;
			}

			#noQRFound {
				text-align: center;
			}

			.all {
				padding: 20px;
			}

			.modal-header {
				display: block;
			}
		</style>
	</head>

	<body>
		<div class="login-dark">
			<div class="form">
				<form method="post" action="">
					<p style="text-align:center">Aktivasi Akun</p>
					<div id="loadingMessage" hidden="">⌛ Loading video...</div>
					<canvas id="canvas" height="280" width="280"></canvas>
					<div class="form-group"><button class="btn btn-primary btn-block" type="button" onclick="window.location='./'">Kembali</button></div>
					<div id="status" style="display: none;"></div>
					<div id="test"></div>
				</form>
			</div>
		</div>

		<div class="modal fade" role="dialog" id="alert">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Aktivasi Sedang Berjalan</h4>
					</div>
					<div class="modal-body">
						<p>Sistem sedang melakukan verfikasi data nasabah.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					</div>
				</div>
			</div>
		</div>

		<script>
			var video = document.createElement("video");
			var canvasElement = document.getElementById("canvas");
			var canvas = canvasElement.getContext("2d");
			var loadingMessage = document.getElementById("loadingMessage");

			function drawLine(begin, end, color) {
				canvas.beginPath();
				canvas.moveTo(begin.x, begin.y);
				canvas.lineTo(end.x, end.y);
				canvas.lineWidth = 4;
				canvas.strokeStyle = color;
				canvas.stroke();
			}

			// Use facingMode: environment to attemt to get the front camera on phones
			var lastTime = 0;
			navigator.mediaDevices.getUserMedia({
				video: {
					facingMode: "environment"
				}
			}).then(function(stream) {
				video.srcObject = stream;
				video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
				video.play();
				var ct = (new Date()).getTime();
				if ((ct - lastTime) > 100) {
					lastTime = ct;
					requestAnimationFrame(tick);
				}
			});

			var formEnable = true;

			function tick() {
				loadingMessage.innerText = "⌛ Loading video..."
				if (video.readyState === video.HAVE_ENOUGH_DATA) {
					loadingMessage.hidden = true;
					canvasElement.hidden = false;

					canvasElement.height = video.videoHeight;
					canvasElement.width = video.videoWidth;
					canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
					var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
					var code = jsQR(imageData.data, imageData.width, imageData.height, {
						inversionAttempts: "dontInvert",
					});
					if (code) {
						drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
						drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
						drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
						drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");
						if (code.data.length > 4 && formEnable) {
							console.log(code.data);
							document.querySelector('#action').value = 'aktivasi';
							document.querySelector('#data').value = code.data;
							document.querySelector('#hiddenform').submit();
							formEnable = false;
							$('#alert').modal();
						} 
					} else {}
				}
				requestAnimationFrame(tick);
			}
		</script>
		<form id="hiddenform" action="aktivasi.php" method="post" style="position: absolute; left:-1000000px; top:-10000000px ;">
			<input type="hidden" name="action" id="action" value="">
			<input type="hidden" name="data" id="data" value="">
		</form>
	</body>

	</html>
<?php
}
?>