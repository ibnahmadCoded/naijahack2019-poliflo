<?php
include("includes/connection.php");

	if(isset($_POST['sign_up'])){

		$first_name = htmlentities(mysqli_real_escape_string($con,$_POST['first_name']));
		$last_name = htmlentities(mysqli_real_escape_string($con,$_POST['last_name']));
		$pass = htmlentities(mysqli_real_escape_string($con,$_POST['u_pass']));
		$email = htmlentities(mysqli_real_escape_string($con,$_POST['u_email']));
		$country = htmlentities(mysqli_real_escape_string($con,$_POST['u_country']));
		$gender = htmlentities(mysqli_real_escape_string($con,$_POST['u_gender']));
		#$birthday = htmlentities(mysqli_real_escape_string($con,$_POST['u_birthday']));
		$best_friend = htmlentities(mysqli_real_escape_string($con,$_POST['best_friend']));
		$status = "not verified";
		$hash = md5( rand(0,1000) ); // Generate random 32 character hash and assign it to a local variable.
		// Example output: f4552671f8909587cf485ea990207f3b
		$posts = "no";
		$active = "no";
		$newgid = sprintf('%05d', rand(0, 999999));

		$u_name = strtolower($first_name . "_" . $last_name . "_" . $newgid);

		$u_nom = md5($u_name);

		$username = base64_encode(sha1($u_nom));
		$check_username_query = "select user_name from users where user_email='$email'";
		$run_username = mysqli_query($con,$check_username_query);

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $emailErr = "Invalid email format";}

		if(strlen($pass) <9 ){
			echo"<script>alert('Password should be minimum 9 characters!')</script>";
			exit();
		} else {
			$password = md5($pass);
		}

		$check_email = "SELECT * FROM users WHERE email='$email'";

		$run_email = mysqli_query($con,$check_email);

		if(mysqli_num_rows($run_email) == 1){
			echo "<script>alert('Email already exist, Please try using another email')</script>";
			echo "<script>window.open('signup.php', '_self')</script>";
			exit();
		}

		$rand = rand(1, 3); //Random number between 1 and 3

			if($rand == 1)
				$profile_pic = "star.png";
			else if($rand == 2)
				$profile_pic = "bulb.jpg";
			else if($rand == 3)
				$profile_pic = "intelligence.jpg";

		$sql = "INSERT INTO users (f_name,l_name,user_name,describe_user,Relationship,user_pass,email,user_country,user_gender,user_image,user_cover,user_reg_date,status, hash, posts,recovery_account, last_activity, active)
		VALUES ('$first_name','$last_name','$username','Hello Talsgrad.This is my default status!','...','$password','$email','$country','$gender','$profile_pic','default_cover.jpg',NOW(),'$status', '$hash', '$posts','$best_friend', NOW(), '$active')";
		
		if ($con->query($sql) === TRUE) {

			$to      = $email; // Send email to our user
			$subject = 'Signup | Verify Your Talsgrad Account'; // Give the email a subject 
			$message = '
			 
			Thanks for signing up!
			Your account has been created, you can set up your portfolio account and update your profile with portfolio items after you have activated your account by pressing the url link below.
			 
			Please click this link to activate your account:
			http://www.talsgrad.com/verify.php?email='.$email.'&hash='.$hash.'
			 
			'; // Our message above including the link
			                     
			$headers = 'From:noreply@talsgrad.com' . "\r\n"; // Set from headers
			mail($to, $subject, $message, $headers); // Send our email

			#echo "<script>alert('Well Done $first_name, you are good to go.')</script>";
			echo "<script>window.open('activate.php?name=$first_name&email=$email', '_self')</script>";
		} else 
		{
			echo "<script>alert('Registration failed, please try again!')</script>";
			echo "<script>window.open('signup.php', '_self')</script>";
		}
	}

$con->close();
?>