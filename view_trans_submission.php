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
		include("includes/connection.php");

		$task_question = $_GET['question'];
		$path = $_GET['path'];
		$task_id = $_GET['task_id'];

		$media = array();

		foreach (glob("{$path}main/*.*") as $filename) { //the directory in glo() should be changed to particular task media directory!
			$p = pathinfo($filename);
			$media[] = $p['filename'];
		}


		$next_media = sizeof($media) - 1;

		$num_total = sizeof($media);

		$get_task = "SELECT submitted, submitted_by, owner_id  FROM tasks WHERE id ='$task_id'"; 
		$run_task = mysqli_query($con,$get_task);
		$row = mysqli_fetch_array($run_task);

		$submitted = $row['submitted']; //50 goes to d company!
		$owner_id = $row['owner_id'];
		$submitted_by = $row['submitted_by'];

		if ($submitted == "yes")
		{

			$admin_id = 1;

			$user = $_SESSION['user_email'];
			$get_user = "select user_id from users where email='$user'";
			$run_user = mysqli_query($con,$get_user);
			$row = mysqli_fetch_array($run_user);
						
			$user_id = $row['user_id']; 

			if ($user_id == $owner_id)
			{

				echo "

					<div class='row'>
						<button class='btn btn-info' style='float: left; width: 120px; height: 50px; margin: 30px; margin-left: 100px; background-color: #fd4720;'><a href='task.php?task_id=$task_id' style='color: white;'>BACK TO TASK</a></button><br>
						<button class='btn btn-info' style='float: right; width: 200px; height: 50px; margin: 30px; margin-right: 100px; background-color: #fd4720;'><a href='download.php?path=$path' style='color: white;'>DOWNLOAD SUBMISSION</a></button><br>

						<center><h3>Total Number Of Files In The Task: $num_total</h3></center>

					</div>

				";

			}
			
			elseif ($user_id == $submitted_by || $user_id == $admin_id)
			{
					echo "

					<div class='row'>
						<button class='btn btn-info' style='float: left; width: 120px; height: 50px; margin: 30px; margin-left: 100px; background-color: #fd4720;'><a href='task.php?task_id=$task_id' style='color: white;'>BACK TO TASK</a></button><br>
						<button class='btn btn-info' style='float: right; width: 120px; height: 50px; margin: 30px; margin-right: 100px; background-color: #fd4720;'><a href='task.php?task_id=$task_id' style='color: white;'>BACK TO TASK</a></button><br>

						<center><h3>Total Number Of Files In The Task: $num_total</h3></center>

					</div>

				";
			}
		}
		else
		{
			echo "

				<div class='row'>
					<button class='btn btn-info' style='float: left; width: 120px; height: 50px; margin: 30px; margin-left: 100px; background-color: #fd4720;'><a href='next_transcription.php?media_file=$next_media&question=$task_question&path=$path&task_id=$task_id' style='color: white;'>BACK TO TASK</a></button><br>
					<button class='btn btn-info' style='float: right; width: 120px; height: 50px; margin: 30px; margin-right: 100px; background-color: #fd4720;'><a href='submit.php?task_id=$task_id' style='color: white;'>SUBMIT TASK</a></button><br>

					<center><h3>Total Number Of Files In The Task: $num_total</h3></center>

				</div>

			";
		}

	?>

	<div class="row">

		<?php 

			if($submitted == "yes")
			{
				//show submissions only if the id is admin or owner, or submitter else dow show the files

				if($user_id == $owner_id || $user_id == $admin_id || $user_id == $submitted_by)
				{
					//show everything
					echo "<div class='col-sm-6'> ";

						echo "
						<center>

						<b>The question was:</b> $task_question <br>

						<b>Videos/Audios</b> <br>

						<b>Number of files:</b> $num_total

						</center>";

						for ($i = 0; $i < sizeof($media); $i++)
						{
							$media_img = $media[$i];

							$file =  $path."main/".$media_img.".";

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
										<center>
										<video width='90%' height='500' controls>
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
					
		echo "</div>
		
		<div class='col-sm-6'> ";

				$transcriptions = array(); //all files that fit the requested description

				foreach (glob("{$path}transcriptions/*.*") as $filename) { //the directory in glo() should be changed to particular task media directory!
				    $p = pathinfo($filename);
				    $transcriptions[] = $p['filename'];
				}

				$num = sizeof($transcriptions);

				echo "
				<center>

				<b>The question was:</b> $task_question <br>

				<b>transcriptions</b> <br>

				<b>Number of files:</b> $num

				</center> <br><br><br>";


				for ($i = 0; $i < sizeof($transcriptions); $i++)
				{
					$trans_img = $transcriptions[$i];

					//show all files in true folder
					// $src = $path."true/".$true_img.".jpg";

					$file =  $path."transcriptions/".$trans_img.".txt";
					// $file2 = $path."main/".$true_img.".";

					//check the file extension and print!

					if(file_exists($file))
					{
					    $myfile = fopen($file, "r") or die("Unable to open file!");
						echo fread($myfile,filesize($file));
						fclose($myfile);
						echo "<br><br><br>";

					}
	
				}

		echo "</div>";
				}

				else
				{
					//show nothing to others

					header("Location: error404.php");
				}
			}
			else
			{
				//unsubmitted, show everything as normally shown!
				echo "<div class='col-sm-6'> ";

						echo "
						<center>

						<b>The question was:</b> $task_question <br>

						<b>Videos/Audios</b> <br>

						<b>Number of files:</b> $num_total

						</center>";

						for ($i = 0; $i < sizeof($media); $i++)
						{
							$media_img = $media[$i];

							$file =  $path."main/".$media_img.".";

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
										<center>
										<video width='90%' height='500' controls>
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
					
		echo "</div>
		
		<div class='col-sm-6'> ";

				$transcriptions = array(); //all files that fit the requested description

				foreach (glob("{$path}transcriptions/*.*") as $filename) { //the directory in glo() should be changed to particular task media directory!
				    $p = pathinfo($filename);
				    $transcriptions[] = $p['filename'];
				}

				$num = sizeof($transcriptions);

				echo "
				<center>

				<b>The question was:</b> $task_question <br>

				<b>transcriptions</b> <br>

				<b>Number of files:</b> $num

				</center> <br><br><br>";


				for ($i = 0; $i < sizeof($transcriptions); $i++)
				{
					$trans_img = $transcriptions[$i];

					//show all files in true folder
					// $src = $path."true/".$true_img.".jpg";

					$file =  $path."transcriptions/".$trans_img.".txt";
					// $file2 = $path."main/".$true_img.".";

					//check the file extension and print!

					if(file_exists($file))
					{
					    $myfile = fopen($file, "r") or die("Unable to open file!");
						echo fread($myfile,filesize($file));
						fclose($myfile);
						echo "<br><br><br>";

					}
	
				}

		echo "</div>";

			}

		?>

	</div>

</body>
</html>