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
	<title>Welcome to wennotate: <?php echo "$user_fname $user_lname"; ?>. Find tasks, complete tasks, get paid!</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>

<body>
<div class="row">
	<div class="col-sm-12">
		<center><h2><strong>Welcome to wennotate</strong></h2><br></center>

		<center><h5><strong>Dear <?php echo "$user_fname $user_lname, "; ?>thank you for joining wennotate, to know more about our platform and how you can reap benefits from it, please read further!</strong></h5><br></center>
		<div class='col-sm-3'>
		</div>
		<div id='posts' class='col-sm-6'>
			<center><h3 style="margin-top: 0px;"><strong>Who is wennotate for?</strong></h3></center><br>
			<p class="glyphicon glyphicon-star"> The talented/gifted persons who want to share thier talents/gifts with the world.</p>
			<p class="glyphicon glyphicon-star"> The students who want to thier portfolio for future use in the job market.</p>
			<p class="glyphicon glyphicon-star"> The professionals who are building thier portfolio.</p>
			<p class="glyphicon glyphicon-star"> The talent scouts who want to find new talents.</p>
			<p class="glyphicon glyphicon-star"> The future greats who want to connect with great minds like them</p>
			<p class="glyphicon glyphicon-star"> The project managers seeking the best hands for thier projects.</p>
			<p class="glyphicon glyphicon-star"> The sportsmen and sportswomen who want to show thier capabilitites to the world.</p>
			<p class="glyphicon glyphicon-star"> The job seekers who want thier recommendations to reach the right people.</p>
			<p class="glyphicon glyphicon-star"> Every person who is looking for inspiration.</p><br>

			<center><h3 style="margin-top: 50px;"><strong>What can you do on wennotate?</strong></h3></center><br>
			<p class="glyphicon glyphicon-star"> Upload images of your works as your portfolio items.</p>
			<p class="glyphicon glyphicon-star"> Recommend other users to people.</p>
			<p class="glyphicon glyphicon-star"> Get recommended to people. If the need arises, you can also recommend yourself.</p>
			<p class="glyphicon glyphicon-star"> If the need arises, you can also recommend yourself.</p><br>
			<p class="glyphicon glyphicon-star"> Scout registered users.</p>
			<p class="glyphicon glyphicon-star"> If your portfolio item is something you can sell, you can list it on bazaar to find buyers who will appreciate you and your product.</p>
			<p class="glyphicon glyphicon-star"> And many other fucntionilties you will see once you use our platform.</p>

			<center><h3 style="margin-top: 50px;"><strong>How can you benefit from wennotate?</strong></h3></center><br>
			The simple rule to reap loads of benefit from Talsgrad is: 'post the right things, i.e your works/products, you working/doing what you do best, etc. In a nutshell, try to build your portfolio on the platform, so that people can recommend you and your work(s) can server as proof for you. And this is because, in a world where every other person has educational and professional certificates, what matters is what your mind and hands have done -- a  pointer to the marvels you can bring into existence by Grace.<br><br>

			<center><p style="color: #232742;"> THANK YOU, AND WELCOME TO wennotate!</p></center>

			<center><a href="edit_profile.php" style="color: #fd4720;"> START, BY EDITING YOUR PROFILE HERE</a></center>
		</div>
	</div>
</div>
</body>
</html>