<?php
    
class Model_Entity_Event
{
    private $id;
	private $name;
	private $user_id;
	private $date;
	
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
	
	public function setUserID($value)
	{
		$this->user_id = $value;
	}
	
	public function getUserID()
	{
		return $this->user_id;
	}
	
	public function setDate($value)
	{
		$this->date = $value;
	}
	
	public function getDate()
	{
		return $this->date;
	}
    
    public function getArray()
    {        
        $values = array("id" => $this->id, 
                        "name" => $this->name, 
                        "userID" => $this->user_id, 
                        "date" => $this->date);
                        
        return ($values);
    }
}