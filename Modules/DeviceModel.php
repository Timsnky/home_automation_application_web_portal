<?php
require ("Entities/DeviceEntity.php");
require ('Entities/ImageEntity.php');

class DeviceModel
{	
	function Login($email, $userpassword)
	{
		require 'Modules/Credentials.php';
	
		mysql_connect($host, $user, $password) or die(mysql_error());
		mysql_select_db($database);
		
		$query = "SELECT * FROM users WHERE password = '$userpassword' AND email = '$email'";
		$result = mysql_query($query) or die ("Failed Query of " . $query);		
		
		if(mysql_num_rows($result) == 0)
		{
			return false;
		}
		else 
		{
			while ($row = mysql_fetch_array($result))
			{
				$_SESSION['userid'] = $row[0];	
			}
			return true;			 
		}
	}
	
	function GetDevices($category)
	{
		require 'Modules/Credentials.php';
		
		mysql_connect($host, $user, $password) or die(mysql_error());
		mysql_select_db($database);
		$result = mysql_query("SELECT * FROM devicedata". $_SESSION['userid'] ." WHERE category LIKE '$category'");
		$devicesArray = array();
		
		while ($row = mysql_fetch_array($result))
		{
			$id = $row[0];
			$name = $row[1];
			$category = $row[2];
			$pin = $row[3];
			$status = $row[4];
			$image = $this->GetImage($category, $status);

			$device = new DeviceEntity($id, $category, $name, $pin, $status, $image);
			array_push($devicesArray, $device);
		}
		
		mysql_close();
		return $devicesArray;		
	}
	
	function UpdateCameraImages($name)
	{
		require ('Credentials.php');
		
		$date = date("Ymd");		
		$query = sprintf("INSERT INTO cameraimages". $_SESSION['userid'] ."
                          (date, imagelink) VALUES ('%s','%s')",
				mysql_real_escape_string($date),
				mysql_real_escape_string($name));
		$this->PerformQuery($query);
	}
	
	function GetContactEmails()
	{
		require 'Modules/Credentials.php';
		
		mysql_connect($host, $user, $password) or die(mysql_error());
		mysql_select_db($database);
		$result = mysql_query("SELECT * FROM contacts". $_SESSION['userid']);
		$emailArray = array();
		
		while ($row = mysql_fetch_array($result))
		{
			$email = $row[0];
			array_push($emailArray, $email);
		}
		
		mysql_close();
		return $emailArray;		
	}
	
	function GetCameraImages($date)
	{
		require 'Modules/Credentials.php';
		
		mysql_connect($host, $user, $password) or die(mysql_error());
		mysql_select_db($database);
		$result = mysql_query("SELECT * FROM cameraimages". $_SESSION['userid'] ." WHERE date LIKE '$date'");
		$imagesArray = array();
		
		while ($row = mysql_fetch_array($result))
		{
			$name = $row[0];
			$imagelink = $row[1];
		
			$image = new ImageEntity($name,$imagelink);
			array_push($imagesArray, $image);
		}
		
		mysql_close();
		return $imagesArray;
		
	}
	
