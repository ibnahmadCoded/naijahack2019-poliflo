<?php
include("includes/connection.php");

session_start();

if(!isset($_SESSION['user_email'])){

	session_destroy();
	
	header("location: index.php");
}
if(isset($_SESSION['user_email'])){

	$email = $_SESSION['user_email'];
}

$task_id = $_GET['task_id'];

//get task owner!
$get_task = "SELECT owner_id FROM tasks WHERE id = '$task_id'";
$run_task = mysqli_query($con,$get_task);
$row = mysqli_fetch_array($run_task);

$owner_id = $row['owner_id'];

//find current user!
$user = $_SESSION['user_email'];
$get_user = "select user_name, user_id from users where email='$user'";
$run_user = mysqli_query($con,$get_user);
$row = mysqli_fetch_array($run_user);

$user_name = $row['user_name'];
$user_id = $row['user_id'];


//ensure the task owner is the current user before deleting!
if($user_id === $owner_id)
{
	$delete_task ="DELETE FROM tasks WHERE id='$task_id'";
	$run_delete = mysqli_query($con, $delete_task);

	if($run_delete)
	{
		$notify = "insert into notifications (user_from_id, user_to_id, other_id, type, status, date) values('$owner_id', '$owner_id', '$owner_id', 'task_deletion', 'unread', NOW())";

		$run_notify = mysqli_query($con, $notify);

		if($run_notify)
		{

			echo "<script>alert('Task has been deleted!')</script>";
			echo "<script>window.open('my_tasks.php?u5Nm=$user_name', '_self')</script>";

		}
	}
}
else
{
	echo "<script>alert('Task deletion failed, please try again!')</script>";
	echo "<script>window.open('my_tasks.php?u5Nm=$user_name', '_self')</script>";
}

?>