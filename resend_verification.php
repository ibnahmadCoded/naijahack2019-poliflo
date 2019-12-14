<?php 

include("includes/connection.php");

if(isset($_GET['email'])){
	$email = $_GET['email'];

	global $con;

	$get_hash = "SELECT * FROM users WHERE email = '$email'";
	$run_hash = mysqli_query($con, $get_hash);
	$row_hash = mysqli_fetch_array($run_hash);

	$hash = $row_hash['hash'];
	$first_name = $row_hash['f_name'];

	$to = $email; // Send email to our user
	$subject = 'Signup | Verify Your wennotate Account'; // Give the email a subject 
	$message = '
			 
			Thanks for signing up!
			Your account has been created, you can start uploading tasks or doing taks by following the url link below.
			 
			Please click this link to activate your account:
			verify.php?email='.$email.'&hash='.$hash.'
			 
			'; // Our message above including the link
			                     
	$headers = 'From:noreply@wennotate.com' . "\r\n"; // Set from headers
	mail($to, $subject, $message, $headers); // Send our email

	echo "<script>alert('Activation link has been resent to you.')</script>";
	echo "<script>window.open('activate.php?name=$first_name&email=$email', '_self')</script>";
}

 ?>