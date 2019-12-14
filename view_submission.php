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

						<center><h3>Total Number Of Image Files In The Task: $num_total</h3></center>

					</div>

				";

			}
			
			elseif ($user_id == $submitted_by || $user_id == $admin_id)
			{
					echo "

					<div class='row'>
						<button class='btn btn-info' style='float: left; width: 120px; height: 50px; margin: 30px; margin-left: 100px; background-color: #fd4720;'><a href='task.php?task_id=$task_id' style='color: white;'>BACK TO TASK</a></button><br>
						<button class='btn btn-info' style='float: right; width: 120px; height: 50px; margin: 30px; margin-right: 100px; background-color: #fd4720;'><a href='task.php?task_id=$task_id' style='color: white;'>BACK TO TASK</a></button><br>

						<center><h3>Total Number Of Image Files In The Task: $num_total</h3></center>

					</div>

				";
			}
		}
		else
		{
			echo "

				<div class='row'>
					<button class='btn btn-info' style='float: left; width: 120px; height: 50px; margin: 30px; margin-left: 100px; background-color: #fd4720;'><a href='next_media.php?media_file=$next_media&question=$task_question&path=$path&task_id=$task_id' style='color: white;'>BACK TO TASK</a></button><br>
					<button class='btn btn-info' style='float: right; width: 120px; height: 50px; margin: 30px; margin-right: 100px; background-color: #fd4720;'><a href='submit.php?task_id=$task_id' style='color: white;'>SUBMIT TASK</a></button><br>

					<center><h3>Total Number Of Image Files In The Task: $num_total</h3></center>

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

					echo "<div class='col-sm-6'>";
			

							$true_media = array(); //all files that fit the requested description

							foreach (glob("{$path}true/*.*") as $filename) { //the directory in glo() should be changed to particular task media directory!
							    $p = pathinfo($filename);
							    $true_media[] = $p['filename'];
							}

							$num = sizeof($true_media);

							echo "
							<center>

							<b>The question was:</b> $task_question <br>

							<b>Images labeled YES</b> <br>

							<b>Number of image files:</b> $num

							</center>";


							for ($i = 0; $i < sizeof($true_media); $i++)
							{
								$true_img = $true_media[$i];

								//show all files in true folder
								// $src = $path."true/".$true_img.".jpg";

								$file =  $path."true/".$true_img.".";

								//check the file extension and print!
								$ext = array("jpg", "jpeg", "JPEG", "gif", "png", "bmp");

								for($x = 0; $x < 6; $x++)
								{

								    $src = $file.$ext[$x];

								    if(file_exists($src))
								    {

								        echo "<img id='imgFrame' src='$src' style='width:100px; height:100px;' />";

								    }
								}
								
							}


					echo "</div>

					<div class='col-sm-6'> ";


							$false_media = array(); //all files that do not fit the requested description

							foreach (glob("{$path}false/*.*") as $filename) { //the directory in glo() should be changed to particular task media directory!
								    $p = pathinfo($filename);
								    $false_media[] = $p['filename'];
								}

							$num = sizeof($false_media);

							echo "
							<center>

							<b>The question was:</b> $task_question <br>

							<b>Images labeled NO</b> <br>

							<b>Number of image files:</b> $num

							</center>";

							for ($i = 0; $i < sizeof($false_media); $i++)
							{
								$false_img = $false_media[$i];

								//show all files in true folder
								// $src = $path."false/".$false_img.".jpg";

								$file =  $path."false/".$false_img.".";

								//check the file extension and print!
								$ext = array("jpg", "jpeg", "JPEG", "gif", "png", "bmp");

								for($x = 0; $x < 6; $x++)
								{

								    $src = $file.$ext[$x];

								    if(file_exists($src))
								    {

								        echo "<img id='imgFrame' src='$src' style='width:100px; height:100px;' />";

								    }
								}
						
							}


						
					echo "</div> ";
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
				echo "<div class='col-sm-6'>";
			

							$true_media = array(); //all files that fit the requested description

							foreach (glob("{$path}true/*.*") as $filename) { //the directory in glo() should be changed to particular task media directory!
							    $p = pathinfo($filename);
							    $true_media[] = $p['filename'];
							}

							$num = sizeof($true_media);

							echo "
							<center>

							<b>The question was:</b> $task_question <br>

							<b>Images labeled YES</b> <br>

							<b>Number of image files:</b> $num

							</center>";


							for ($i = 0; $i < sizeof($true_media); $i++)
							{
								$true_img = $true_media[$i];

								//show all files in true folder
								// $src = $path."true/".$true_img.".jpg";

								$file =  $path."true/".$true_img.".";

								//check the file extension and print!
								$ext = array("jpg", "jpeg", "JPEG", "gif", "png", "bmp");

								for($x = 0; $x < 6; $x++)
								{

								    $src = $file.$ext[$x];

								    if(file_exists($src))
								    {

								        echo "<img id='imgFrame' src='$src' style='width:100px; height:100px;' />";

								    }
								}
								
							}


					echo "</div>

					<div class='col-sm-6'> ";


							$false_media = array(); //all files that do not fit the requested description

							foreach (glob("{$path}false/*.*") as $filename) { //the directory in glo() should be changed to particular task media directory!
								    $p = pathinfo($filename);
								    $false_media[] = $p['filename'];
								}

							$num = sizeof($false_media);

							echo "
							<center>

							<b>The question was:</b> $task_question <br>

							<b>Images labeled NO</b> <br>

							<b>Number of image files:</b> $num

							</center>";

							for ($i = 0; $i < sizeof($false_media); $i++)
							{
								$false_img = $false_media[$i];

								//show all files in true folder
								// $src = $path."false/".$false_img.".jpg";

								$file =  $path."false/".$false_img.".";

								//check the file extension and print!
								$ext = array("jpg", "jpeg", "JPEG", "gif", "png", "bmp");

								for($x = 0; $x < 6; $x++)
								{

								    $src = $file.$ext[$x];

								    if(file_exists($src))
								    {

								        echo "<img id='imgFrame' src='$src' style='width:100px; height:100px;' />";

								    }
								}
						
							}


						
					echo "</div> ";
			}

		?>

	</div>

</body>
</html>