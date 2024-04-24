<?php
require_once __DIR__."/inc.app/auth-with-form.php";
require_once __DIR__."/inc.app/api.php";
require_once __DIR__."/inc.app/header.php";
require_once __DIR__."/inc.app/header-nasabah.php";
if(isset($_POST['sandi_lama']) && isset($_POST['sandi_baru']) && isset($_POST['sandi_baru_ulangi']))
{
	$sandi_lama = trim($_POST['sandi_lama']);
	$sandi_baru = trim($_POST['sandi_baru']);
	$sandi_baru_ulangi = trim($_POST['sandi_baru_ulangi']);
	$nasabah_id = $profil_nasabah['nasabah_id'];
	
	$sql = "select * from nasabah where nasabah_id = '$nasabah_id' ";
	$data_nasabah = $app->get_data_from_db($sql);
	if(count($data_nasabah))
	{
		$hash = $data_nasabah[0]['otorisasi'];	
		if(password_verify($sandi_lama, $hash))
		{
			if($sandi_baru == $sandi_baru_ulangi)
			{
				$username = $data_nasabah[0]['username'];
				$options = [
				  'cost' => 11
				];
				$new_hash = addslashes(password_hash($sandi_baru, PASSWORD_BCRYPT, $options));
				$sql2 = "update nasabah set otorisasi = '$new_hash' where nasabah_id = '$nasabah_id' ";
				$app->execute_sql($sql2);
				$session = array('u'=>$username, 'p'=>$sandi_baru);
				write_session('count', 'SES_KEY', $session);
				header('Location: nasabah.php');
			}
			else
			{
			}
		} 
		else 
		{
			
		}
	}
	else
	{
	}
}
?>
  
  <main id="main">

      <div class="container">
		

        <div class="row no-gutters">
			<div class="main-comtent">
				<h4>Kata Sandi</h4>
				<form action="" method="post">
					<table class="table-two-side" width="100%" cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr>
								<td>Kode Pengguna</td>
								<td><input type="text" class="form-control" value="<?php echo $profile['username'];?>" readonly="readonly"></td>
							</tr>
							<tr>
								<td>Sandi Lama </td>
								<td><input type="password" class="form-control" name="sandi_lama"></td>
							</tr>
							<tr>
								<td>Sandi Baru </td>
								<td><input type="password" class="form-control" name="sandi_baru"></td>
							</tr>
							<tr>
								<td>Ulangi </td>
								<td><input type="password" class="form-control" name="sandi_baru_ulangi"></td>
							</tr>
							<tr>
								<td></td>
								<td><input type="submit" name="save" class="btn btn-success" value="Simpan"></td>
							</tr>				
						</tbody>
					</table>
				</form>
				
			</div>
        </div>

      </div>
	
  </main><!-- End #main -->

<?php
require_once __DIR__."/inc.app/footer.php";
?>
  