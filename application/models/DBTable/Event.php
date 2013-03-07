<?php
    
class Model_DbTable_Event extends Zend_Db_Table_Abstract
{
	protected $_name = 'event';
	
	public function getUserEvents($userID, $bDate, $eDate)
    {
        $dbAdapter = $this->getAdapter();
        $result = $dbAdapter->fetchAll("
            select e.id, 1 as is_mine, e.name, e.date
			from event e
			     join event_participant p
			          on p.event_id = e.id
			where p.user_id = :userID
			      and e.date >= :bDate
			      and e.date <= :eDate
			union all
			select distinct
			 e.id, 0 as is_mine, e.name, e.date
			from event e
			     join event_participant p
				       on p.event_id = e.id
			     join friend f
				       on p.user_id = f.friend_user_id
			where f.user_id =  :userID
			      and not exists (select id
			                      from event_participant pp
			                      where pp.event_id = e.id
			                            and pp.user_id = f.user_id)
			      and e.date >= :bDate
			      and e.date <= :eDate
            order by date     
        ", array("userID"=>$userID, "bDate"=>$bDate, "eDate"=>$eDate));   
        
        return $result;
    }	
	
	
}