	function UpdateStatusWithPin($deviceStatusString)
	{
		require 'Modules/Credentials.php';
			
		mysql_connect($host, $user, $password) or die(mysql_errno());
		mysql_select_db($database);

		$deviceArray = array();
		$deviceArray = explode(":", $deviceStatusString);
		foreach ($deviceArray as $key => $device)
		{
			$deviceDetails = array();
			$deviceDetails = explode(",", $device);
			$pin = $deviceDetails[0];
			$status = $deviceDetails[1];
		
			$query = sprintf("UPDATE devicedata". $_SESSION['userid'] ."
					SET status = '%s' WHERE pin = $pin", $status);
			mysql_query($query) or die(mysql_error());
		}
		mysql_close();
	}
	
	function GetDevicesById($id)
	{
		require 'Credentials.php';
	
		mysql_connect($host, $user, $password) or die(mysql_error());
		mysql_select_db($database);
		$result = mysql_query("SELECT * FROM devicedata". $_SESSION['userid'] ." WHERE Id = '$id'");
	
		while ($row = mysql_fetch_array($result))
		{
			$name = $row[1];
			$category = $row[2];
			$pin = $row[3];
			$status = $row[4];
			$image = $this->GetImage($category, $status);
	
			$device = new DeviceEntity($id, $category, $name, $pin, $status, $image);
		}
			
		mysql_close();
		return $device;
	}
	
	function GetImage($category, $status)
	{
		if ($category == 'l')
		{
			if($status == '0')
			{
				return "Images/offLight.jpg";
			}else
			{
				return "Images/onLight.jpg";
			}
		}else if($category == 'h')
		{
			return "Images/hvac.jpg";
		}else if($category == 's')
		{
			if($status == '0')
			{
				return "Images/unlocked.jpg";
			}else
			{
				return "Images/locked.jpg";
			}			
		}
		return "";
	}
	
	function PerformQuery($query)
	{
		require 'Modules/Credentials.php';
		mysql_connect($host, $user, $password) or die(mysql_error());
		mysql_select_db($database);
		
		//Execute query and close connection
		mysql_query($query) or die(mysql_error());
		mysql_close();
	}
	
	function AddDevice(DeviceEntity $device)
	{
		require ('Credentials.php');
		
		$query = sprintf("INSERT INTO devicedata". $_SESSION['userid'] ."
                          (name, category, pin,status)
                          VALUES
                          ('%s','%s','%s','%s')",
				mysql_real_escape_string($device->name),
				mysql_real_escape_string($device->category),
				mysql_real_escape_string($device->pin),
				mysql_real_escape_string($device->status));
		$this->PerformQuery($query);
	}
	
	function AddContactEmail($email)
	{
		require ('Credentials.php');
		
		$query = sprintf("INSERT INTO contacts". $_SESSION['userid'] ."
                          (email) VALUES ('%s')",
				mysql_real_escape_string($email));
		$this->PerformQuery($query);		
	}
	
	function AddUser($email, $userpassword, $phone)
	{		
		require 'Modules/Credentials.php';
		
		mysql_connect($host, $user, $password) or die(mysql_error());
		mysql_select_db($database);
		
		$query = sprintf("INSERT INTO users
                          (email, password, phonenumber)
                          VALUES
                          ('%s','%s','%s')",
				mysql_real_escape_string($email),
				mysql_real_escape_string($userpassword),
				mysql_real_escape_string($phone));
		
		mysql_query($query) or die(mysql_error());
		
		$query = "SELECT id FROM users WHERE email = '$email'";
		$result = mysql_query($query) or die(mysql_error());
		
		while ($row = mysql_fetch_array($result))
		{
			$id = $row[0];
		}
		
		$table = "devicedata" . $id;
		
		$query = "CREATE TABLE ". $table ."
		(
		id int NOT NULL AUTO_INCREMENT UNIQUE,
		name varchar(255) NOT NULL UNIQUE,
		category varchar(5),
		pin varchar(5) UNIQUE,
		status varchar(5)
		)";

		mysql_query($query) or die(mysql_error());
		
		$table = "cameraimages" . $id;
		$query = "CREATE TABLE ". $table . "
				(
				date varchar(30) NOT NULL,
				imagelink varchar(255) NOT NULL UNIQUE
				)";
		mysql_query($query) or die(mysql_error());
		
		$table = "contacts" . $id;
		$query = "CREATE TABLE ". $table ."
				(
				email varchar(255) NOT NULL UNIQUE
				)";
		mysql_query($query) or die(mysql_error);
		
		mysql_close();
	}
	
	function DeleteDevice($id) {
		require 'Modules/Credentials.php';
		
		$query = "DELETE FROM devicedata". $_SESSION['userid'] ." WHERE id = $id";
		$this->PerformQuery($query);
	}
	
	function UpdateDevice($id, DeviceEntity $device)
	{
		require ('Credentials.php');
		
		$query = sprintf("UPDATE devicedata". $_SESSION['userid'] ."
                            SET name = '%s', category = '%s', pin = '%s' WHERE id = $id",
				mysql_real_escape_string($device->name),
				mysql_real_escape_string($device->category),
				mysql_real_escape_string($device->pin));
		$this->PerformQuery($query);
	}
	
	function UpdateStatus($id, $status)
	{
		require ('Credentials.php');
		
		$query = sprintf("UPDATE devicedata". $_SESSION['userid'] ."
				SET status = '%s' WHERE id = $id", $status);
		$this->PerformQuery($query);
	}
	
	function GetPin($id)
	{
		require 'Credentials.php';
		
		mysql_connect($host, $user, $password) or die(mysql_error());
		mysql_select_db($database);
		$result = mysql_query("SELECT pin FROM devicedata". $_SESSION['userid'] ." WHERE Id = '$id'");
		
		while ($row = mysql_fetch_array($result))
		{
			$pin = $row[0];
		}
			
		mysql_close();
		return $pin;		
	}
	
	function GetEmail()
	{
		require 'Modules/Credentials.php';
		
		mysql_connect($host, $user, $password) or die(mysql_error());
		mysql_select_db($database);
		$result = mysql_query("SELECT email FROM users WHERE id = '" . $_SESSION['userid'] ."'");
		
		while ($row = mysql_fetch_array($result))
		{
			$email = $row[0];
		}
			
		mysql_close();
		return $email;
		
	}
	
	function VerifyName($name)
	{
		require 'Modules/Credentials.php';
		mysql_connect($host, $user, $password) or die(mysql_error());
		mysql_select_db($database);
		
		$result = mysql_query("SELECT * FROM devicedata". $_SESSION['userid'] ." WHERE name='$name'");
		
		if(mysql_num_rows($result) == 0)
		{
			return true;
		}else 
		{
			return false;
		}		
	}
	
	function VerifyPin($pin)
	{
		require ('Modules/Credentials.php');
		mysql_connect($host, $user, $password) or die(mysql_error());
		mysql_select_db($database);
	
		$result = mysql_query("SELECT * FROM devicedata". $_SESSION['userid'] ." WHERE pin='$pin'");
	
		if(mysql_num_rows($result) == 0)
		{
			return true;
		}else
		{
			return false;
		}
	}
	
	function VerifyUpdateName($name, $id)
	{
		require ('Modules/Credentials.php');
		mysql_connect($host, $user, $password) or die(mysql_error());
		mysql_select_db($database);
	
		$result = mysql_query("SELECT * FROM devicedata". $_SESSION['userid'] ." WHERE name='$name'");
		
		if(mysql_num_rows($result) == 0)
		{
			return true;
		}
		elseif(mysql_num_rows($result) == 1)
		{
			while ($row = mysql_fetch_array($result))
			{
				if($row[0] == $id)
				{
					return true;
				}
				else
				{
					return false;
				}
			}			
		}
		else
		{
			return false;
		}				
	}
	
	function VerifyUpdatePin($pin, $id)
	{
		require 'Modules/Credentials.php';
		mysql_connect($host, $user, $password) or die(mysql_error());
		mysql_select_db($database);
	
		$result = mysql_query("SELECT * FROM devicedata". $_SESSION['userid'] ." WHERE pin='$pin'");
	
		if(mysql_num_rows($result) == 0)
		{
			return true;
		}
		elseif(mysql_num_rows($result) == 1)
		{
			while ($row = mysql_fetch_array($result))
			{
				if($row[0] == $id)
				{
					
					return true;
				}
				else
				{
					return false;
				}
			}			
		}
		else
		{
			return false;
		}
	}
	
	function VerifyEmail($email)
	{
		require 'Modules/Credentials.php';
		mysql_connect($host, $user, $password) or die(mysql_error());
		mysql_select_db($database);
	
		$result = mysql_query("SELECT * FROM users WHERE email='$email'");
	
		if(mysql_num_rows($result) == 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}