<?php
    
class Model_DbTable_EventGroupTypeRelation extends Zend_Db_Table_Abstract
{
	protected $_name = 'event_group_type_relation';
	
	public function getEventsGroupTypes($eventsIDs)
	{
		$dbAdapter = $this->getAdapter();
		
        $result = $dbAdapter->fetchAll("
            select gtr.id,
                   gtr.event_id,
                   g.name as group_name,
                   g.css as group_css,
                   t.name as type_name,
                   gtr.is_main
            from event_group_type_relation gtr
                 left join event_type t
                      on gtr.event_type_id = t.id
                join event_group g
                      on t.event_group_id = g.id
            where gtr.event_id in (" . $eventsIDs . ")");  

        return $result;
	}	
}