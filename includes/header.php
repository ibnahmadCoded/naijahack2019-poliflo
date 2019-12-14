<?php
#session_start();
include("includes/connection.php");
// include("functions/functions.php");

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
<nav class="navbar navbar-default" style="background-color: #87CEEB;">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="home.php" style="color: white;">wennotate</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	      	
	      	<?php 
			$user = $_SESSION['user_email'];
			$get_user = "SELECT * FROM users WHERE email='$user'"; 
			$run_user = mysqli_query($con,$get_user);
			$row=mysqli_fetch_array($run_user);
					
			$user_id = $row['user_id']; 
			$user_name = $row['user_name'];
			$first_name = $row['f_name'];
			$last_name = $row['l_name'];
			$describe_user = $row['describe_user'];
			$profession = $row['profession'];
			$user_pass = $row['user_pass'];
			$user_email = $row['email'];
			$user_country = $row['user_country'];
			$user_gender = $row['user_gender'];
			#$user_birthday = $row['user_birthday'];
			$user_image = $row['user_image'];
			$recovery_account = $row['recovery_account'];
			$register_date = $row['user_reg_date'];
					
					
			$user_tasks = "SELECT * FROM tasks WHERE owner_id='$user_id' OR submitted_by='$user_id' OR attached_users='$user_id'"; 

			$run_tasks = mysqli_query($con,$user_tasks);
			if (!$run_tasks){
				die(mysqli_error($con));
			} else{
				$tasks = mysqli_num_rows($run_tasks);
			}

			// $get_msg = "SELECT * FROM user_messages WHERE user_to='$user_id' AND msg_seen='no'";

			// $run_msg = mysqli_query($con, $get_msg);
			// $msg_rows = mysqli_num_rows($run_msg);

			// if($msg_rows>0){ //we don't want to show 0!

			// 	$msg_rows = $msg_rows;
			// }
			// else{

			// 	$msg_rows = '';
			// }

		?>



			<li class="dropdown">
					<form class="navbar-form navbar-left" method="get" action="results.php">
						<div class="form-group">
							<input type="text" class="form-control" name="user_query" placeholder="Search Tasks (by title or type)">
						</div>
						<button type="submit" class="btn btn-info" style="background-color: #fd4720;" name="search">Search</button>
					</form>
			</li>

			</ul>
			<ul class="nav navbar-nav navbar-right">

            <li><a href='create_task.php?<?php echo "u5Nm=$user_name" ?>' style="color: white;">Create Task</a></li>
			<li class="nav-item dropdown">
            <a class="nav-link" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white; background-color: #87CEEB;">Notifications 
          		
          		 <?php
                $get_notifications = "SELECT * from notifications where user_to_id = '$user_id' AND status = 'unread' order by date DESC";
                $run_notifications = mysqli_query($con, $get_notifications);

				$notification_num_rows = mysqli_num_rows($run_notifications); //get number of unread notifications


                if($notification_num_rows>0){

                ?>

                <span class="badge badge-light" style="background-color: #fd4720;"><?php echo "$notification_num_rows"; ?></span>
              <?php

                }
                    ?>

              </a>
            <div class="dropdown-menu" aria-labelledby="dropdown01" style="width: 350px; height: 400px; overflow: scroll; overflow-x: hidden;">
               <?php 

               	$get_notifications1 = "SELECT * from notifications where user_to_id = '$user_id' order by id DESC"; //get all notifications fo viewing
                $run_notifications1 = mysqli_query($con, $get_notifications1);

				$notification_num_rows1 = mysqli_num_rows($run_notifications1);

				if($notification_num_rows1 > 0){

					foreach ($run_notifications1 as $n){

					?>
						<a style ="
                         <?php
                            if($n['status']=='unread'){
                                echo "font-weight:bold; color: #fd4720;";
                            }else{
                                echo "color: #87CEEB;";
                            }
                         ?>
                         " class="dropdown-item" href="view_notification.php?type=<?php echo $n['type'] ?>&id=<?php echo $n['id'] ?>">
                 <small><i><?php echo date('F j, Y, g:i a',strtotime($n['date'])) ?></i></small><br/>
                 <?php

                 $user_from_id = $n['user_from_id'];
                 $type = $n['type'];

                 $get_user_from = "SELECT * from users where user_id = '$user_from_id'";
                 $run_get_user_from = mysqli_query($con, $get_user_from);
                 $row_user_from = mysqli_fetch_array($run_get_user_from);

                 $user_fname = $row_user_from['f_name'];
                 $user_lname = $row_user_from['l_name'];
                 $user_img = $row_user_from['user_image'];

                 switch($n['type']){

                 	case 'welcome':
                        echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> Welcome To Talsgrad! find out More...";
                        break;
                    case 'task_creation':
                        echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> You created a new task...";
                        break;
                    case 'task_submission':
                        echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> $user_fname $user_lname submited your task...";
                        break;
                    case 'task_deletion':
                        echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> You deleted a task...";
                        break;
                    default:
                        echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> $user_fname $user_lname made a $type.";
                 }
                  
                  ?>
                </a>
                <div role='separator' class='divider'></div>
                <?php 
                	 }
                 }else{
                     echo "You have no notifications.";
                 }

                 ?>
           </div>
          </li>
          <li><a href='profile.php?<?php echo "u5Nm=$user_name" ?>' style="color: white;"><?php echo "$first_name"; ?></a></li>
				
				<?php
						echo"

						<li class='dropdown'>
							<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false' style='background-color:#87CEEB;'><span style='color: #fd4720;'><i class='glyphicon glyphicon-chevron-down'></i></span></a>
							<ul class='dropdown-menu'>
								<li>
									<a href='my_tasks.php?u5Nm=$user_name'>My tasks <span class='badge badge-secondary' style='background-color: #fd4720;'>$tasks</span></a>
								</li>
								<li>
									<a href='edit_profile.php'>Edit Account <span class='glyphicon glyphicon-pencil' style='color: #fd4720;'></span></a>
								</li>
                                <li>
                                    <a href='settings.php?u5Nm=$user_name'>Settings <span class='glyphicon glyphicon-cog' style='color: #fd4720;'></span></a>
                                </li>
								<li role='separator' class='divider'></li>
								<li>
									<a href='logout.php'>Logout</a>
								</li>
							</ul>
						</li>
						";
					?>
			</ul>
		</div>
	</div>
</nav>