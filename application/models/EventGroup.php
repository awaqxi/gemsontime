<?php
    
class Model_EventGroup
{
	public static function getGroups()
	{
		$table = new Model_DbTable_EventGroup();
		$result = $table->getGroups();
		
		$eventGroups = array();
		foreach ($result as $object) {
			$eventGroup = new Model_Entity_EventGroup();
			$eventGroup->setID($object['id']);
			$eventGroup->setName($object['name']);
			$eventGroup->setCSS($object['css']);
			
			$eventGroups[$object['id']] = $eventGroup;
		}
		
		return $eventGroups;
	}
}