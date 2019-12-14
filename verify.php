<!DOCTYPE html>
<html>
<head>
	<title>wennotate: Account Verified! Welcome to the World of tasks.</title>
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
		background-color: #116466;
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
			<div class="header">
				<?php 

					include("includes/connection.php");

					if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
				    // Verify data
						$email = htmlentities(mysqli_real_escape_string($con, $_GET['email']));
						#$email = mysqli_real_escape_string($_GET['email']); // Set email variable
				   		#$hash = mysqli_real_escape_string($_GET['hash']); // Set hash variable
				   		$hash = htmlentities(mysqli_real_escape_string($con, $_GET['hash']));

				   		$query = "SELECT * FROM users WHERE email='$email' AND hash='$hash' AND status='not verified'";

				   		$search = mysqli_query($con, $query);

				   		$array = mysqli_fetch_array($search);
				   		$user_id = $array['user_id'];

						$match  = mysqli_num_rows($search);

						if($match > 0){
						    // We have a match, activate the account
						    $update = "UPDATE users SET status='verified', active='yes' WHERE email='$email' AND hash='$hash' AND status='not verified'";
						    $run_update = mysqli_query($con, $update);

						    //notify
						    $insert_notification = "INSERT INTO notifications (user_from_id, user_to_id, other_id, type, status, date) VALUES ('$user_id','$user_id', '', 'welcome', 'unread', NOW())";
							$run_insert3 = mysqli_query($con, $insert_notification);

				        	echo "<div class='statusmsg'>Your account has been activated, you can now <a href='signin.php' style='color:#fd4720;'>login</a></div>";

						}else{
						    // No match -> invalid url or account has already been activated.
						}

					}else{
					    // Invalid approach
					}
	 ?>
			</div>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
</body>
</html>