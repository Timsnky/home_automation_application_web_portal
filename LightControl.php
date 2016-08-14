<?php
session_start();
require 'Controller/DeviceController.php';
$deviceController = new DeviceController();

$lightDevices = $deviceController->createDeviceTable('l');

$title = "Lighting Control";
$content = $lightDevices;

if(isset($_GET["radioId"]))
{
	$deviceController->UpdateStatus($_GET["radioId"], $_GET["status"]);
	$pin = $deviceController->GetPin($_GET["radioId"]);
	$message = "#c" .$pin. "1" .$_GET["status"]. "#";
	$deviceController->SendEmail($message);
	header('Location: LightControl.php');
}

include 'Template.php';

?>