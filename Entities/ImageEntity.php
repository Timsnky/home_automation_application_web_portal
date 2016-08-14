<?php

class ImageEntity
{
	public $name;
	public $imagelink;
	
	function __construct($name,$imagelink)
	{
		$this->name = $name;
		$this->imagelink = $imagelink;
	}
}
?>