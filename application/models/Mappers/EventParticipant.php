<?php
    
class Model_Mapper_EventParticipant
{
	public static function isUserEventParticipant($userID, $eventID)
	{
		$table = new Model_DbTable_EventParticipant();
		
		$select = $table->select()
		                ->where('user_id = ?', $userID)
						->where('event_id = ?', $eventID);
		$result = $table->fetchAll($select);
		
		if(count($result) > 0)
			return true;
		else {
			return false;
		}
	}
	
	public static function subscribe($userID, $eventID)
	{
		$table = new Model_DbTable_EventParticipant();
		
		$data = array('user_id' => $userID,
					  'event_id' => $eventID);
					  
		$id = $table->insert($data);
	}
}