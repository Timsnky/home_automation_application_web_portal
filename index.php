<?php
session_start();

require 'Controller/DeviceController.php';

$deviceController = new DeviceController(); 

if (isset($_POST['login']))
{	
	require 'Modules/Credentials.php';
	
	$email = $_POST["email"];
	$userpassword = $_POST["password"];
	$authenticated = $deviceController->Login($email, $userpassword);
	if($authenticated)
	{
		$_SESSION["useremail"] = $email;
		header('Location:Home.php');
	}
	else 
	{
		echo ("<script language='JavaScript'> window.alert('You have entered an invalid Email or Password'); </script>");
	}
}?>

<!DOCTYPE html>
<html>
	<head>	
	  <meta charset="UTF-8">	
	  <title>Home Application Login</title>
	  <link rel="shortcut icon" href="homeicon.ico" >
	  <link rel="stylesheet" href="Styles/style.css" media="screen" type="text/css" />
	</head>
	
	<body>	
		<div class="login-card">
		      <h1>Log in</h1><br><br><br>
			  <form action='index.php' method='post'>
			    <input type="text" name="email" placeholder="Email Address">
			    <input type="password" name="password" placeholder="Password">
			    <input type="submit" name="login" class="login login-submit" value="Login">
			  </form>		
			  <div class="login-help">
			    <a href="Register.php">Register</a> • <a href="#">Forgot Password</a>
			  </div>
		</div>
	</body>

</html>