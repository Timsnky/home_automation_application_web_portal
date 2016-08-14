<?php
session_start();
require 'Controller/DeviceController.php';
$deviceController = new DeviceController();

$securityDevices = $deviceController->createDeviceTable('s');

$title = "Security Control";
$content = $securityDevices;

if(isset($_GET["radioId"]))
{
	$deviceController->UpdateStatus($_GET["radioId"], $_GET["status"]);
	$pin = $deviceController->GetPin($_GET["radioId"]);
	$message = "#c" .$pin. "1" .$_GET["status"]. "#";
	$deviceController->SendEmail($message);
	header('Location: Security.php');
}
include 'Template.php';

?>