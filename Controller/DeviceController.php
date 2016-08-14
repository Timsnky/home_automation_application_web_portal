<script>
//Display a confirmation box when trying to delete an object
function showConfirm(id)
{
    // build the confirmation box
    var c = confirm("Are you sure you wish to delete this item?");
    
    // if true, delete item and refresh
    if(c)
        window.location = "Overview.php?delete=" + id;
}
</script>
    
<script>
//Display a confirmation box when trying to delete an object
function handleRadioClicks(id, status, category)
{
    if(category == 1)
	{
		window.location = "LightControl.php?radioId=" + id +"&status=" + status; 
	}
	else if(category == 2)
	{
		window.location = "HvacControl.php?radioId=" + id + "&status=" + status; 
	}
	else
	{
		window.location = "Security.php?radioId=" + id + "&status=" + status; 
	}
}
</script>

<?php
require ("Modules/DeviceModel.php");

class DeviceController
{
	function Login($email, $password)
	{
		$deviceModel = new DeviceModel();
		return $deviceModel->Login($email, $password);
	}
	
	function createDeviceTable($category)
	{
		$deviceModel = new DeviceModel();
		$devicesArray = $deviceModel->GetDevices($category);
		$result = "";
		
		foreach ($devicesArray as $key => $device)
		{		
			$deviceCategory = $this->getCategoryNumber($category);
			$result = $result .
					"<table class = 'deviceTable' id = '$device->name'>
						<tr>
                            <th rowspan='3' width = '150px' ><img class = '$device->category' runat = 'server' src = '$device->image' /></th>
                            <th width = '75px' >Name: </th>
                            <td>$device->name</td>					
						</tr>
						<tr>
                            <th>Pin: </th>
                            <td>$device->pin</td>
                        </tr>
                        <tr>
                            <th>Status: </th>                            
                            <td>
                            	<input type='radio' name='$device->name' onclick='handleRadioClicks($device->id, 1, $deviceCategory)' value='on'".$this->selectRadioButton($device->status,1)." > On</input>
								<input type='radio' name='$device->name' onclick='handleRadioClicks($device->id, 0, $deviceCategory)' value='off' ".$this->selectRadioButton($device->status,0)."> Off</input>
                            </td> 
                        </tr>					
					</table>";
		}
		return $result;
	}
	
	function createImageTable($date)
	{
		if($date == "")
		{
			$date = '%';
		}
		$deviceModel = new DeviceModel();
		$imageArray = $deviceModel->GetCameraImages($date);
		$result = "";
		
		foreach ($imageArray as $key => $image)
		{
			$result = $result .
					"<a href = '$image->imagelink' target='_blank'><img class = 'image' runat = 'server' src = '$image->imagelink' ></a>";
		}
		return $result;
	}
	
	function UpdateStatusWithPin($deviceStatusString)
	{
		$deviceModel = new DeviceModel();
		$deviceModel->UpdateStatusWithPin($deviceStatusString);
	}
	
	function getCategoryNumber($category)
	{
		if($category == 'l')
		{
			return 1;
		}
		elseif($category == 'h')
		{
			return 2;
		}
		else 
		{
			return 3;
		}
	}
	
	function CreateOverviewTable() {
		$result = "
			<fieldset>
        	<legend>Device Overview Table</legend><br/>
            <table class='overViewTable'>
                <tr>
                    <td></td>
                    <td></td>
					<td><b>Id</b></td>
                    <td><b>Name</b></td>
                    <td><b>Category</b></td>
                    <td><b>Pin</b></td>
                    <td><b>Status</b></td>
                </tr>";
	
		$deviceArray = $this->GetDevices('%');
	
		foreach ($deviceArray as $key => $device) {
			$deviceCategory = $this->getCategory($device->category);
			$deviceStatus = $this->getStatus($device->status);
			$result = $result .
			"<tr>
			<td><a href='AddDevice.php?update=$device->id'>Update</a></td>
			<td><a href='#' onclick='showConfirm($device->id)'>Delete</a></td>
			<td>$device->id</td>
			<td>$device->name</td>
			<td>$deviceCategory</td>
			<td>$device->pin</td>
			<td>$deviceStatus</td>
			</tr>";
		}	
		$result = $result . "</table></fieldset>";
			return $result;
	}
	
	function getCategory($category)
	{
		if($category == 'l')
		{
			return "Lighting";
		}elseif ($category == 'h')
		{
			return "HVAC";
		}elseif ($category == 's')
		{
			return "Security";
		}		
	}
	
	function getStatus($status)
	{
		if($status == '1')
		{
			return "On";
		}else
		{
			return "Off";
		}
	}
	
	function selectRadioButton($status,$type){
		if ($type==1){
			if($status==1){
				return "checked";				
			}
			else{
				return "";
			}
		}
		else{
			if($status==1){
				return "";
			}
			else{
				return "checked";
			}
		}		
	}
	
