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
	<?php
		$user = $_SESSION['user_email'];
		$get_user = "select * from users where email='$user'";
		$run_user = mysqli_query($con,$get_user);
		$row = mysqli_fetch_array($run_user);

		$user_fname = $row['f_name'];
		$user_lname = $row['l_name'];
	?>
	<title>My tasks <?php echo "$user_fname $user_lname"; ?>. The perfect location for tasks.</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>

<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<body>
	<div class="row">
		<div class="col-sm-6">

			<?php 

				$user = $_SESSION['user_email'];
				$get_user = "select user_id from users where email='$user'";
				$run_user = mysqli_query($con,$get_user);
				$row = mysqli_fetch_array($run_user);
						
				$user_id = $row['user_id'];

				echo "<div class='row'>
				<center><h4>TASKS UPLOADED BY YOU</h4></center> 
				<div class='col-sm-12'>
				<center>
				";


				global $con;

					$get_tasks = "SELECT * FROM tasks WHERE owner_id='$user_id' ORDER BY id DESC";

					$run_tasks = mysqli_query($con, $get_tasks);

					echo "<Table style='width:90%'>

					<tr>
					    <th>Title</th>
					    <th>Type</th>
					    <th>Payment</th>
					    <th>Due Date</th>
					</tr>

					";

					while ($row=mysqli_fetch_array($run_tasks)) {
						
						$task_id = $row['id'];
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
						$pay_received = $row['pay_received'];
						$job_seeker_paid = $row['job_seeker_paid'];
						$task_question = $row['task_question'];

						
						//display tasks

						echo "

							<tr>
							    <th><a href='task.php?task_id=$task_id'>$title</a></th>
							    <th>$type</th>";

							    //check if the task has been paid for!
							    if($cost <= 0 || $pay_received != "yes")
							    {
							    	echo "<th style='font-size:9px'>payment has not been recieved! This task will not be visible to the public</th>";
							    }
							    else
							    {
							    	echo "<th>$cost</th>";
							    }
							    //if submitted, show submitted insted of expiration date!
							    if($submitted == "yes")
							    {
							    	echo "<th>submitted</th>";
							    }
							    else
							    {
							    	echo "
							    
									    <th>$expiration_date</th>
									</tr>

								";
							    }

						
					}

			echo "
			</table>
			</center>
			</div>
			</div>
			";

				 ?>
			
		</div>

		<div class="col-sm-6">
			<?php 

				echo "<div class='row'>
				<center><h4>TASKS YOU ARE WORKING ON</h4></center> 
				<div class='col-sm-12'>
				<center>
				";


				global $con;

					$get_tasks = "SELECT * FROM tasks WHERE attached_users='$user_id' AND submitted !='yes' ORDER BY id DESC";

					$run_tasks = mysqli_query($con, $get_tasks);

					echo "<Table style='width:90%'>

					<tr>
					    <th>Title</th>
					    <th>Type</th>
					    <th>Payment</th>
					    <th>Due Date</th>
					</tr>

					";

					while ($row=mysqli_fetch_array($run_tasks)) {
						
						$task_id = $row['id'];
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
						$pay_received = $row['pay_received'];
						$job_seeker_paid = $row['job_seeker_paid'];
						$task_question = $row['task_question'];


						// $user = $_SESSION['user_email'];
						// $get_user = "select user_id from users where email='$user'";
						// $run_user = mysqli_query($con,$get_user);
						// $row = mysqli_fetch_array($run_user);
						
						// $user_id = $row['user_id'];

						
						//display tasks

						echo "

							<tr>
							    <th><a href='task.php?task_id=$task_id'>$title</a></th>
							    <th>$type</th>
							    <th>$cost</th>
							    <th>$expiration_date</th>
							</tr>

						";

						
					}

			echo "
			</table>
			</center>
			</div>
			</div>
			";

				 ?>
			
		</div>
	</div>

	<div class="row" style="margin-bottom: 50px;">
		
	</div>
	<div class="row">
		<div class="col-sm-6">

			<?php 

				echo "<div class='row'>
				<center><h4>TASKS YOU HAVE COMPLETED</h4></center> 
				<div class='col-sm-12'>
				<center>
				";


				global $con;

					$get_tasks = "SELECT * FROM tasks WHERE submitted_by='$user_id' AND submitted='yes' ORDER BY id DESC";

					$run_tasks = mysqli_query($con, $get_tasks);

					echo "<Table style='width:90%'>

					<tr>
					    <th>Title</th>
					    <th>Type</th>
					    <th>Payment</th>
					    <th>Payment disbursed</th>
					</tr>

					";

					while ($row=mysqli_fetch_array($run_tasks)) {
						
						$task_id = $row['id'];
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
						$pay_received = $row['pay_received'];
						$job_seeker_paid = $row['job_seeker_paid'];
						$task_question = $row['task_question'];


						// $user = $_SESSION['user_email'];
						// $get_user = "select user_id from users where email='$user'";
						// $run_user = mysqli_query($con,$get_user);
						// $row = mysqli_fetch_array($run_user);
						
						// $user_id = $row['user_id'];

						
						//display tasks

						echo "

							<tr>
							    <th><a href='task.php?task_id=$task_id'>$title</a></th>
							    <th>$type</th>
							    <th>$cost</th>
							    <th>$job_seeker_paid</th>
							</tr>

						";

						
					}

			echo "
			</table>
			</center>
			</div>
			</div>
			";

				 ?>
			
		</div>

		<div class="col-sm-6">
			<?php 

				echo "<div class='row'>
				<center><h4>TASKS SUGGESTED TO YOU</h4></center> 
				<div class='col-sm-12'>
				<center>
				";


				global $con;

					$get_tasks = "SELECT * FROM tasks WHERE attached_users =0 AND submitted !='yes' AND owner_id !='$user_id' AND pay_received !='no' ORDER BY id DESC";

					$run_tasks = mysqli_query($con, $get_tasks);

					echo "<Table style='width:90%'>

					<tr>
					    <th>Title</th>
					    <th>Type</th>
					    <th>Payment</th>
					    <th>Due Date</th>
					</tr>

					";

					while ($row=mysqli_fetch_array($run_tasks)) {
						
						$task_id = $row['id'];
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
						$pay_received = $row['pay_received'];
						$job_seeker_paid = $row['job_seeker_paid'];
						$task_question = $row['task_question'];


						// $user = $_SESSION['user_email'];
						// $get_user = "select user_id from users where email='$user'";
						// $run_user = mysqli_query($con,$get_user);
						// $row = mysqli_fetch_array($run_user);
						
						// $user_id = $row['user_id'];

						
						//display tasks

						echo "

							<tr>
							    <th><a href='task.php?task_id=$task_id'>$title</a></th>
							    <th>$type</th>
							    <th>$cost</th>
							    <th>$expiration_date</th>
							</tr>

						";

						
					}

			echo "
			</table>
			</center>
			</div>
			</div>
			";

				 ?>
			
		</div>
	</div>


</body>

</html>