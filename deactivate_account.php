<?php 
include("includes/connection.php");
session_start();


	if(isset($_SESSION['user_email'])){

		$email = $_SESSION['user_email'];
		$get_uname = "SELECT user_name FROM users WHERE email = '$email'";
		$run_uname = mysqli_query($con, $get_uname);
		$row_uname = mysqli_fetch_array($run_uname);

		$user_name = $row_uname['user_name'];

		if(isset($_GET['u5Nm'])){

			$u_name = $_GET['u5Nm'];

			if ($u_name == $user_name) { // don't show the deactivation link if it's not the same user!

				$update = "UPDATE users SET active = 'no' WHERE user_name='$u_name'";
				$run_update = mysqli_query($con, $update);

				if($run_update){

					session_destroy(); // the user's session destoryed!
					header("location:deactivated.php");
					#echo "<script>window.open(deactivated.php, _self)</script>";
				}
			}

		}

	}

?>
