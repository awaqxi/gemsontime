<?php
    
class Model_Entity_Event
{
    private $id, $name, $date, $isMine, $userRel, $venueId, $venueName, $groupsTypes = array();
		
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
		$this->isMine = $value;
	}
	
	public function getIsMine()
	{
		return $this->isMine;
	}

	public function setVenueID($value)
    {
        $this->venueId = $value;
    }
    
    public function getVenueID()
    {
        return $this->venueId;
    }
	
	public function setVenueName($value)
    {
        $this->venueName = $value;
    }
    
    public function getVenueName()
    {
        return $this->venueName;
    }

	public function setUserRel($value)
    {
        $this->userRel = $value;
    }
    
    public function getUserRel()
    {
        return $this->userRel;
    }

	public function setGroupsTypes($value)
	{
		$this->groupsTypes = $value;
	}
	
	public function getGroupsTypes()
	{
		return $this->groupsTypes;
	}
	
	public function addGroupType($value)
	{
		$this->groupsTypes[] = $value;
	}	
    
    public function getArray()
    {        
        $values = array("id" => $this->id, 
                        "name" => $this->name, 
                        "isMine" => $this->isMine, 
                        "date" => $this->date,
                        "venueId" => $this->venueId,
                        "venueName" => $this->venueName,
                        "userRel" => $this->userRel,
						"groupsTypes" => $this->groupsTypes);
                        
        return ($values);
    }
}