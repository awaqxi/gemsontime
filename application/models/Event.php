<?php
    
class Model_Event
{
	public static function getUserEvents($userID, $bDate, $eDate)
	{
		$events_table = new Model_DbTable_Event();		
        $result = $events_table->getUserEvents($userID, $bDate, $eDate);
       
        $events = array();
		$eventsIDs = array();
        foreach ($result as $object) {
            $event = new Model_Entity_Event();
            $event->setID($object['id']);
            $event->setName($object['name']);
            $event->setIsMine($object['is_mine']);
            $event->setDate($object['date']);
            
            $events[$object['id']] = $event;			
			//зпоминаем ид всех событий
			$eventsIDs[] = $object['id'];
        }
        $event_groups_types = Model_Event::getEventGroupTypeRelation($eventsIDs);
		foreach ($event_groups_types as $object) 
		{
			$eventID = $object['event_id'];
			$events[$eventID]->addGroupType(array("groupName" => $object['group_name'],
			                                      "groupCSS" => $object['group_css'],
			                                      "typeName" => $object['type_name'],
			                                      "isMain" => $object['is_main']));
		}
		
        return $events;
	}
	
	private static function getEventGroupTypeRelation($eventsIDs)
	{
		$events_group_type_relation_table = new Model_DbTable_EventGroupTypeRelation();
		//преобразуем массив ид в строку
		$eventsIDsStr = implode(",", $eventsIDs);
		
		$result = $events_group_type_relation_table->getEventsGroupTypes($eventsIDsStr);
		
		return $result;
	}
}