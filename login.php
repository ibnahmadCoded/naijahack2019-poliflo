<?php
session_start();

include("includes/connection.php");

	if (isset($_POST['login'])) {

		$email = htmlentities(mysqli_real_escape_string($con, $_POST['email']));
		$pass = htmlentities(mysqli_real_escape_string($con, $_POST['pass']));

		$password = md5($pass);

		$select_user = "SELECT * FROM users WHERE email='$email' AND user_pass='$password'";

		$query= mysqli_query($con, $select_user);

		$row_user = mysqli_fetch_array($query);
		$verified = $row_user['status'];
		$first_name = $row_user['f_name'];
		$user_name = $row_user['user_name'];
		$active = $row_user['active'];

		if(mysqli_num_rows($query) == 1 && $verified == 'verified'){
			$_SESSION['user_email'] = $email;

			$insert_visitor = "INSERT INTO registered_visitors (user_name, date) VALUES ('$user_name', NOW())";
			$run_insert = mysqli_query($con, $insert_visitor);

			if($active == 'yes'){

				echo "<script>window.open('home.php', '_self')</script>";

			}else {

				echo "<script>window.open('reactivate_account.php?u5Nm=$user_name', '_self')</script>";
			}

		}else if(mysqli_num_rows($query) == 1 && $verified == 'not verified')

			echo "<script>window.open('activate.php?name=$first_name&email=$email', '_self')</script>";

		else{
			echo"<script>alert('Your Email or Password is incorrect')</script>";
		}
	}
?>