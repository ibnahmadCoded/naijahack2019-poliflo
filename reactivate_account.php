<!DOCTYPE html>
<html>
<head>
	<title>Reactivate your wennotate Account. New tasks have been added. Gind tasks, complete tasks, get paid..</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
	body{
		overflow-x: hidden;
	}
	.main-content{
		width: 50%;
		height: 40%;
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
		<div class="main-content">

			<div class="header">
				<?php 

					include("includes/connection.php");
					session_start();


					if(isset($_SESSION['user_email'])){

						$email = $_SESSION['user_email'];
						$get_uname = "SELECT user_name FROM users WHERE email = '$email'";
						$run_uname = mysqli_query($con, $get_uname);
						$row_uname = mysqli_fetch_array($run_uname);

						$user_name = $row_uname['user_name'];

						if(isset($_GET['u5Nm'])){

							$u_name = $_GET['u5Nm'];

							if ($u_name == $user_name) { // don't show the deactivation link if it's not the same user!

								echo "<div class='statusmsg'>Your account has was deactivated, you can <a href='reactivated.php?u5Nm=$u_name' style='color:#fd4720;'>reactivate your account here!</a></div>";
							}else{
								echo "<div class='statusmsg'>Something went wrong, you can try to <a href='signin.php' style='color:#fd4720;'>login again</a></div>";
							}

						}

					}

				?>
			</div>
			<div class="l-part">

		
			</div>
		</div>
	</div>
</div>
</body>
</html>