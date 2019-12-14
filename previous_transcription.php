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

	<div class="row">
		<?php 

			$next_media = $_GET['media_file'];

			$task_question = $_GET['question'];

			$path = $_GET['path'];
			$task_id = $_GET['task_id'];

			$get_user = "SELECT user_id FROM users WHERE email = '$email'";
			$run_user = mysqli_query($con, $get_user);
			$row_user = mysqli_fetch_array($run_user);

			$user_id = $row_user['user_id'];

			
			$update_tasks = "UPDATE tasks SET attached_users = '$user_id', updated_at = NOW() WHERE id= '$task_id'";
			$run_update = mysqli_query($con, $update_tasks);

			$media = array();



			// $glob = glob("{$date}/*.xml", GLOB_BRACE);
			// $glob = glob('{'.$date.'}/*.xml', GLOB_BRACE);

				foreach (glob("{$path}/main/*.*") as $filename) { //the directory in glo() should be changed to particular task media directory!
				    $p = pathinfo($filename);
				    $media[] = $p['filename'];
				}

				$transcriptions = array(); //all files that fit the requested description

				foreach (glob("{$path}transcriptions/*.*") as $filename) { //the directory in glo() should be changed to particular task media directory!
				    $p = pathinfo($filename);
				    $transcriptions[] = $p['filename'];
				}

				$previous_media = $next_media - 1; 

				$num = sizeof($media);
				$current_media = $next_media + 1;


				$img = $media[$next_media];

		?>
		
		<div class="col-sm-6">
			<?php

				// echo "<img id='imgFrame' src='task_media/alege/$img.jpg' style='width:400px;height:400px;' />";

				if($next_media >= 0)
				{

					$img = $media[$next_media];
					// $src = $path."main/".$img.".jpg";

					$file =  $path."main/".$media[$next_media].".";

					//check the file extension and print!
					$ext = array("mp4", "mp3", "webm", "ogg", "mpeg");

					for($x = 0; $x < 5; $x++)
					{
					    $src = $file.$ext[$x];

					    if(file_exists($src))
					    {
					    	if($ext[$x] == "mp4" || $ext[$x] == "webm" || $ext[$x] == "ogg")
					    	{
					    		echo "
								<h5 align = center style='font-size:30px;'>$task_question</h5>
								<h6 align = center style='font-size:50px;'>$current_media of $num</h6>
								<p align = center ><b> Please ensure to save before going to next task item! </b></p>
								<center>
								<video width='90%' height='470' controls>
								  <source src='$src' type='video/mp4'>
								  <source src='$src' type='video/ogg'>
								  <source src='$src' type='video/webm'>
								  Your browser does not support the video tag.
								</video>
								</center>
								";
					    	}

					    	elseif($ext[$x] == "mp3" || $ext[$x] == "wav" || $ext[$x] == "ogg")
					    	{
					    		echo "
								<h3 align = center style='font-size:30px;'>$task_question</h3>
								<h5 align = center style='font-size:50px;'>$current_media of $num</h5>
								<p align = center ><b> Please ensure to save before going to next task item! </b></p>
								<center>
								<audio controls>
								  <source src='$src' type='audio/ogg'>
								  <source src='$src' type='audio/mpeg'>
								  <source src='$src' type='audio/wav'>
								  Your browser does not support the audio element.
								</audio>
								</center>
								";
					    	}

					    }
					}

				}


				if($next_media < sizeof($media) && $next_media > 0 && sizeof($media) - $next_media != 1)
				{

							echo "	 
							<div class = 'col-sm-12'>
								<button class='btn btn-info' style='float:left;'><a href='previous_transcription.php?media_file=$previous_media&question=$task_question&path=$path&task_id=$task_id' style='color: white;'>PREVIOUS</a></button>
			 					<button class='btn btn-info' style='float:right;'><a href='check_transcription.php?media_file=$next_media&question=$task_question&path=$path&task_id=$task_id' style='color: white;'>NEXT</a></button>
			 				</div>";

				}

				elseif ($next_media < sizeof($media) && $next_media == 0 && sizeof($media) - $next_media != 1) {
					
					echo "	 
						<div class = 'col-sm-12'>
			 				<button class='btn btn-info' style='float:right;'><a href='check_transcription.php?media_file=$next_media&question=$task_question&path=$path&task_id=$task_id' style='color: white;'>NEXT</a></button>
			 			</div>";

				}

				elseif ($next_media >= sizeof($media)) 
				{
					header("Location: error404.php");
				}

				else
				{
					echo "
					<div>
						<button class='btn btn-info' style='float:left;'><a href='previous_transcription.php?media_file=$previous_media&question=$task_question&path=$path&task_id=$task_id' style='color: white;'>PREVIOUS</a></button>
			 			<button class='btn btn-info' style='float:right;'><a href='view_trans_submission.php?question=$task_question&path=$path&task_id=$task_id' style='color: white;'>VIEW SUBMISSION</a></button> 
			 		</div>
					";
				}

		 	?>
		</div>

		<div class="col-sm-6" style="text-align: center;">

				<?php

					//configuration
					// $url = 'next_transcription.php?media_file=$next_media&question=$task_question&path=$path&task_id=$task_id';
					$file =  $path."transcriptions/".$media[$next_media].".txt";

					//check if form has been submitted
					if (isset($_POST['text']))
					{
					    // save the text contents
					    file_put_contents($file, $_POST['text']);

					    // redirect to form again
					    // header(sprintf('Location: %s', $url));
					    // printf('<a href="%s">Moved</a>.', htmlspecialchars($url));
					    // exit();
					}

					//read the textfile
					$text = file_get_contents($file);

					?> 
					<!-- HTML form -->
					<form action="" method="post">
						<input class="btn btn-info" type="submit" style="width: 90%; height: 65px; color: black; font-size: 25px;" value="SAVE" />
						<textarea name="text" style="width: 90%; height: 600px;"><?php echo htmlspecialchars($text) ?></textarea><br>
						<input class="btn btn-info" type="submit" style="width: 90%; height: 65px; color: black; font-size: 25px;" value="SAVE" />
					</form>

		</div>

	</div>
	

</body>
</html>