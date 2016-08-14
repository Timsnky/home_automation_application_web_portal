<?php
session_start();
include 'Controller/DeviceController.php';

$deviceController = new DeviceController();

$title = "Manage Devices";
$content = $deviceController->CreateOverviewTable();

if(isset($_GET["delete"]))
{
	$deviceController->DeleteDevice($_GET["delete"]);
}

include 'Template.php';
?>