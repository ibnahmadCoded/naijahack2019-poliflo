<!DOCTYPE html>
<html>
<head>
	<title>wennotate | activate account</title>
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
		margin: 10px auto;
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
	#signin{
		width: 60%;
		border-radius: 30px;
		background-color: #87CEEB;
	}
	.overlap-text{
		position: relative;
	}
	.overlap-text a{
		position: absolute;
		top: 8px;
		right: 10px;
		font-size: 14px;
		text-decoration: none;
		font-family: 'Overpass Mono', monospace;
		letter-spacing: -1px;

	}
</style>
<body>
<div class="row">
	<div class="col-sm-12">
		<div class="well">
			<center><h1 style="color: white;">wennotate</h1></center>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="col-sm-3"></div>
		<div class="main-content col-sm-6">
			<div class="card-header">
				<h3 style="text-align: center;"><strong>Login to wennotate</strong></h3>
			</div>
			<div class="card">
				<?php 

	include("includes/connection.php");

		if(isset($_GET['name'], $_GET['email'])){
			$first_name = $_GET['name'];
			$email = $_GET['email'];
		}
	 ?>
				<p><center>Thank you <?php echo "$first_name";?> for signing up! You are one more step away from having your wennotate account!</center></p><br><br>
				<p><center>Please check your email for an activation link which will lead you to your account</center></p><br><br>
				<a href="resend_verification.php?email=<?php echo $email ?>" style="float: left; color: #fd4720;">Resend link?</a>
				<a href="index.php" style="float: right; color: #fd4720;">Go back!</a>
			</div>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
</body>
</html>