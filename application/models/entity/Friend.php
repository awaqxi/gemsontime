<?php
    
class Model_Entity_Friend
{
	private $id, $user_id, $friend_user_id;	
	
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
		$this->user_id = $value;
	}
	
	public function getUserID()
	{
		return $this->user_id;
	}
	
	public function setFriendUserID($value)
	{
		$this->friend_user_id = $value;
	}
	
	public function getFriendUserID()
	{
		return $this->friend_user_id;
	}
}