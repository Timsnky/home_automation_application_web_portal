<?php
require ("Modules/DeviceModel.php");

class GSM
{
	function UpdateStatusWithPin($deviceStatusString)
	{
		$deviceModel = new DeviceModel();
		$deviceModel->UpdateStatusWithPin($deviceStatusString);
	}
	
	function Login($email, $password)
	{
		$deviceModel = new DeviceModel();
		return $deviceModel->Login($email, $password);
	}
	
	function SendAlarmEmail()
	{
		require 'Controller/DeviceController.php';
		
		$deviceModel = new DeviceModel();
		$emailArray = array();
		$emailArray = $deviceModel->GetContactEmails();
		
		foreach ($emailArray as $email)
		{
			$deviceController = new DeviceController();
			$deviceController->SendAlarmEmail("Alarm", $email);			
		}
	}
	
	function UpdateCameraImages($name)
	{
		$name = "Camera/". $name;
		$deviceModel = new DeviceModel();
		$deviceModel->UpdateCameraImages($name);		
	}
}
?>