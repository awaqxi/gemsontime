<?php
    
class Model_Event
{
	public static function getUserEvents($userID, $bDate, $eDate)
	{
		$table = new Model_DbTable_Event();
        $result = $table->getUserEvents($userID, $bDate, $eDate);
       
        $events = array();
        foreach ($result as $object) {
            $event = new Model_Entity_Event();
            $event->setID($object['id']);
            $event->setName($object['name']);
            $event->setUserID($object['user_id']);
            $event->setDate($object['date']);
            
            $events[] = $event;
        }
        
        return $events;
	}
}