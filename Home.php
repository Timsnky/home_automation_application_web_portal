<?php
require 'Controller/DeviceController.php';

$title = "Home";
$content = "<div class='tile quadro bg-color-blue' data-role='tile-slider'  data-param-period='3000' data-param-direction='left'>       
	          <div class='tile-content'>
	        	<h2>Home Control System</h2>
	        	<p>&nbsp;</p>
	        	<p>Is a Control System that gives you remote access to all your appliances at home wherever and whenever you are</p>
	        </div>
	        <div class='tile-content'>
	        	<h2>HelpDesk Sys</h2>
	        	<p>&nbsp;</p>
	        	<p>All you need is either your computer, your tablet or smartphone and you will have access to your home by the press of a button</p>	         
	        </div>
        </div>
		<div class='tile double bg-color-orange' data-role='tile-slider'  data-param-period='3000' data-param-direction='left'>       
	          <div class='tile-content'>
	        	<h2>Lighting</h2>
	        	<p>&nbsp;</p>
	        	<p>Check on the status of you Lighting appliances on the go and choose to switch them on or off when you are away</p>
	        </div>
	        <div class='tile-content'>
	        	<h2>Heating</h2>
	        	<p>&nbsp;</p>
	        	<p>Take control of the various heating devices at your home simply by the click of a button</p>	         
	        </div>
        </div>
		<div class='tile double bg-color-green' data-role='tile-slider'  data-param-period='3000' data-param-direction='left'>       
	          <div class='tile-content'>
	        	<h2>Ventilation</h2>
	        	<p>&nbsp;</p>
	        	<p>Ensure your home is properly ventilated; access the devices remotely</p>
	        </div>
	        <div class='tile-content'>
	        	<h2>Email Alerts</h2>
	        	<p>&nbsp;</p>
	        	<p>Incase of Intruders in your home Email Alerts can be sent to selected recipients right away</p>	         
	        </div>
        </div>
		<div class='tile double bg-color-blueDark' data-role='tile-slider'  data-param-period='3000' data-param-direction='left'>       
	          <div class='tile-content'>
	        	<h2>Security</h2>
	        	<p>&nbsp;</p>
	        	<p>Safety is key in your home a with remote access you can regularly check</p>
	        </div>
	        <div class='tile-content'>
	        	<h2>Camera Pictures</h2>
	        	<p>&nbsp;</p>
	        	<p>In addition to the security locking systems, surveillance camera pictures can also be accessed for better monitoring </p>	         
	        </div>
        </div>
		<div class='tile double bg-color-blueDark' data-role='tile-slider'  data-param-period='3000' data-param-direction='left'>       
	          <div class='tile-content'>
	        	<h2>Manage</h2>
	        	<p>&nbsp;</p>
	        	<p>You can either update or delete the controlled devices as desired</p>
	        </div>
	        <div class='tile-content'>
	        	<h2>Add</h2>
	        	<p>&nbsp;</p>
	        	<p>Adding of new devices is made as simplified as possible</p>	         
	        </div>
        </div>";
include 'Template.php';

$deviceController = new DeviceController();
?>