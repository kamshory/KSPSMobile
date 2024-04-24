<!DOCTYPE html>
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
        <form method="post" action="">
            <h2 class="sr-only">Sandi Awal</h2>
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Masukkan Sandi"></div>
            <div class="form-group"><input class="form-control" type="password" name="password_repeat" placeholder="Ulangi Sandi"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Atur Sandi</button></div>
			<a href="aktivasi.php" class="forgot">Ulangi aktivasi</a>
		</form>
		</div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>