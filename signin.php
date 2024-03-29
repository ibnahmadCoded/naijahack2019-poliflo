<!DOCTYPE html>
<html>
<head>
	<title>Signin on Mechsupport</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-150440751-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-150440751-1');
	</script>
</head>
<style>
@import url(https://fonts.googleapis.com/css?family=Roboto:300);

.login-page {
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
}
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #fd4720;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,.form button:active,.form button:focus {
  background: #b589d6;
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: #4CAF50;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}
.container:before, .container:after {
  content: "";
  display: block;
  clear: both;
}
.container .info {
  margin: 50px auto;
  text-align: center;
}
.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}
.container .info span {
  color: #4d4d4d;
  font-size: 12px;
}
.container .info span a {
  color: #000000;
  text-decoration: none;
}
.container .info span .fa {
  color: #EF3B3A;
}
body {
  background: #87CEEB; /* fallback for old browsers */
  background: -webkit-linear-gradient(right, #87CEEB, #87CEEB);
  background: -moz-linear-gradient(right, #87CEEB, #87CEEB);
  background: -o-linear-gradient(right, #87CEEB, #87CEEB);
  background: linear-gradient(to left, #87CEEB, #87CEEB);
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;      
}
.overlap-text{
		position: relative;
	}
	.overlap-text a{
		position: absolute;
		top: 18px;
		right: 10px;
		font-size: 14px;
		text-decoration: none;
		font-family: "Roboto", sans-serif;
		outline: 0;
		background: #f2f2f2;

	}
</style>
<body>

<div class="login-page">
  <div class="form">
    <form action="" method="post" class="login-form">
      <input type="email" name="email" placeholder="Email" required="required"/>
      <div class="overlap-text">
      <input type="password" name="pass" placeholder="Password" required="required"/>
      <a style="text-decoration:none;float: right;color: #fd4720;" data-toggle="tooltip" title="Reset Password" href="forgot_password.php">Forgot?</a>
  </div>
      <button id="signin" name="login">login</button>
      
      <p class="message">Not registered? <a style="color: #fd4720;" href="signup.php">Create an account</a></p>
      <?php include("login.php"); ?>
    </form>
  </div>
</div>
</body>
</html>