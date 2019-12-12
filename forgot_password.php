<!DOCTYPE html>
<html>
<head>
	<title>Recover your Mechsupport password and continue completing tasks to get paid.</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
	body{
		overflow-x: hidden; 
	}
	.main-content{
		background: #fff;
		box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
		border-radius: 30px 30px 30px 30px;
		padding: 40px 50px;
	}
	.header{
		border: 0px solid #000;
		margin-bottom: 5px;
	}
	.well{
		background-color: #87CEEB;
	}

</style>
<body>
<div class="row">
	<div class='col-sm-12'>
		<div class='well'>
			<center><h1 style='color: white;'><strong>mechsupport</strong></h1></center>
		</div>
	</div>
</div>
<div class='row'>
	<div class='col-sm-12'>
		<div class="col-sm-3"></div>
		<div class='main-content col-sm-6'>
			<div class='header'>
				<h3 style='text-align: center;'><strong>Forgot Password</strong></h3>
			</div>
			<div class='1_pass'>
				<form action='' method='post'>
					<div class='input-group'>
						<span class='input-group-addon'><i class='glyphicon glyphicon-user'></i></span>
						<input type='email' class='form-control' name='email' placeholder='Enter your Email' required>
					</div><br>
					<br>
					<pre class='text'>Enter your Bestfriend's name down below</pre>
					<div class='input-group'>
						<span class='input-group-addon'><i class='glyphicon glyphicon-pencil'></i></span>
						<input id='msg' type='text' class='form-control' name='recovery_account' placeholder='Enter bestfriend name' required>
					</div><br>
					<a style='text-decoration: none; float: right; color: #fd4720;' data-toggle='tooltip' title='Signin' href='signin.php'>Back to Signin?</a><br><br>
					<center><button id='signup' class='btn btn-info btn-lg' style="background-color: #fd4720;" name='submit'>Submit</button></center>
				</form>
			</div>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
</body>
</html>
<?php
session_start();

include("includes/connection.php");

	if (isset($_POST['submit'])) {

		$email = htmlentities(mysqli_real_escape_string($con, $_POST['email']));
		$recovery_account = htmlentities(mysqli_real_escape_string($con, $_POST['recovery_account']));

		$select_user = "SELECT * FROM users WHERE email='$email' AND recovery_account='$recovery_account'";

		$query= mysqli_query($con, $select_user);

		$check_user = mysqli_num_rows($query);

		if($check_user == 1){
			$_SESSION['user_email'] = $email;

			echo "<script>window.open('change_password.php', '_self')</script>";

		}else{
			echo"<script>alert('Your Email or Bestfriend's name is incorrect')</script>";
		}
	}
?>