<!DOCTYPE html>
<?php
session_start();
include("includes/header.php");

if(!isset($_SESSION['user_email'])){

	session_destroy();
	
	header("location: index.php");
}

if(isset($_SESSION['user_email'])){

	$email = $_SESSION['user_email'];
}

$update_activity = "UPDATE users SET last_activity = NOW() WHERE email = '$email'";
$run_update = mysqli_query($con, $update_activity);

?>
<html>
<head>
	<title>Account Settings on wennotate. Find tasks, complete tasks, get paid.</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
	<style>

	#show_likes{
	background: #fff;
		box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
		border-radius: 30px 30px 30px 30px;
		padding: 40px 50px;
}
	</style>
</head>
<body>
<div class="row">
	<div class="col-sm-12">

		<center><h2>Account Settings</h2></center><br><br>
		<div class="row">
			<div class="col-sm-4">
			</div>
			<div class="col-sm-4">
			</div>
		</div><br><br>
					<div class='row'>
						<div class='col-sm-3'>
						</div>
						<div class='col-sm-6'>
							<div class='row' id='show_likes'>
								<div class='col-sm-6'>
									<?php 


									if(isset($_SESSION['user_email'])){

										$email = $_SESSION['user_email'];
										$get_uname = "SELECT user_name FROM users WHERE email = '$email'";
										$run_uname = mysqli_query($con, $get_uname);
										$row_uname = mysqli_fetch_array($run_uname);

										$user_name = $row_uname['user_name'];

										if(isset($_GET['u5Nm'])){

											$u_name = $_GET['u5Nm'];

											if ($u_name == $user_name) { // don't show the deactivation link if it's not the same user!

												echo "<a style='text-decoration:none; cursor:pointer; color:#fd4720;' href='deactivate_account.php?u5Nm=$u_name'><strong><p>Deactivate your account</p></strong></a>";
											}

										}

									}

									 ?>
								</div>
								<div class='col-sm-3'>
								</div>
							</div>
							<div class='col-sm-4'>
							</div>
						</div><br>
					</div>

	</div>
</div>
</body>
</html>