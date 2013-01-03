<?php
    
class Model_DbTable_EventGroup extends Zend_Db_Table_Abstract
{
	protected $_name = 'event_group';
	
	public function getGroups()
	{
		$dbAdapter = $this->getAdapter();
		
		$result = $dbAdapter->fetchAll("
			select *
			from event_group
			order by name
		");
		
		return $result;		
	}
}