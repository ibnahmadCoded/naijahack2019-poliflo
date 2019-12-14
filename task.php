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

		$task_id = $_GET['task_id'];

		$admin_id = 1;

		$user = $_SESSION['user_email'];
		$get_user = "select user_id from users where email='$user'";
		$run_user = mysqli_query($con,$get_user);
		$row = mysqli_fetch_array($run_user);
			
		$user_id = $row['user_id']; 

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
		$cost = $row['cost'] - 50;
		$acceptable_users = $row['acceptable_users'];
		$attached_users = $row['attached_users'];
		$created_at = $row['created_at'];
		$updated_at = $row['updated_at'];
		$pay_received = $row['pay_received'];
		$job_seeker_paid = $row['job_seeker_paid'];
		$task_question = $row['task_question'];

		$output1 = date("d - M - Y, H:i:s", strtotime($updated_at));
		$output2 = date("d - M - Y, H:i:s", strtotime($expiration_date));

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
							<p><b>Amount payable:</b> $$cost</p>
							<p><b>Task Question: </b>$task_question</p>
							<center><p><b>Task Description</b></p></center>
							<p>$description </p>
								

							

						</div>

						<div class='col-sm-6' style='text-align: center;'>
							<center><h3>CONTINUE TO TASK</h3></center>
							<p><b>NOTE: The first person to finish this task will be paid!</b></p>

							<div class='col-sm-12' style='display: inline-block; margin-top: 30%'>

								 ";

								//check the task type, and the link accordingly!
								// begin task sends the task ID to next media page OR sends the task question and media path only. OR sends the three parameters! FROM DB
								//the page it passes the parameters to is dependent on the type of task (labeling links to next_media; transcription links to transcribe_next).

								if ($type == "transcription task") 
								{
									if ($attached_users == 0 && $submitted != 'yes' && $user_id != $owner_id)
									{
										//change button to input type to run files creation script when clicked and
										echo "
								  		<button class='btn btn-info' style='width: 100%; height: 50px; background-color: #fd4720;'><a href='next_transcription.php?media_file=0&question=$task_question&path=$media_path&task_id=$task_id' style='color: white; font-size: 25px;'>BEGIN TASK</a></button>
								  		"; 
									}
									elseif ($attached_users == $user_id && $submitted != 'yes' && $user_id != $owner_id)
									{
										echo "
								  		<button class='btn btn-info' style='width: 100%; height: 50px; background-color: #fd4720;'><a href='next_media.php?media_file=0&question=$task_question&path=$media_path&task_id=$task_id' style='color: white; font-size: 25px;'>BEGIN TASK</a></button>
								  		";  
									}

									else if ($submitted == 'yes')
									{
										if($user_id == $submitted_by || $user_id == $owner_id || $user_id == $admin_id)
										{
											//show the view submission button
											echo "<button class='btn btn-info' style='width: 100%; height: 50px; background-color: #fd4720;'><a href='view_trans_submission.php?question=$task_question&path=$media_path&task_id=$task_id' style='color: white; font-size: 25px;'>VIEW SUBMISSION</a></button>";

										}
										else
										{
											echo "<h3>Sorry! You cannot do this task because it has been completed and submitted by a user.</h3>";
										}
									}

									else
									{

										if($pay_received == "no" && $user_id == $owner_id)
										{
											//echo payment link!
											echo "
												<p>This task is not visible to the public. Make it visible by following the link below</p>
												<button class='btn btn-info' style='width: 100%; height: 50px; background-color: #fd4720;'><a href='pay_for_task.php?task_id=$task_id' style='color: white; font-size: 25px;'>PAY FOR THIS TASK</a></button>
											";

										}
										elseif($attached_users != 0 && $user_id == $owner_id)
										{
											//echo last updated
											echo "
												<h4>Sorry, the submission for this task is not ready! It is currently being done.<br> <center>Last Update: $output1</center></h4>
											";
										}
										else
										{
											echo "<h3>Sorry! You cannot do this task because it is currently fully occupied.</h3>";
										}

									}
									
								}

								else if ($type == "model labeling") 
								{
									if ($attached_users == 0 && $submitted != 'yes' && $user_id != $owner_id)
									{
										echo "
								  		<button class='btn btn-info' style='width: 100%; height: 50px; background-color: #fd4720;'><a href='next_media.php?media_file=0&question=$task_question&path=$media_path&task_id=$task_id' style='color: white; font-size: 25px;'>BEGIN TASK</a></button>
								  		";  
									}
									elseif ($attached_users == $user_id && $submitted != 'yes' && $user_id != $owner_id)
									{
										echo "
								  		<button class='btn btn-info' style='width: 100%; height: 50px; background-color: #fd4720;'><a href='next_media.php?media_file=0&question=$task_question&path=$media_path&task_id=$task_id' style='color: white; font-size: 25px;'>BEGIN TASK</a></button>
								  		";  
									}

									else if ($submitted == 'yes')
									{
										if($user_id == $submitted_by || $user_id == $owner_id || $user_id == $admin_id)
										{
											//show the view submission button
											echo "<button class='btn btn-info' style='width: 100%; height: 50px; background-color: #fd4720;'><a href='view_submission.php?question=$task_question&path=$media_path&task_id=$task_id' style='color: white; font-size: 25px;'>VIEW SUBMISSION</a></button>";

										}
										else
										{
											echo "<h3>Sorry! You cannot do this task because it has been completed and submitted by a user.</h3>";
										}
									}

									else
									{
										if($pay_received == "no" && $user_id == $owner_id)
										{
											//echo payment link!
											echo "
												<p>This task is not visible to the public. Make it visible by following the link below</p>
												<button class='btn btn-info' style='width: 100%; height: 50px; background-color: #fd4720;'><a href='pay_for_task.php?task_id=$task_id' style='color: white; font-size: 25px;'>PAY FOR THIS TASK</a></button>
											";

										}
										elseif($attached_users != 0 && $user_id == $owner_id)
										{
											//echo last updated
											echo "
												<h4>Sorry, the submission for this task is not ready! It is currently being done.<br> <center>Last Update: $output1</center></h4>
											";
										}
										else
										{
											echo "<h3>Sorry! You cannot do this task because it is currently fully occupied.</h3>";
										}
									
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
	<div class="row" style="margin-bottom: 30px;"></div>
<div class="row">
		<center>

		<!-- I got these buttons from simplesharebuttons.com -->
		<div id="share-buttons">
		    
		    <!-- Buffer -->
		    <a href="https://bufferapp.com/add?url=task.php?task_id=$task_id&amp;text=Task on wennotate" target="_blank">
		        <img src="images/share_buttons/buffer.png" alt="Buffer" />
		    </a>
		    
		    <!-- Digg -->
		    <a href="http://www.digg.com/submit?url=task.php?task_id=$task_id" target="_blank">
		        <img src="images/share_buttons/diggit.png" alt="Digg" />
		    </a>
		    
		    <!-- Email -->
		    <a href="mailto:?Subject=Simple Share Buttons&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 task.php?task_id=$task_id">
		        <img src="images/share_buttons/email.png" alt="Email" />
		    </a>
		 
		    <!-- Facebook -->
		    <a href="http://www.facebook.com/sharer.php?u=task.php?task_id=$task_id" target="_blank">
		        <img src="images/share_buttons/facebook.png" alt="Facebook" />
		    </a>
		    
		    <!-- Google+ -->
		    <a href="https://plus.google.com/share?url=task.php?task_id=$task_id" target="_blank">
		        <img src="images/share_buttons/google.png" alt="Google" />
		    </a>
		    
		    <!-- LinkedIn -->
		    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=task.php?task_id=$task_id" target="_blank">
		        <img src="images/share_buttons/linkedin.png" alt="LinkedIn" />
		    </a>
		    
		    <!-- Pinterest -->
		    <a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());">
		        <img src="images/share_buttons/pinterest.png" alt="Pinterest" />
		    </a>
		    
		    <!-- Print -->
		    <a href="javascript:;" onclick="window.print()">
		        <img src="images/share_buttons/print.png" alt="Print" />
		    </a>
		    
		    <!-- Reddit -->
		    <a href="http://reddit.com/submit?url=task.php?task_id=$task_id&amp;title=Task on wennotate" target="_blank">
		        <img src="images/share_buttons/reddit.png" alt="Reddit" />
		    </a>
		    
		    <!-- StumbleUpon-->
		    <a href="http://www.stumbleupon.com/submit?url=task.php?task_id=$task_id&amp;title=Task on wennotate" target="_blank">
		        <img src="images/share_buttons/stumbleupon.png" alt="StumbleUpon" />
		    </a>
		    
		    <!-- Tumblr-->
		    <a href="http://www.tumblr.com/share/link?url=task.php?task_id=$task_id&amp;title=Task on wennotate" target="_blank">
		        <img src="images/share_buttons/tumblr.png" alt="Tumblr" />
		    </a>
		     
		    <!-- Twitter -->
		    <a href="https://twitter.com/share?url=task.php?task_id=$task_id&amp;text=Task%20on%20wennotate&amp;hashtags=taskonwennotate" target="_blank">
		        <img src="images/share_buttons/twitter.png" alt="Twitter" />
		    </a>
		    
		    <!-- VK -->
		    <a href="http://vkontakte.ru/share.php?url=task.php?task_id=$task_id" target="_blank">
		        <img src="images/share_buttons/vk.png" alt="VK" />
		    </a>
		    
		    <!-- Yummly -->
		    <a href="http://www.yummly.com/urb/verify?url=task.php?task_id=$task_id&amp;title=Task on wennotate" target="_blank">
		        <img src="images/share_buttons/yummly.png" alt="Yummly" />
		    </a>

		</div>
	</center>
		
	</div>
</body>
</html>