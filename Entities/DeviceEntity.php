<?php

class DeviceEntity
{
	public $id;
	public $category;
	public $name;
	public $status;
	public $pin;
	public $image;
	
	function __construct($id,$category,$name,$pin, $status, $image)
	{
		$this->id = $id;
		$this->category = $category;
		$this->name = $name;
		$this->pin = $pin;
		$this->status = $status;
		$this->image = $image;
	}
}
?>