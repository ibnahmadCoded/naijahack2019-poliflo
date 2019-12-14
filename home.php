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
	<title>wennotate's Home: <?php echo "$user_fname $user_lname"; ?>. The perfect location for tasks.</title>
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
	<?php 

	echo "<div class='row'>
	<center><h2>TASKS</h2></center> 
	<div class='col-sm-12'>
	<center>
	";


	global $con;

		$get_tasks = "SELECT * FROM tasks WHERE cost > 0 AND pay_received='yes' AND submitted != 'yes' AND attached_users = 0 ORDER BY id DESC";

		$run_tasks = mysqli_query($con, $get_tasks);

		echo "<Table style='width:90%'>

		<tr>
		    <th>Title</th>
		    <th>Type</th>
		    <th>Payment (USD)</th>
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

<div id="container">

</div>

</body>

</html>