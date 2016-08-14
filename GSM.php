<?php
if(isset($_GET["data"]))
{
	require 'Controller/GSM.php';

	
	$gsmController = new GSM();
	$authenticated = $gsmController->Login($_GET["email"], $_GET["password"]);
	if($authenticated)
	{
		if($_GET['data'] == "e")
		{
			$gsmController->SendAlarmEmail();
		}
		else
		{
			$command = $_GET["data"];
			$operation = substr($command, 0, 1);
			$command = substr($command, 1);
			if($operation == "d")
			{
				$gsmController->UpdateStatusWithPin($_GET["data"]);
				echo ("#Done#");
			}
			else if ($operation == "c")
			{
				$gsmController->UpdateCameraImages($_GET["data"]);
				echo ("#Done");	
			}
			
		}
		
	}
}
?>