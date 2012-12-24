<?php
    
class Model_Entity_Event
{
    private $id;
	private $name;
	private $date;
	private $is_mine;
	
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
	
	public function setDate($value)
	{
		$this->date = $value;
	}
	
	public function getDate()
	{
		return $this->date;
	}
	
	public function setIsMine($value)
	{
		$this->is_mine = $value;
	}
	
	public function getIsMine()
	{
		return $this->is_mine;
	}
    
    public function getArray()
    {        
        $values = array("id" => $this->id, 
                        "name" => $this->name, 
                        "isMine" => $this->is_mine, 
                        "date" => $this->date);
                        
        return ($values);
    }
}