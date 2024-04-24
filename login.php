<?php
require_once __DIR__."/inc.app/config.php";
require_once __DIR__."/inc.app/session.php";
require_once __DIR__."/inc.app/aes.php";

if(isset($_POST['username']) && isset($_POST['password']))
{
	$username = addslashes(trim($_POST['username'], " \t\r\n "));
	$password = trim($_POST['password']);
	$sql = "select * from nasabah where username='$username' ";
	$data_nasabah = $app->get_data_from_db($sql);
	if(count($data_nasabah))
	{
		$hash = $data_nasabah[0]['otorisasi'];	
		if(password_verify($password, $hash))
		{
			$session = array('u'=>$username, 'p'=>$password);
			write_session('count', 'SES_KEY', $session);
			header('Location: index.php');
		} 
		else 
		{
			
		}
	}
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo $app->get_app_name();?></title>
	<link href="favicon.png" rel="icon">
	<link href="apple-touch-icon.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <div class="login-dark">
		<div class="form">
        <form method="post">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <div class="form-group"><input class="form-control" type="username" name="username" placeholder="Kode Pengguna"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Sandi"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Masuk</button></div>
			<a href="index.php" class="forgot">Lupa sandi? Klik di sini</a>
			<a href="aktivasi.php" class="forgot">Belum terdaftar? Aktivasi di sini</a>
		</form>
		</div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>