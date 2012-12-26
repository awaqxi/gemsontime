<?php
    
class Model_Entity_Friend
{
	private $id, $userID, $friendUserID;	
	
	public function setID($value)
	{
		$this->id = $value;
	}
	
	public function getID()
	{
		return $this->id;
	}
	
	public function setUserID($value)
	{
		$this->userID = $value;
	}
	
	public function getUserID()
	{
		return $this->userID;
	}
	
	public function setFriendUserID($value)
	{
		$this->friendUserID = $value;
	}
	
	public function getFriendUserID()
	{
		return $this->friendUserID;
	}
}