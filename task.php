<!DOCTYPE html>
<?php
#session_start();
include("includes/connection.php");

// if(!isset($_SESSION['user_email'])){

//     session_destroy();
    
//     header("location: index.php");
// }

// if(isset($_SESSION['user_email'])){

//     $email = $_SESSION['user_email'];
// }

// $update_activity = "UPDATE users SET last_activity = NOW() WHERE email = '$email'";
// $run_update = mysqli_query($con, $update_activity);

?>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
  	<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

	<?php 

		date_default_timezone_set('Africa/Lagos');

		$task_id = 1; //this variable will be passed to this page from homepage&submit page, on clicking a task!
		$user_id = 1;
		$admin_id = 0; 

		$get_task = "SELECT * FROM tasks WHERE id ='$task_id'"; 
		$run_task = mysqli_query($con,$get_task);
		$row = mysqli_fetch_array($run_task);

		$owner_id = $row['owner_id'];
		$title = $row['title'];
		$type = $row['type'];
		$description = $row['description'];
		$media_path = $row['media_path'];
		$submitted = $row['submitted'];
		$submitted_by = $row['submitted_by'];
		$expiration_date = $row['expiration_date'];
		$cost = $row['cost'];
		$acceptable_users = $row['acceptable_users'];
		$attached_users = $row['attached_users'];
		$created_at = $row['created_at'];
		$pay_received = $row['pay_received'];
		$job_seeker_paid = $row['job_seeker_paid'];
		$task_question = $row['task_question'];

		// $output1 = date("d - M - Y H:i:s", strtotime($created_at));
		$output2 = date("d - M - Y H:i:s", strtotime($expiration_date));

		//dont show task if it does not exist

		if (mysqli_num_rows($run_task) != 0) 
		{ 
			//task exists
			echo "<div class='container-fluid'>

				<div class='row'>
						
						<center><h1>Task Title: $title</h1></center><br>

						<div class='col-sm-6'>

							<center><h3>TASK DETAILS</h3></center>
							
							<p><b>Title: </b>$title </p>
							<p><b>Up until: </b> $output2 </p>
							<p><b>Amount payable:</b> $$cost - 50 </p>
							<p><b>Task Question: </b>$task_question</p>
							<center><p><b>Task Description</b></p></center>
							<p>$description </p>
								

							

						</div>

						<div class='col-sm-6' style='text-align: center;'>
							<center><h3>CONTINUE TO TASK</h3></center>
							<p><b>NOTE: The first person to finish this task will be paid!</b></p>

							<div class='col-sm-12' style='display: inline-block; margin-top: 30%'>

								<p><b>Number of People currently doing this task: </b>$attached_users </p>
								<p><b>Possible Number of People for this task:</b> $acceptable_users </p> ";

								//check the task type, and the link accordingly!
								// begin task sends the task ID to next media page OR sends the task question and media path only. OR sends the three parameters! FROM DB
								//the page it passes the parameters to is dependent on the type of task (labeling links to next_media; transcription links to transcribe_next).

								if ($type == "transcription task") 
								{
									if ($acceptable_users !== $attached_users && $submitted != 'yes')
									{
										//change button to input type to run files creation script when clicked and
										echo "
								  		<button class='btn btn-info' style='width: 100%; height: 50px;''><a href='next_transcription.php?media_file=0&question=$task_question&path=$media_path&task_id=$task_id' style='color: black; font-size: 25px;''>BEGIN TASK</a></button>
								  		"; 
									}

									else if ($submitted == 'yes')
									{
										if($user_id == $submitted_by || $user_id == $owner_id || $user_id == $admin_id)
										{
											//show the view submission button
											echo "<button class='btn btn-info' style='width: 100%; height: 50px;'><a href='view_trans_submission.php?question=$task_question&path=$media_path&task_id=$task_id' style='color: black; font-size: 25px;'>VIEW SUBMISSION</a></button>";

										}
										else
										{
											echo "<h3>Sorry! You cannot do this task because it has been completed and submitted by a user.</h3>";
										}
									}

									else
									{
										echo "<h3>Sorry! You cannot do this task because it is currently fully occupied.</h3>";
									}
									
								}

								else if ($type == "model labeling") 
								{
									if ($acceptable_users !== $attached_users && $submitted != 'yes')
									{
										echo "
								  		<button class='btn btn-info' style='width: 100%; height: 50px;'><a href='next_media.php?media_file=0&question=$task_question&path=$media_path&task_id=$task_id' style='color: black; font-size: 25px;'>BEGIN TASK</a></button>
								  		";  
									}

									else if ($submitted == 'yes')
									{
										if($user_id == $submitted_by || $user_id == $owner_id || $user_id == $admin_id)
										{
											//show the view submission button
											echo "<button class='btn btn-info' style='width: 100%; height: 50px;'><a href='view_submission.php?question=$task_question&path=$media_path&task_id=$task_id' style='color: black; font-size: 25px;'>VIEW SUBMISSION</a></button>";

										}
										else
										{
											echo "<h3>Sorry! You cannot do this task because it has been completed and submitted by a user.</h3>";
										}
									}

									else
									{
										echo "<h1>Sorry! You cannot do this task because it is currently fully occupied.</h1>";
									}
								} 



							echo "</div>

						</div>

				</div>

			</div> ";
		}
		else
		{
			//task does not exist! Load error404 page!
			header("Location: error404.php");
		}
	?>

</body>
</html>