	function GetDevices($category)
	{
		$deviceModel = new DeviceModel();
		return $deviceModel->GetDevices($category);
	}
	
	function GetDevicesById($id) 
	{
		$deviceModel = new DeviceModel();
		return $deviceModel->GetDevicesById($id);
	}
	
	function AddDevice()
	{
		$name = $_POST["deviceName"];
		$category = $_POST["category"];
		$pin = $_POST["port"] . $_POST["pin"];
		$image = "";
		$status = "0";
		
		$device = new DeviceEntity(-1, $category, $name, $pin, $status, $image);
		$deviceModel = new DeviceModel();
		$deviceModel->AddDevice($device);
	}
	
	function AddContactEmail($email)
	{
		$deviceModel = new DeviceModel();
		return $deviceModel->AddContactEmail($email);
	}
	
	function AddUser($email, $userpassword, $phone)
	{
		$deviceModel = new DeviceModel();
		return $deviceModel->AddUser($email, $userpassword, $phone);
	}
	
	function UpdateDevice($id)
	{
		$name = $_POST["deviceName"];
		$category = $_POST["category"];
		$pin = $_POST["port"] . $_POST["pin"];
		$image = "";
		$status = "0";
	
		$device = new DeviceEntity($id, $category, $name, $pin, $status, $image);
		$deviceModel = new DeviceModel();
		$deviceModel->UpdateDevice($id, $device);
	}
	
	function DeleteDevice($id)
	{
		$deviceModel = new DeviceModel();
		$deviceModel->DeleteDevice($id);
	}
	
	function verifyName()
	{
		$name = $_POST["deviceName"];
		$deviceModel = new DeviceModel();
		return $deviceModel->VerifyName($name);
	}
	
	function verifyPin()
	{
		$pin = $_POST["port"] . $_POST["pin"];
		$deviceModel = new DeviceModel();
		return $deviceModel->VerifyPin($pin);
	}
	
	function verifyEmail($email)
	{		
		$deviceModel = new DeviceModel();
		return $deviceModel->VerifyEmail($email);
	}
		
	function verifyUpdateName($id)
	{
		$name = $_POST["deviceName"];
		$deviceModel = new DeviceModel();
		return $deviceModel->VerifyUpdateName($name, $id);
	}
	
	function verifyUpdatePin($id)
	{
		$pin = $_POST["port"] . $_POST["pin"];
		$deviceModel = new DeviceModel();
		return $deviceModel->VerifyUpdatePin($pin, $id);
	}
	
	function UpdateStatus($id, $status)
	{
		$deviceModel = new DeviceModel();
		$deviceModel->UpdateStatus($id, $status);
	}
	
	function GetPin($id)
	{
		$deviceModel = new DeviceModel();
		return $deviceModel->GetPin($id);
	}

	function GetEmail()
	{
		$deviceModel = new DeviceModel();
		return $deviceModel->GetEmail();
	}
	
	function SendEmail($message)
	{		
		require 'Email/class.phpmailer.php';
		include 'Email/class.smtp.php'; // optional, gets called from within class.phpmailer.php if not already loaded
		
		$mail             = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = "mail.gmail.com"; // SMTP server
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
		$mail->Username   = "homeapplicationwebsite@gmail.com";  // GMAIL username
		$mail->Password   = "echelon5341";            // GMAIL password
		
		$mail->SetFrom('homeapplicationwebsite@gmail.com', 'Home App Website');
		
		$mail->AddReplyTo("homeapplicationwebsite@gmail.com","Home App Website");
		
		$mail->Subject    = $message;
		$mail->MsgHTML("Home Control");
		
		$address = $this->GetEmail();
		$mail->AddAddress($address, "Home Application");
				
		if(!$mail->Send()) {
			$this->SendEmail();
		} else {
		}		
	}
	
	function SendAlarmEmail($message, $email)
	{
		require 'Email/class.phpmailer.php';
		include 'Email/class.smtp.php'; // optional, gets called from within class.phpmailer.php if not already loaded
	
		$mail             = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = "mail.gmail.com"; // SMTP server
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
		$mail->Username   = "homeapplicationwebsite@gmail.com";  // GMAIL username
		$mail->Password   = "echelon5341";            // GMAIL password
	
		$mail->SetFrom('homeapplicationwebsite@gmail.com', 'Home App Website');
	
		$mail->AddReplyTo("homeapplicationwebsite@gmail.com","Home App Website");
	
		$mail->Subject    = "Home Application";
		$mail->MsgHTML($message);
		
		$mail->AddAddress($email, "Home Application");
	
		if(!$mail->Send()) {
			$this->SendEmail();
		} else {
		}
	}
}
?>