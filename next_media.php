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

				$true_media = array(); //all files that fit the requested description

				foreach (glob("{$path}true/*.*") as $filename) { //the directory in glo() should be changed to particular task media directory!
				    $p = pathinfo($filename);
				    $true_media[] = $p['filename'];
				}

				$false_media = array(); //all files that do not fit the requested description

				foreach (glob("{$path}false/*.*") as $filename) { //the directory in glo() should be changed to particular task media directory!
					$p = pathinfo($filename);
					$false_media[] = $p['filename'];
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
					$ext = array("jpg", "jpeg", "JPEG", "gif", "png", "bmp");

					for($x = 0; $x < 6; $x++)
					{

					    $src = $file.$ext[$x];

					    if(file_exists($src))
					    {

					        echo "
							<h5 align = center style='font-size:50px;'>$task_question</h5>
							<h6 align = center style='font-size:50px;'>$current_media of $num</h6>
							<img id='imgFrame' src='$src' style='width:90%; height:470px;' />";

					    }
					}

				}


				if($next_media < sizeof($media) && $next_media > 0 && sizeof($media) - $next_media != 1)
				{

							echo "	 
							<div class = 'col-sm-12'>
								<button class='btn btn-info' style='float:left;'><a href='previous_media.php?media_file=$previous_media&question=$task_question&path=$path&task_id=$task_id' style='color: white;'>PREVIOUS</a></button>
			 					<button class='btn btn-info' style='float:right;'><a href='check_selection.php?media_file=$next_media&question=$task_question&path=$path&task_id=$task_id' style='color: white;'>NEXT</a></button>
			 				</div>";

				}

				elseif ($next_media < sizeof($media) && $next_media == 0 && sizeof($media) - $next_media != 1) {
					
					echo "	 
						<div class = 'col-sm-12'>
			 				<button class='btn btn-info' style='float:right;'><a href='check_selection.php?media_file=$next_media&question=$task_question&path=$path&task_id=$task_id' style='color: white;'>NEXT</a></button>
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
						<button class='btn btn-info' style='float:left;'><a href='previous_media.php?media_file=$previous_media&question=$task_question&path=$path&task_id=$task_id' style='color: white;'>PREVIOUS</a></button>
			 			<button class='btn btn-info' style='float:right;'><a href='view_submission.php?question=$task_question&path=$path&task_id=$task_id' style='color: white;'>VIEW SUBMISSION</a></button>  
			 		</div>
					";
				}

		 	?>
		</div>

		<div class="col-sm-6" style="text-align: center;">

			<div class="col-sm-12" style="display: inline-block; margin-top: 35%">

				<?php  

				//php code to copy and del files as in Algo 1

				if (in_array($media[$next_media], $true_media, TRUE)) 
				{ 
				  echo "<h2>You marked this item YES</h2><br>"; 
				} 
				else if (in_array($media[$next_media], $false_media, TRUE))
				{ 
				  echo "<h2>You marked this item NO</h2><br>"; 
				} 

				?>
				
				<button class="btn btn-info" style="margin-bottom: 30px; width: 50%; height: 10%;"><a href="yes.php?media_file=<?php echo $next_media ?>&question=<?php echo $task_question ?>&path=<?php echo $path ?>&task_id=<?php echo $task_id ?>" style="color: white; font-size: 50px;">YES</a></button><br>
				<button class="btn btn-info" style="width: 50%; height: 10%; background-color: #fd4720;"><a href="no.php?media_file=<?php echo $next_media ?>&question=<?php echo $task_question ?>&path=<?php echo $path ?>&task_id=<?php echo $task_id ?>" style="color: white; font-size: 50px;">NO</a></button><br>

			</div>

		</div>

	</div>
	

</body>
</html>