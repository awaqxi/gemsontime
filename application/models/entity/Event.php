<?php
    
class Model_Entity_Event
{
    private $id, $name, $startdate, $enddate, $isMine, $userRel, $venueId, $venueName, $timeType, $groupsTypes = array();
		
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
	
	public function setStartDate($value)
	{
		$this->startdate = $value;
	}
	
	public function getDate()
	{
		return $this->startdate;
	}
	
	public function setEndDate($value)
	{
		$this->enddate = $value;
	}
	
	public function getEndDate()
	{
		return $this->enddate;
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
	
	public function setTimeType($value)
    {
        $this->timeType = $value;
    }
    
    public function getTimeType()
    {
        return $this->timeType;
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
                        "startdate" => $this->startdate,
                        "enddate" => $this->enddate,
                        "venueId" => $this->venueId,
                        "venueName" => $this->venueName,
                        "userRel" => $this->userRel,
                        "timeType" => $this->timeType,
						"groupsTypes" => $this->groupsTypes);
                        
        return ($values);
    }
}