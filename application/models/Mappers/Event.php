<?php
    
class Model_Mapper_Event
{
	public static function getUserEvents($userID, $bDate, $eDate)
	{
		$events_table = new Model_DbTable_Event();		
        $result = $events_table->getUserEvents($userID, $bDate, $eDate);

        $events = array();
		$eventsIDs = array();
		// т.к. у юзера может быть несклько отношений с событием (сохранил, пойдет и т.д.), то события дублируются в этой выборке
		// но перетираются в правильном порядке за счет iorder desc
        foreach ($result as $object) {            
			$event = Model_Event::getEntity($object);			
            $events[$object['id']] = $event;			
			//зпоминаем ид всех событий
			$eventsIDs[] = $object['id'];
        }
		if(count($eventsIDs) > 0)
		{
			//выбираем группы и типы событий
	        $event_groups_types = Model_Event::getEventGroupTypeRelation($eventsIDs);
			foreach ($event_groups_types as $object) 
			{
				$eventID = $object['event_id'];
				$events[$eventID]->addGroupType(array("groupName" => $object['group_name'],
				                                      "groupCSS" => $object['group_css'],
				                                      "typeName" => $object['type_name'],
				                                      "isMain" => $object['is_main']));
			}
		}
        return $events;
	}
	
	public static function getUserIdeas($userID, $pDate)
	{
		$events_table = new Model_DbTable_Event();		
        $result = $events_table->getUserIdeas($userID, $pDate);
       
        $events = array();
		$eventsIDs = array();
		// т.к. у юзера может быть несклько отношений с событием (сохранил, пойдет и т.д.), то события дублируются в этой выборке
		// но перетираются в правильном порядке за счет iorder desc
        foreach ($result as $object) {            
			$event = Model_Mapper_Event::getEntity($object);
            $events[$object['id']] = $event;			
			//зпоминаем ид всех событий
			$eventsIDs[] = $object['id'];
        }
		if(count($eventsIDs) > 0)
		{
			//выбираем группы и типы событий
	        $event_groups_types = Model_Mapper_Event::getEventGroupTypeRelation($eventsIDs);
			foreach ($event_groups_types as $object) 
			{
				$eventID = $object['event_id'];
				$events[$eventID]->addGroupType(array("groupName" => $object['group_name'],
				                                      "groupCSS" => $object['group_css'],
				                                      "typeName" => $object['type_name'],
				                                      "isMain" => $object['is_main']));
			}
		}
        return $events;
	}

	private static function getEntity($object)
	{
		$event = new Model_Entity_Event();
        $event->setID($object['id']);
        $event->setName($object['name']);
        $event->setIsMine($object['is_mine']);
        $event->setStartDate($object['startdate']);
		$event->setEndDate($object['enddate']);
		$event->setVenueID($object['venueid']);
		$event->setVenueName($object['venue']);
		$event->setUserRel($object['relation']);
		$event->setTimeType($object['timeType']);
		
		return $event;
	}
	
	private static function getEventGroupTypeRelation($eventsIDs)
	{
		$events_group_type_relation_table = new Model_DbTable_EventGroupTypeRelation();
		//преобразуем массив ид в строку
		$eventsIDsStr = implode(",", $eventsIDs);
		
		$result = $events_group_type_relation_table->getEventsGroupTypes($eventsIDsStr);
		
		return $result;
	}

	public static function isEventExists($eventID)
	{
		$table = new Model_DbTable_Event();
		$select = $table->select()
		                ->where('id = ?', $eventID);
		$result = $table->fetchAll($select);
		
		if(count($result) > 0)
			return true;
		else {
			return false;
		}
	}
	
	public static function importEvents()
	{
		$events_table = new Model_DbTable_Event();
		
		// проверить и создать ТИПЫ
		// проверить и создать МЕСТА
		// очистить события
		// создать события
		$types = $events_table->getBuf_newTypes();
		foreach ($result as $object) {            
			$event = Model_Event::getEntity($object);			
            $events[$object['id']] = $event;			
			//зпоминаем ид всех событий
			$eventsIDs[] = $object['id'];
        }
		
        $result = $events_table->importEvents();
       
        $events = array();
		$eventsIDs = array();
        foreach ($result as $object) {
			$event = Model_Event::getEntity($object);			
            $events[$object['id']] = $event;			
			//зпоминаем ид всех событий
			$eventsIDs[] = $object['id'];
        }
		if(count($eventsIDs) > 0)
		{
			//выбираем группы и типы событий
	        $event_groups_types = Model_Event::getEventGroupTypeRelation($eventsIDs);
			foreach ($event_groups_types as $object) 
			{
				$eventID = $object['event_id'];
				$events[$eventID]->addGroupType(array("groupName" => $object['group_name'],
				                                      "groupCSS" => $object['group_css'],
				                                      "typeName" => $object['type_name'],
				                                      "isMain" => $object['is_main']));
			}
		}
        return $events;
	}
}