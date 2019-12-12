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
	<title>Account Settings on Mechsupport. Find tasks, complete tasks, get paid!.</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>

<body>

<div class='row'>
	<div class='col-sm-2'>
	</div>
	<div class='col-sm-8'>
		<form action='' method='post' enctype='multipart/form-data'>
			<table class='table table-bordered table-hover'>
				<tr align='center'>
					<td colspan='6' class='active'><h2>Edit Your Profile</h2></td>
				</tr>
				<tr>
					<td style='font-weight: bold;'>Change Your Firstname</td>
					<td>
						<input class='form-control' type='text' name='f_name' value='<?php echo"$first_name"; ?>'>
					</td>
				</tr>
				<tr>
					<td style='font-weight: bold;'>Change Your Lastname</td>
					<td>
						<input class='form-control' type='text' name='l_name' value='<?php echo"$last_name"; ?>'>
					</td>
				</tr>
				<tr>
					<td style='font-weight: bold;'>Description</td>
					<td>
						<input class='form-control' type='text' name='describe_user' required value='<?php echo"$describe_user"; ?>'>
					</td>
				</tr>
				<tr>
					<td style='font-weight: bold;'>Profession</td>
					<td>
						<input class='form-control' type='text' name='profession' required value='<?php echo"$profession"; ?>'>
					</td>
				</tr>
				<tr>
					<td style='font-weight: bold;'>Password</td>
					<td>
						<input class='form-control' type='password' name='u_pass' id='mypass' required value='<?php echo"$user_pass"; ?>'>
						<input type='checkbox' onclick='show_password()'><strong>Show Password</strong>
					</td>
				</tr>
				<tr>
					<td style='font-weight: bold;'>Email</td>
					<td>
						<input class='form-control' type='email' name='u_email' required value='<?php echo"$user_email"; ?>'>
					</td>
				</tr>
				<tr>
					<td style='font-weight: bold;'>Country</td>
					<td>
						<select class='form-control' name='u_country'>
							<option><?php echo "$user_country"; ?></option>
							<option>Nigeria</option>
								<option>Afghanistan</option>
								<option>Albania</option>
								<option>Algeria</option>
								<option>Andorra</option>
								<option>Angola</option>
								<option>Antigua and Barbuda</option>
								<option>Argentina</option>
								<option>Armenia</option>
								<option>Australia</option>
								<option>Austria</option>
								<option>Azerbaijan</option>
								<option>Bahamas</option>
								<option>Bahrain</option>
								<option>Bangladesh</option>
								<option>Barbados</option>
								<option>Belarus</option>
								<option>Belgium</option>
								<option>Belize</option>
								<option>Benin</option>
								<option>Bhutan</option>
								<option>Bolivia</option>
								<option>Bosnia and Herzegovina</option>
								<option>Botswana</option>
								<option>Brazil</option>
								<option>Brunei</option>
								<option>Bulgaria</option>
								<option>Burkina Faso</option>
								<option>Burundi</option>
								<option>Cote d'Ivoire</option>
								<option>Cabo Verde</option>
								<option>Cambodia</option>
								<option>Cameroon</option>
								<option>Canada</option>
								<option>Central African Republic</option>
								<option>Chad</option>
								<option>Chile</option>
								<option>China</option>
								<option>Colombia</option>
								<option>Comoros</option>
								<option>Congo (Congo-Brazzaville)</option>
								<option>Costa Rica</option>
								<option>Croatia</option>
								<option>Cuba</option>
								<option>Cyprus</option>
								<option>Czechia (Czech Republic)</option>
								<option>Democratic Republic of Congo</option>
								<option>Denmark</option>
								<option>Djibouti</option>
								<option>Dominica</option>
								<option>Dominican Republic</option>
								<option>Ecuador</option>
								<option>Egypt</option>
								<option>El Salvador</option>
								<option>Equitorial Guinea</option>
								<option>Eriteria</option>
								<option>Estonia</option>
								<option>Eswatini (fmr. "Swaziland")</option>
								<option>Ethiopia</option>
								<option>Fiji</option>
								<option>Finland</option>
								<option>France</option>
								<option>Gabon</option>
								<option>Gambia</option>
								<option>Georgia</option>
								<option>Germany</option>
								<option>Ghana</option>
								<option>Greece</option>
								<option>Grenada</option>
								<option>Guatemala</option>
								<option>Guinea</option>
								<option>Guinea-Bissau</option>
								<option>Guyana</option>
								<option>Haiti</option>
								<option>Holy See</option>
								<option>Honduras</option>
								<option>Hungary</option>
								<option>Iceland</option>
								<option>India</option>
								<option>Indonesia</option>
								<option>Iran</option>
								<option>Iraq</option>
								<option>Ireland</option>
								<option>Israel</option>
								<option>Italy</option>
								<option>Jamaica</option>
								<option>Japan</option>
								<option>Jordan</option>
								<option>Kazakhstan</option>
								<option>Kenya</option>
								<option>Kiribati</option>
								<option>Kuwait</option>
								<option>Kyrgyzstan</option>
								<option>Laos</option>
								<option>Latvia</option>
								<option>Lebanon</option>
								<option>Lesotho</option>
								<option>Liberia</option>
								<option>Libya</option>
								<option>Liechtenstein</option>
								<option>Lithuania</option>
								<option>Luxembourg</option>
								<option>Madagascar</option>
								<option>Malawi</option>
								<option>Malaysia</option>
								<option>Maldives</option>
								<option>Mali</option>
								<option>Malta</option>
								<option>Marshall Islands</option>
								<option>Mauritania</option>
								<option>Mauritius</option>
								<option>Mexico</option>
								<option>Micronesia</option>
								<option>Moldova</option>
								<option>Monaco</option>
								<option>Mongolia</option>
								<option>Montenegro</option>
								<option>Morocco</option>
								<option>Mozambique</option>
								<option>Myanmar (formerly Burma)</option>
								<option>Namibia</option>
								<option>Nauru</option>
								<option>Nepal</option>
								<option>Netherlands</option>
								<option>New Zealand</option>
								<option>Nicaragua</option>
								<option>Niger</option>
								<option>Nigeria</option>
								<option>North Korea</option>
								<option>North Macedonia</option>
								<option>Norway</option>
								<option>Oman</option>
								<option>Pakistan</option>
								<option>Palau</option>
								<option>Palestine</option>
								<option>Panama</option>
								<option>Papua New Guinea</option>
								<option>Paraguay</option>
								<option>Peru</option>
								<option>Philippines</option>
								<option>Poland</option>
								<option>Portugal</option>
								<option>Qatar</option>
								<option>Romania</option>
								<option>Russia</option>
								<option>Rwanda</option>
								<option>Saint Kitts and Nevis</option>
								<option>Saint Lucia</option>
								<option>Saint Vincent and the Grenadines</option>
								<option>Samoa</option>
								<option>San Marino</option>
								<option>Sao Tome and Principe</option>
								<option>Saudi Arabia</option>
								<option>Senegal</option>
								<option>Serbia</option>
								<option>Seychelles</option>
								<option>Sierra Leone</option>
								<option>Singapore</option>
								<option>Slovakia</option>
								<option>Slovenia</option>
								<option>Solomon Islands</option>
								<option>Somalia</option>
								<option>South Africa</option>
								<option>South Korea</option>
								<option>South Sudan</option>
								<option>Spain</option>
								<option>Sri Lanka</option>
								<option>Sudan</option>
								<option>Suriname</option>
								<option>Sweden</option>
								<option>Switzerland</option>
								<option>Syria</option>
								<option>Tajikistan</option>
								<option>Tanzania</option>
								<option>Thailand</option>
								<option>Timor-Leste</option>
								<option>Togo</option>
								<option>Tonga</option>
								<option>Trinidad and Tobago</option>
								<option>Tunisia</option>
								<option>Turkey</option>
								<option>Turkmenistan</option>
								<option>Tuvalu</option>
								<option>Uganda</option>
								<option>Ukraine</option>
								<option>United Arab Emirates</option>
								<option>United Kingdom</option>
								<option>United States of America</option>
								<option>Uruguay</option>
								<option>Uzbekistan</option>
								<option>Vanuatu</option>
								<option>Venezuela</option>
								<option>Vietnam</option>
								<option>Yemen</option>
								<option>Zambia</option>
								<option>Zimbabwe</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style='font-weight: bold;'>Gender</td>
					<td>
						<select class='form-control' name='u_gender'>
							<option><?php echo "$user_gender"; ?></option>
							<option>Male</option>
							<option>Female</option>
						</select>
					</td>
				</tr>

				<!-- recover password option -->
				<tr>
					<td style='font-weight: bold;'>Forgotten Password
					</td>
					<td>
						<button type='button' class='btn btn-default' data-toggle='modal' data-target='#myModal'>Recover</button>

						<div id='myModal' class='modal fade' role='dialog'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header'>
										<button type='button' class='close' data-dismiss='modal'>&times;</button>
										<h4 class='modal-title'>Password Recovery</h4>
									</div>
									<div class='modal-body'>
										<form action='recovery.php?id=<?php echo "$user_id"; ?>' method='post' id='f'>
											<strong>What is your School Best Friend's Name?</strong>
											<textarea class='form-control' cols='83' rows='4' name='content' placeholder='Input Name'></textarea><br>
											<input class='btn btn-default' type='submit' name='sub' value='Submit' style='width: 100px;'><br><br>
											<pre>Answer the above question if you forgot your <br>password.</pre>
											<br><br>
										</form>
										<?php
											if(isset($_POST['sub'])){
												$bfn = htmlentities($_POST['content']);

												if($bfn == ''){
													echo"<script>alert('Please input an Answer')</script>";
													echo"<script>window.open('edit_profile.php', '_self')</script>";
												exit();
												}
												else{
													$update = "update users set recovery_account = '$bfn' where user_id='$user_id'";

													$run = mysqli_query($con, $update);

													if($run){
														echo"<script>alert('Working...')</script>";
														echo"<script>window.open('edit_profile.php', '_self')</script>";
													}else{
														echo"<script>alert('An error occured while updating your information.')</script>";
														echo"<script>window.open('edit_profile.php', '_self')</script>";
													}
												}
											}
										?>
									</div>
									<div class='modal-footer'>
										<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>

				<tr align='center'>
					<td colspan='6'>
						<input type='submit' class='btn btn-info' name='update' style='width: 250px; background-color: #fd4720;' value="Update">
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class='col-sm-2'>
	</div>
</div>
</body>
</html>
<?php 
	if(isset($_POST['update'])){
		$f_name = htmlentities($_POST['f_name']);
		$l_name = htmlentities($_POST['l_name']);
		$describe_user = htmlentities($_POST['describe_user']);
		$profession = htmlentities($_POST['profession']);
		$u_pass = htmlentities($_POST['u_pass']);
		$u_email = htmlentities($_POST['u_email']);
		$u_country = htmlentities($_POST['u_country']);
		$u_gender = htmlentities($_POST['u_gender']);

		$update = "update users set f_name='$f_name', l_name='$l_name', describe_user='$describe_user', profession='$profession', user_pass='$u_pass', email='$user_email', user_country='$u_country', user_gender='$u_gender' where user_id='$user_id'";

		$run = mysqli_query($con, $update);

		if($run){
			echo"<script>alert('Your Profile has been successfully updated')</script>";

			echo"<script>window.open('edit_profile.php?u5Nm=$user_name', '_self')</script>";
		}
	}
?>