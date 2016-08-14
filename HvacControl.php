<?php
session_start();
require 'Controller/DeviceController.php';
$deviceController = new DeviceController();

$hvacDevices = $deviceController->createDeviceTable('h');

$title = "Heating & Ventilation Control";
$content = $hvacDevices;

if(isset($_GET["radioId"]))
{
	$deviceController->UpdateStatus($_GET["radioId"], $_GET["status"]);
	$pin = $deviceController->GetPin($_GET["radioId"]);
	$message = "#c" .$pin. "1" .$_GET["status"]. "#";
	$deviceController->SendEmail($message);
	header('Location: HvacControl.php');
}

include 'Template.php';

?>