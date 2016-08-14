<?php
session_start();
require 'Controller/DeviceController.php';
$deviceController = new DeviceController();
$title= "Add Device";

if(isset($_GET["update"]))
{
	$device = $deviceController->GetDevicesById($_GET["update"]);
	$deviceArray = array();
	$deviceArray = str_split($device->pin);
	$port = $deviceArray[0];
	$pin = $deviceArray[1];
	$content = "<form action='' method='post'>
    <fieldset>
        <legend>Update a Device</legend>
		<label for='type'>Category: </label>
        <select class='inputField' name='category'>
            <option value='l'". SelectedItem($device->category, 8) .">Lighting</option>
			<option value='h'". SelectedItem($device->category, 9) .">Heating & Ventilation</option>
			<option value='s'". SelectedItem($device->category, 10) .">Security</option>
		</select><br/><br/>
	
        <label for='name'>Name: </label>
        <input type='text' class='inputField' name='deviceName' value='$device->name'/><br/><br/>
	
		<label for='name'>Port: </label>
		<select class='inputField' name='port'>
            <option value='0'". SelectedItem($port, 0) .">Port A</option>
			<option value='1'". SelectedItem($port, 1) .">Port B</option>
			<option value='2'". SelectedItem($port, 2) .">Port C</option>
			<option value='3'". SelectedItem($port, 3) .">Port D</option>
			<option value='4'". SelectedItem($port, 4) .">Port E</option>
			<option value='5'". SelectedItem($port, 5) .">Port F</option>
		</select><br/><br/>
	
		<label for='name'>Pin: </label>
		<select class='inputField' name='pin'>
            <option value='0'". SelectedItem($pin, 0) .">Pin 0</option>
			<option value='1'". SelectedItem($pin, 1) .">Pin 1</option>
			<option value='2'". SelectedItem($pin, 2) .">Pin 2</option>
			<option value='3'". SelectedItem($pin, 3) .">Pin 3</option>
			<option value='4'". SelectedItem($pin, 4) .">Pin 4</option>
			<option value='5'". SelectedItem($pin, 5) .">Pin 5</option>
			<option value='5'". SelectedItem($pin, 5) .">Pin 6</option>
			<option value='5'". SelectedItem($pin, 7) .">Pin 7</option>
		</select><br/><br/>
	
        <input type='submit' value='Submit'>
    </fieldset>
					
</form>";
}else 
{
	$content = "<form action='' method='post'>
    <fieldset>
        <legend>Add a New Device</legend><br/>
		<label for='type'>Category: </label>
        <select class='inputField' name='category'>        
            <option value='l'>Lighting</option>
			<option value='h'>Heating & Ventilation</option>
			<option value='s'>Security</option>
		</select><br/><br/>
	
        <label for='name'>Name: </label>
        <input type='text' class='inputField' name='deviceName' /><br/><br/>
	
		<label for='name'>Port: </label>
		<select class='inputField' name='port'>
            <option value='0'>Port A</option>
			<option value='1'>Port B</option>
			<option value='2'>Port C</option>
			<option value='3'>Port D</option>
			<option value='4'>Port E</option>
			<option value='5'>Port F</option>
		</select><br/><br/>
	
		<label for='name'>Pin: </label>
		<select class='inputField' name='pin'>
            <option value='0'>Pin 0</option>
			<option value='1'>Pin 1</option>
			<option value='2'>Pin 2</option>
			<option value='3'>Pin 3</option>
			<option value='4'>Pin 4</option>
			<option value='5'>Pin 5</option>
			<option value='5'>Pin 6</option>
			<option value='5'>Pin 7</option>
		</select><br/><br/>
	
        <input type='submit' value='Submit'>
    </fieldset><br/><br/>
	</form>
	<form action='' method='post'>
	<fieldset>
        <legend>Add an Email Contact</legend><br/>
		<label width = '150px' for='type'>Email Address: </label>
        <input type='email' class='inputField' name='emailAddress'/><br/><br/>	
        <br/><input type='submit' value='Add Email'>
    </fieldset>			

</form>";	
}

function SelectedItem($choice, $id)
{
	switch($id)
	{
		case 0:
			if ($choice == '0')
			{
				return "selected";
			}
			break;
		case 1:
			if ($choice == '1')
			{
				return "selected";
			}
			break;
		case 2:
			if ($choice == '2')
			{
				return "selected";
			}
			break;
		case 3:
			if ($choice == '3')
			{
				return "selected";
			}
			break;
		case 4:
			if ($choice == '4')
			{
				return "selected";
			}
			break;
		case 5:
			if ($choice == '5')
			{
				return "selected";
			}
			break;
		case 6:
			if ($choice == '6')
			{
				return "selected";
			}
			break;
		case 7:
			if ($choice == '7')
			{
				return "selected";
			}
			break;
		case 8:
			if ($choice == 'l')
			{
				return "selected";
			}
			break;
		case 9:
			if ($choice == 'h')
			{
				return "selected";
			}
			break;
		case 10:
			if ($choice == 's')
			{
				return "selected";
			}
			break;
		default:
			echo("non");
			return ""; 			
				
	}
}

if(isset($_GET["update"]))
{
	if(isset($_POST["deviceName"]))
	{
		if( ! $deviceController->verifyUpdateName($_GET["update"]))
		{
			echo ("<script language='JavaScript'> window.alert('Please Use a Unique Name for the Device'); </script>");
		}
		elseif (! $deviceController->verifyUpdatePin($_GET["update"]))
		{
			echo ("<script language='JavaScript'> window.alert('Please Use a Unique Port and Pin for the Device'); </script>");
		}
		else
		{
			$deviceController->UpdateDevice($_GET["update"]);
		}
	}	
}else
{
	if(isset($_POST["deviceName"]))
	{
		if( ! $deviceController->verifyName())
		{
			echo ("<script language='JavaScript'> window.alert('Please Use a Unique Name for the Device'); </script>");			
		}
		elseif (! $deviceController->verifyPin())
		{
			echo ("<script language='JavaScript'> window.alert('Please Use a Unique Port and Pin for the Device'); </script>");
		}
		else 
		{
			$deviceController->AddDevice();			
		}		
	}
}

if(isset($_POST['emailAddress']))
{
	$deviceController->AddContactEmail($_POST['emailAddress']);
}

include 'Template.php';

?>