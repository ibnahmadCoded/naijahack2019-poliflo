<!DOCTYPE html>
<?php
session_start();
include("includes/header.php");
include("includes/connection.php");

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
	<title>SUBMIT TASK</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<?php 
include("includes/connection.php");


$task_id = $_GET['task_id'];

$user = $_SESSION['user_email'];
$get_user = "select user_id from users where email='$user'";
$run_user = mysqli_query($con,$get_user);
$row = mysqli_fetch_array($run_user);
			
$user_id = $row['user_id'];


$submit = "UPDATE tasks SET submitted='yes', submitted_by='$user_id' WHERE id = '$task_id'";
$run_submit = mysqli_query($con, $submit);

if($run_submit)
{


	$get_task = "SELECT cost, owner_id, media_path, type, task_question  FROM tasks WHERE id ='$task_id'"; 
	$run_task = mysqli_query($con,$get_task);
	$row = mysqli_fetch_array($run_task);

	$cost = $row['cost'] - 50; //50 goes to d company!
	$owner_id = $row['owner_id'];
	$task_question = $row['task_question'];
	$path = $row['media_path'];
	$type = $row['type'];

	if($type == "model labeling")
	{
		$link = "view_submission.php?question=$task_question&path=$path&task_id=$task_id";
	}
	elseif ($type == "transcription task") 
	{
		$link = "view_trans_submission.php?question=$task_question&path=$path&task_id=$task_id";
	}



	//notify admin by email!
	$email = "admin@mechsupport.com";

	$to = $email; // Send email to our user
	$subject = 'MECHSUPPORT | Another task has been completed!'; // Give the email a subject 
	$message = '
			 
	Thanks for your work and support!

	THis is to bring to your attantion that another task has been submitted. 

	Please check the submission out and do the needful to pay the user who completed the task.
			 
	Please click this link to view task submission:

	$link
			 
	';
		                     
	$headers = 'From:noreply@talsgrad.com' . "\r\n"; // Set from headers
	mail($to, $subject, $message, $headers); // Send our email




	//notify job owner with download link by email!
	$get_email = "SELECT email FROM users WHERE id = '$owner_id'";
	$run_email = mysqli_query($con, $get_email);
	$row_email = mysqli_fetch_array($run_email);

	$email = $row_email['email'];

	$to = $email; // Send email to our user
	$subject = 'MECHSUPPORT | Solution to your task is READY'; // Give the email a subject 
	$message = '
			 
	Thanks for using our service!
	Your task has been submitted. Although it is currently being verified by our team, you can access the task submission via the link below.
			 
	Please click this link to view task submission:

	$link
			 
	';

	$headers = 'From:noreply@talsgrad.com' . "\r\n"; // Set from headers
	mail($to, $subject, $message, $headers); // Send our email




	//load task completion page
	echo "
	<div class='container-fluid'>
		<div class='row' style='text-align: center;'>
			<div class='col-sm-12' style='display: inline-block; margin-top: 10%'>
				<h3 style='margin-bottom: 20px;'>Thank you for completing the task, your submission will be verified by our admin before the next payment cycle.<br> You are to be paid $$cost.</h3>

				<h5>Please Note that payments are made only on Thursdays of every week!</h5>

				<button class='btn btn-info' style='width: 120px; height: 50px; margin: 30px; align='center'><a href='task.php?task_id=$task_id' style='color: black;'>BACK TO TASK</a></button><br>
			</div>
		</div>
	</div>
	";

}


?>

</body>
</html>