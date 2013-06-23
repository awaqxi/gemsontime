<?php
    
class Model_Entity_User
{
	private $id, $name, $email, $password, $isConfirmed, $checkSum;	
	
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
	
	public function setEmail($value)
	{
		$this->email = $value;
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function setPassword($value)
	{
		$this->password = $value;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function setIsConfirmed($value)
	{
		$this->isConfirmed = $value;
	}
	
	public function getIsConfirmed()
	{
		return $this->isConfirmed;
	}
	
	public function setCheckSum($value)
	{
		$this->checkSum = $value;
	}
	
	public function getCheckSum()
	{
		return $this->checkSum;
	}
}