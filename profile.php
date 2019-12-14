<!DOCTYPE html>
<?php
session_start();
include("includes/header.php");

if(!isset($_SESSION['user_email'])){

	session_destroy();

	header("location: index.php");
}

if(isset($_SESSION['user_email'])){

	$email = $_SESSION['user_email'];
}

$update_activity = "UPDATE users SET last_activity = NOW() WHERE email = '$email'";
$run_update = mysqli_query($con, $update_activity);

if(isset($_GET['u5Nm']))
{
	$user_name = $_GET['u5Nm'];

	$get_user = "SELECT * FROM users WHERE user_name = '$user_name'";
	$run_user = mysqli_query($con, $get_user);
	$row_user = mysqli_fetch_array($run_user);

	$user_email = $row_user['email'];
	$f_name = $row_user['f_name'];
	$l_name = $row_user['l_name'];
	$describe_user = $row_user['describe_user'];
	$profession = $row_user['profession'];
	$user_country = $row_user['user_country'];
	$user_gender = $row_user['user_gender'];
	$user_image = $row_user['user_image'];
	$user_reg_date = $row_user['user_reg_date'];


	if($email !== $user_email)
	{
		session_destroy();
		header("location: index.php");
	}

}





?>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>
<body>

	<div class='row'>
		<div>
			<center>

					    	
					    	<?php
								echo"
								
								<div id='profile-img'>
									<img src='users/$user_image' alt='Profile' width='250px' height='335px'>
									<form action='profile.php?u5Nm='$user_name' method='post' enctype='multipart/form-data'>

									<label id='update_profile'> Select Profile
									<input type='file' name='u_image' size='60'/>
									</label><br>
									<button id='button_profile' name='update' class='btn btn-info' style='background-color:#fd4720;'>Update Profile</button>
									</form>
								</div>
								";
							?>

								<?php
									if(isset($_POST['update'])){

											$u_image = $_FILES['u_image']['name'];
											$image_tmp = $_FILES['u_image']['tmp_name'];
											$random_number = rand(1,100);

											if($u_image==''){
												echo "<script>alert('Please Select Profile Image on clicking on your profile image')</script>";
												echo "<script>window.open('profile.php?u5Nm=$user_name' , '_self')</script>";
												exit();
											}else{
												move_uploaded_file($image_tmp, "users/$u_image.$random_number");
												$update = "update users set user_image='$u_image.$random_number' where user_id='$user_id'";

												$run = mysqli_query($con, $update);

												if($run){
												echo "<script>alert('Your Profile Updated')</script>";
												echo "<script>window.open('profile.php?u5Nm=$user_name' , '_self')</script>";
												}
											}

										}
								?>

					   
					   		<?php
								echo"
									<center><h2><strong>About</strong></h2></center>
									<center><h4><strong>$first_name $last_name</strong></h4></center>
									<p><strong><i style='color:grey;'>$describe_user</i></strong></p><br>
									<p><strong>Profession: </strong> $profession</p><br>
									<p><strong>Lives In: </strong> $user_country</p><br>
									<p><strong>Member Since: </strong> $register_date</p><br>
									<p><strong>Gender: </strong> $user_gender</p><br>

								";
								?>


			</center>
		</div>
	</div>
	<div class="row">
		
	</div>
	<div class="row">
		<center>
			<button class="btn btn-info" style="background-color: #fd4720; height: 100px; width: 60%;"><a href="my_tasks.php?u5Nm=<?php echo $user_name ?>" style="color: white; font-size: 20px;">VIEW YOUR TASKS</a></button>
		</center>
	</div>
	<div class="row" style="margin-bottom: 20px;">
		
	</div>
	<div class="row">
		<center>

		<!-- I got these buttons from simplesharebuttons.com -->
		<div id="share-buttons">
		    
		    <!-- Buffer -->
		    <a href="https://bufferapp.com/add?url=profile.php?u5Nm=$user_name&amp;text=Profile on wennotate" target="_blank">
		        <img src="images/share_buttons/buffer.png" alt="Buffer" />
		    </a>
		    
		    <!-- Digg -->
		    <a href="http://www.digg.com/submit?url=profile.php?u5Nm=$user_name" target="_blank">
		        <img src="images/share_buttons/diggit.png" alt="Digg" />
		    </a>
		    
		    <!-- Email -->
		    <a href="mailto:?Subject=Simple Share Buttons&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 profile.php?u5Nm=$user_name">
		        <img src="images/share_buttons/email.png" alt="Email" />
		    </a>
		 
		    <!-- Facebook -->
		    <a href="http://www.facebook.com/sharer.php?u=profile.php?u5Nm=$user_name" target="_blank">
		        <img src="images/share_buttons/facebook.png" alt="Facebook" />
		    </a>
		    
		    <!-- Google+ -->
		    <a href="https://plus.google.com/share?url=profile.php?u5Nm=$user_name" target="_blank">
		        <img src="images/share_buttons/google.png" alt="Google" />
		    </a>
		    
		    <!-- LinkedIn -->
		    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=profile.php?u5Nm=$user_name" target="_blank">
		        <img src="images/share_buttons/linkedin.png" alt="LinkedIn" />
		    </a>
		    
		    <!-- Pinterest -->
		    <a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());">
		        <img src="images/share_buttons/pinterest.png" alt="Pinterest" />
		    </a>
		    
		    <!-- Print -->
		    <a href="javascript:;" onclick="window.print()">
		        <img src="images/share_buttons/print.png" alt="Print" />
		    </a>
		    
		    <!-- Reddit -->
		    <a href="http://reddit.com/submit?url=profile.php?u5Nm=$user_name&amp;title=Profile on wennotate" target="_blank">
		        <img src="images/share_buttons/reddit.png" alt="Reddit" />
		    </a>
		    
		    <!-- StumbleUpon-->
		    <a href="http://www.stumbleupon.com/submit?url=profile.php?u5Nm=$user_name&amp;title=Profile on wennotate" target="_blank">
		        <img src="images/share_buttons/stumbleupon.png" alt="StumbleUpon" />
		    </a>
		    
		    <!-- Tumblr-->
		    <a href="http://www.tumblr.com/share/link?url=profile.php?u5Nm=$user_name&amp;title=Profile on wennotate" target="_blank">
		        <img src="images/share_buttons/tumblr.png" alt="Tumblr" />
		    </a>
		     
		    <!-- Twitter -->
		    <a href="https://twitter.com/share?url=profile.php?u5Nm=$user_name&amp;text=Task%20on%20wennotate&amp;hashtags=profileonwennotate" target="_blank">
		        <img src="images/share_buttons/twitter.png" alt="Twitter" />
		    </a>
		    
		    <!-- VK -->
		    <a href="http://vkontakte.ru/share.php?url=profile.php?u5Nm=$user_name" target="_blank">
		        <img src="images/share_buttons/vk.png" alt="VK" />
		    </a>
		    
		    <!-- Yummly -->
		    <a href="http://www.yummly.com/urb/verify?url=profile.php?u5Nm=$user_name&amp;title=Profile on wennotate" target="_blank">
		        <img src="images/share_buttons/yummly.png" alt="Yummly" />
		    </a>

		</div>
	</center>
		
	</div>

</body>
</html>