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
	<title>Create New Task</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="row">
		<div class="col-sm-12">
			<div class="col-sm-2">
				
			</div>
			<div class="col-sm-8">

				<form action="" method="POST" enctype="multipart/form-data">
					<div class="form-group">

						<b>Title</b>
						<input class="form-control" type="text" name="title" placeholder="e.g. Label these data" required="required"><br>

					</div>

					
					<div class="form-group">
						<!-- <span class="input-group-addon" style="background-color: #fd4720; border-color: #fd4720;"></span> -->
						<b>Task Type</b>
						<select class="form-control" name="task_type" required="required">
							<option>Select Task Type</option>
							<option>model labeling</option>
							<option>transcription task</option>
						</select>
					</div><br>

					

					<div class="form-group">

						<b>Task Question</b>
						<input class="form-control" type="text" name="task_question" placeholder="e.g. is this a cat?, can you transcribe these audios and videos into Yoruba?" required="required"><br>

					</div>

					<div class="form-group">

						<b>Description</b>
						<textarea class="form-control" name="description" placeholder="Please give an in-depth explanation of the task here." required="required" style="height: 90px;"></textarea><br>

					</div>

					<div class="form-group">

						<b>Expiration Date</b> 
						<input class="form-control" type="date" name="expiration_date"><br>

					</div>

					<div class="form-group">

				        <b>Select media to upload</b>
				        <input type="file" class="form-control" name="file[]" required="required" multiple/><br>

				    </div>

				       <center><b>NOTE: the rate is $100 per image for model labeling tasks and $100 per playtime minute of video/audio file. You can also opt for subscription plans!</b></center>


			        <input type="submit" class="form-control" name="create_task" value="CREATE TASK" style="height: 50px; background-color: #fd4720; color: white; font-size: 20px;" />

			    </form>
			</div>
			<div class="col-sm-2">
				
			</div>
		</div>
	    <?php 

	    	//set time limit constraints
			ini_set('max_execution_time', 0);
			set_time_limit(1800);
			ini_set('memory_limit', '-1');
			// ini_set('upload_max_filesize', 1000M); //set this in php.ini
			// ini_set('post_max_size', 1000M);


	    	if(isset($_POST['create_task']))
	    	{

	    		$title = htmlentities(mysqli_real_escape_string($con, $_POST['title']));
	    		$task_type = htmlentities(mysqli_real_escape_string($con, $_POST['task_type']));
	    		$task_question = htmlentities(mysqli_real_escape_string($con, $_POST['task_question']));
	    		$description = htmlentities(mysqli_real_escape_string($con, $_POST['description']));
	    		$submitted = "no";
	    		$submitted_by = 0;
	    		$expiration_date = htmlentities(mysqli_real_escape_string($con,$_POST['expiration_date']));
	    		$acceptable_users = 1; 
	    		$attached_users = 0;
	    		$pay_received = "no";
	    		$job_seeker_paid = "no";


		    	$user_nom = $_GET['u5Nm'];

		    	$user = $_SESSION['user_email'];
				$get_user = "select user_name, user_id from users where email='$user'";
				$run_user = mysqli_query($con,$get_user);
				$row = mysqli_fetch_array($run_user);
					
				$user_name = $row['user_name'];

				//make sure it's the user that's creating task!

				if($user_name != $user_nom)
				{
					session_destroy();
					header("location: index.php");
				}
				else
				{
					$owner_id = $row['user_id'];
					$fPath = $user_name.md5(rand() * time());

					//create task folders!

					if (!file_exists('task_media/$fPath')) 
					{

					    mkdir("task_media\\{$fPath}", 0777, true);

					    //create sub task folders, depending on the task type!
					    if($task_type == "model labeling")
					    {
					    	mkdir("task_media\\{$fPath}\\main", 0777, true);
					    	mkdir("task_media\\{$fPath}\\true", 0777, true);
					    	mkdir("task_media\\{$fPath}\\false", 0777, true);

					    	$media_path = "task_media/{$fPath}/";


					        $file_dir  = "task_media\\{$fPath}\\main"; 



					        for ($x = 0; $x < count($_FILES['file']['name']); $x++) 
					        {               

						        $file_name   = $_FILES['file']['name'][$x];
						        $file_tmp    = $_FILES['file']['tmp_name'][$x];

						        /* location file save */
						        $file_target = $file_dir . DIRECTORY_SEPARATOR . $file_name; /* DIRECTORY_SEPARATOR = / or \ */

						        if (move_uploaded_file($file_tmp, $file_target)) 
						        {                        
						           echo "{$file_name} has been uploaded. <br />";                      
						        } 
						        else 
						        {                      
						           echo "Sorry, there was an error uploading {$file_name}.";                               
						        }                 

					        }

					        $files_count = new FilesystemIterator($file_dir, FilesystemIterator::SKIP_DOTS);

							$count = iterator_count($files_count);

			                $cost = $count * 100;




					    }

					    elseif($task_type == "transcription task")
					    {
					    	mkdir("task_media\\{$fPath}\\main", 0777, true);
					    	mkdir("task_media\\{$fPath}\\transcriptions", 0777, true);

					    	$media_path = "task_media/{$fPath}/";


					        $file_dir  = "task_media\\{$fPath}\\main"; 



					        for ($x = 0; $x < count($_FILES['file']['name']); $x++) 
					        {               

						        $file_name   = $_FILES['file']['name'][$x];
						        $file_tmp    = $_FILES['file']['tmp_name'][$x];

						        /* location file save */
						        $file_target = $file_dir . DIRECTORY_SEPARATOR . $file_name; /* DIRECTORY_SEPARATOR = / or \ */

						        if (move_uploaded_file($file_tmp, $file_target)) 
						        {                        
						           echo "{$file_name} has been uploaded. <br />";                      
						        } 
						        else 
						        {                      
						           echo "Sorry, there was an error uploading {$file_name}.";                               
						        }                 

					        }

					        //include file that lets us get duration of video/audio files
							include_once('getid3/getid3.php');

							$durations = array();

							foreach (glob("{$file_dir}/*") as $filename) 
							{ 

							    $media_file = $filename;

							    $getID3 = new getID3;
							    $file = $getID3->analyze($media_file);

							    $duration = $file['playtime_string'];

							    array_push($durations, $duration);

							}

							if($durations != [null,null]) //if it's equal to [null,null], it means the files durations could not be calculated!
							{
								$money_calc = 0;

								for ($i=0; $i < sizeof($durations); $i++)
								{
								    $time=$durations[$i];

								    $time = explode(':', $time);

								    if(count($time) == 3)
								    {
								        //convert duration to minutes if it has hours:minutes:seconds format
								        $dr = ($time[0] * 60) + $time[1] + ($time[2] / 60); 
								    }

								    elseif(count($time) == 2)
								    {
								        //convert duration to minutes if it has minutes:seconds format
								        $dr = $time[0] + ($time[1] / 60); 
								    }

								    $price=100;

								    $result=$dr*$price;

								    $money_calc += $result;

								}

								$cost = round($money_calc, 2);

								//get files for transcription after uploads tasks and create .txt files for them!
						        $destination_dir = "task_media\\{$fPath}\\transcriptions\\";

								$transcription_files = array();


					            foreach (glob("{$file_dir}/*") as $filename) 
					            { //the directory in glo() should be changed to particular task media directory!
					                 $p = pathinfo($filename);
					                 $transcription_files[] = $p['filename'];
					            }

					            for ($y=0; $y < sizeof($transcription_files); $y++)
					            {
					                $newfile = $destination_dir.$transcription_files[$y].".txt";
					                $fh = fopen($newfile, 'w') or die("Can't create file");
					            }

							}
							else
							{
								echo "Wrong file formats! Please upload videos or audios for this type of task.";
							}

					    }

					}
				}

				// echo "'$owner_id', '$title', '$task_type', '$description', '$media_path', '$submitted', '$submitted_by', '$expiration_date', '$cost', '$acceptable_users', '$attached_users', NOW(), NOW(), '$pay_received', '$job_seeker_paid', '$task_question'";


	            //insert task!
	            $sql = "INSERT INTO tasks (owner_id, title, type, description, media_path, submitted, submitted_by, expiration_date, cost, acceptable_users, attached_users, created_at, updated_at, pay_received, job_seeker_paid, task_question) VALUES ('$owner_id', '$title', '$task_type', '$description', '$media_path', '$submitted', '$submitted_by', '$expiration_date', '$cost', '$acceptable_users', '$attached_users', NOW(), NOW(), '$pay_received', '$job_seeker_paid', '$task_question')";

	            $run_insert = mysqli_query($con, $sql);

	            if ($run_insert) {

	            	//notify for task addition and link to the user's tasks!

	            	$notify = "insert into notifications (user_from_id, user_to_id, other_id, type, status, date) values('$owner_id', '$owner_id', '$owner_id', 'task_creation', 'unread', NOW())";

					$run_notify = mysqli_query($con, $notify);

					echo "<script>alert('Task creation successful, Thank you!')</script>";
					echo "<script>window.open('my_tasks.php?u5Nm=$user_name', '_self')</script>";

				} 
				else 
				{

					echo "<script>alert('Task creation failed, please try again!')</script>";
					echo "<script>window.open('create_task.php?u5Nm=$user_name', '_self')</script>";
				}



			}

	    ?>
	</div>

</body>
</html>