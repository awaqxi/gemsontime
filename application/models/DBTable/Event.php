<?php
    
class Model_DbTable_Event extends Zend_Db_Table_Abstract
{
	protected $_name = 'event';
	
	public function getUserEvents($userID, $bDate, $eDate)
    {
        $dbAdapter = $this->getAdapter();
        $result = $dbAdapter->fetchAll("
			select distinct
				e_a.event_id as id, e_a.relation, e.name, e.startdate as date
				,case when relation in ('participant','saved') then 1 else 0 end as is_mine
				,v.id as venueid, v.venue
			from (
			select distinct e.id as event_id, 'participant' as relation, 1 as iorder
			from event e
			     join event_participant p
				       on p.event_id = e.id
			where p.user_id = :userID
			      and e.startdate >= :bDate
			      and e.startdate <= :eDate
			
			union all
			select distinct e.id as event_id, 'saved' as relation, 2 as iorder
			from event e
			     join event_saved s
				       on s.event_id = e.id
			where s.user_id = :userID
			      and e.startdate >= :bDate
			      and e.startdate <= :eDate
			
			union all
			select distinct e.id as event_id, 'friend_participant' as relation, 3 as iorder
			from event e
			     join event_participant p
				       on p.event_id = e.id
			     join friend f
				       on p.user_id = f.friend_user_id
			where f.user_id = :userID
			      and e.startdate >= :bDate
			      and e.startdate <= :eDate
			
			union all
			select distinct e.id as event_id, 'friend_saved' as relation, 4 as iorder
			from event e
			     join event_saved s
				       on s.event_id = e.id
			     join friend f
				       on s.user_id = f.friend_user_id
			where f.user_id = :userID
			      and e.startdate >= :bDate
			      and e.startdate <= :eDate
			) e_a
			inner join event e on e.id = e_a.event_id
			left join venue v on v.id = e.venueid
			order by event_id, iorder desc
        ", array("userID"=>$userID, "bDate"=>$bDate, "eDate"=>$eDate));   
        
        return $result;
    }

}