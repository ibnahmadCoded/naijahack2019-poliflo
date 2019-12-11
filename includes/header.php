<?php
#session_start();
include("includes/connection.php");
include("functions/functions.php");

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
<nav class="navbar navbar-default" style="background-color: #fd4720;">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="home.php" style="color: white;">talsgrad</a>
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
			$Relationship_status = $row['Relationship'];
			$user_pass = $row['user_pass'];
			$user_email = $row['email'];
			$user_country = $row['user_country'];
			$user_gender = $row['user_gender'];
			#$user_birthday = $row['user_birthday'];
			$user_image = $row['user_image'];
			$user_cover = $row['user_cover'];
			$recovery_account = $row['recovery_account'];
			$register_date = $row['user_reg_date'];
					
					
			$user_posts = "SELECT * FROM posts WHERE user_id='$user_id'"; 

			$run_posts = mysqli_query($con,$user_posts);
			if (!$run_posts){
				die(mysqli_error($con));
			} else{
				$posts = mysqli_num_rows($run_posts);
			}

			$get_msg = "SELECT * FROM user_messages WHERE user_to='$user_id' AND msg_seen='no'";

			$run_msg = mysqli_query($con, $get_msg);
			$msg_rows = mysqli_num_rows($run_msg);

			if($msg_rows>0){ //we don't want to show 0!

				$msg_rows = $msg_rows;
			}
			else{

				$msg_rows = '';
			}

		?>



	        <li><a href='profile.php?<?php echo "u5Nm=$user_name" ?>' style="color: white;"><?php echo "$first_name"; ?></a></li>
	       	<li><a href="home.php" style="color: white;">Home</a></li>
			<li><a href="members.php" style="color: white;">Find Talents</a></li>
			<li class="dropdown">
					<form class="navbar-form navbar-left" method="get" action="results.php">
						<div class="form-group">
							<input type="text" class="form-control" name="user_query" placeholder="Search (posts, tags, etc.)">
						</div>
						<button type="submit" class="btn btn-info" style="background-color: #232742;" name="search">Search</button>
					</form>
			</li>

			</ul>
			<ul class="nav navbar-nav navbar-right">

			<li class="nav-item dropdown">
            <a class="nav-link" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white; background-color: #fd4720;">Notifications 
          		
          		 <?php
                $get_notifications = "SELECT * from notifications where user_to_id = '$user_id' AND status = 'unread' order by date DESC";
                $run_notifications = mysqli_query($con, $get_notifications);

				$notification_num_rows = mysqli_num_rows($run_notifications); //get number of unread notifications


                if($notification_num_rows>0){

                ?>

                <span class="badge badge-light" style="background-color: #232742;"><?php echo "$notification_num_rows"; ?></span>
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
                                echo "color: #fd4720;";
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

                 	case 'comment':

                 		if($user_id != $user_from_id){
                 		 echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> $user_fname $user_lname commented on your portfolio item.";
                         echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                 		}else{
                 			echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> You commented on your portfolio item.";
                            echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                 		}
                 		break;

                 	case 'like':

                 		if($user_id != $user_from_id){
                 			echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> $user_fname $user_lname liked your portfolio item.";
                            echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                 		}else{
                 			echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> You liked your portfolio item.";
                            echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                 		}
                 		break;

                 	case 'inquire':
                 		  if($user_id != $user_from_id){
                            echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> $user_fname $user_lname made an inquiry about your item.";
                             echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                        }else{
                            echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> You made an inquiry about an item. The item's owner should reply soon.";
                             echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                        }
                 		break;

                 	case 'delpost':
                 		echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> You deleted your portfolio item.";
                        echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                 		break;

                 	case 'addbazaar':
                 		echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> You listed your portfolio item on bazaar.";
                        echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                 		break;

                 	case 'rembazaar':
                 		echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> You removed your portfolio item from bazaar.";
                        echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                 		break;

                    case 'post':
                        echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> You added a new portfolio item!";
                        echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                        break;

                 	case 'recommend':

                 		if($user_id != $user_from_id){
                 		 echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> $user_fname $user_lname recommended you to somebody.";
                         echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                 		}else{
                 			echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> You recommended yourself to somebody.";
                            echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                 		}
                 		break;

                 	case 'follow':
                 		 echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> $user_fname $user_lname started scouting you.";
                         echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                 		break;

                 	case 'unfollow':
                 		 echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> $user_fname $user_lname stopped scouting you.";
                         echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                 		break;

                 	case 'checkout':

                 		if($user_id != $user_from_id){
                        	echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> Your item was checked out from bazaar.Please check your inbox to complete the sales! Thank you";
                            echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                    	}else{
                    		echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> You checked out an item from bazaar.The item owner will contact you soon! Thank you";
                            echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                    	}
                        break;

                    case 'welcome':
                        echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> Welcome To Talsgrad! find out More...";
                        echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                        break;

                 	case 'message':
                 		echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> You have more than 15 unread messages."; //code should be ejected in the user messages page whereby if unseen messages count is >15, insertion is made in the notifications table. 
                        echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
                 		break;

                 	default:
                 		echo "<img class='img-circle' src='users/$user_img' width='30' height='30'> $user_fname $user_lname made a $type.";
                        echo "<a href='notifications.php' style='float:right; font-size:10px; color:#fd4720;'> view all notifications</a> ";
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


				<li><a href='bazaar.php?<?php echo "u5Nm=$user_name" ?>' style="color: white;">Bazaar</a></li>
				<li><a href="messages.php?u5Nm=new" style="color: white;">Messages <?php echo "<span class='badge badge-secondary' style='background-color: #232742;'>$msg_rows</span>"; ?></a></li>
				
				<?php
						echo"

						<li class='dropdown'>
							<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false' style='background-color:#fd4720;'><span style='color: #232742;'><i class='glyphicon glyphicon-chevron-down'></i></span></a>
							<ul class='dropdown-menu'>
								<li>
									<a href='my_post.php?u5Nm=$user_name'>My Items <span class='badge badge-secondary' style='background-color: #232742;'>$posts</span></a>
								</li>
								<li>
									<a href='edit_profile.php'>Edit Account <span class='glyphicon glyphicon-pencil' style='color: #232742;'></span></a>
								</li>
                                <li>
                                    <a href='settings.php?u5Nm=$user_name'>Settings <span class='glyphicon glyphicon-cog' style='color: #232742;'></span></a>
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