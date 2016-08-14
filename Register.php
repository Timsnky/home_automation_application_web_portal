<?php

require 'Controller/DeviceController.php';
$deviceController = new DeviceController();

if (isset($_POST['create']))
{
	$email = $_POST["email"];
	$enterpassword = $_POST["enterpassword"];
	$confirmpassword = $_POST["confirmpassword"];
	$phone = $_POST["phone"];
	
	if($email == "")
	{
		echo ("<script language='JavaScript'> window.alert('Please Provide an Email Address'); </script>");
	}
	elseif (! $deviceController->verifyEmail($email))
	{
		echo ("<script language='JavaScript'> window.alert('Please Provide a Unique Email Address'); </script>");
	}
	elseif( $enterpassword == "")
	{
		echo ("<script language='JavaScript'> window.alert('Please Provide a Password for your Account'); </script>");
	}
	elseif ($confirmpassword == "")
	{
		echo ("<script language='JavaScript'> window.alert('Please Confirm the Password'); </script>");
	}
	elseif ($phone == "")
	{
		echo ("<script language='JavaScript'> window.alert('Please Provide a Phone Number'); </script>");
	}
	else 
	{
		$deviceController->AddUser($email, $enterpassword, $phone);
		echo ("<script language='JavaScript'> window.alert('Your Account has been Successfully Created. Please Login'); </script>");
		header('Location:index.php');
	}	
	
	if($authenticated)
	{
		$_SESSION["user"] = $email;
		header('Location:Home.php');
	}
	else
	{
		echo ("<script language='JavaScript'> window.alert('You have entered an invalid Email or Password'); </script>");
	}
}
?>

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
		      <h1>Register</h1><br><br><br>
			  <form action='Register.php' method='post'>
			    <input type="text" name="email" placeholder="Email Address">
			    <input type="password" name="enterpassword" placeholder="Enter Password">
			    <input type="password" name="confirmpassword" placeholder="Confirm Password">
			    <input type="text" name="phone" placeholder="Phone Number">
			    <input type="submit" name="create" class="login login-submit" value="Create Account">
			  </form>
		</div>
	</body>

</html>