<?php
    
class Model_Entity_EventGroup
{
	private $id, $name, $css;	
	
	public function setID($value)
	{
		$this->id = $value;
	}
	
	public function getID()
	{
		return $this->id;
	}
	
	public function setName($value)
	{
		$this->name = $value;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function setCSS($value)
	{
		$this->css = $value;
	}
	
	public function getCSS()
	{
		return $this->css;
	}
}