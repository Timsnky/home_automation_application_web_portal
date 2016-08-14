<?php
session_start();

require 'Controller/DeviceController.php';
$images = "";
if(isset($_POST['imageDate']))
{
	$deviceController = new DeviceController();
	$images = $deviceController->createImageTable($_POST['imageDate']);	
}

$title = "Camera Images";
$content = "<!DOCTYPE html>
				<html>
					<body>
						<fieldset>
							<legend>Image Search</legend>
							<h5>Please Enter the Date for the Images</h5>
							<form action='CameraImages.php' method = 'post'>
							  	Date:&nbsp;&nbsp;
							  	<input type='date' name='imageDate' placeholder='YYYYMMDD'> &nbsp&nbsp;
							  	<input type='submit' name = 'submitDate' value= 'Submit'>
							</form>
						</fieldset>					
					</body><br><br/>
				</html>" . $images;
include 'Template.php';

$deviceController = new DeviceController();
?>