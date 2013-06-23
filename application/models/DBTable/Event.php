<?php
    
class Model_DbTable_Event extends Zend_Db_Table_Abstract
{
	protected $_name = 'event';
	
	public function getUserEvents($userID, $bDate, $eDate)
    {
        $dbAdapter = $this->getAdapter();
        $result = $dbAdapter->fetchAll("
        	select * from (
        	
				select distinct
					e_a.event_id as id
					,e_a.relation
					,e.name
					,e.startdate
					,e.enddate
					,case when relation in ('participant','saved') then 1 else 0 end as is_mine
					,v.id as venueid
					,v.venue
					,'Point' as timeType
					,iorder
				from (
				select distinct e.id as event_id, 'participant' as relation, 1 as iorder
				from event e
				     join event_participant p
					       on p.event_id = e.id
				where p.user_id = :userID
				      and e.startdate >= :bDate
				      and e.enddate <= :eDate
				
				union all
				select distinct e.id as event_id, 'saved' as relation, 2 as iorder
				from event e
				     join event_saved s
					       on s.event_id = e.id
				where s.user_id = :userID
				      and e.startdate >= :bDate
				      and e.enddate <= :eDate
				
				union all
				select distinct e.id as event_id, 'friend_participant' as relation, 3 as iorder
				from event e
				     join event_participant p
					       on p.event_id = e.id
				     join friend f
					       on p.user_id = f.friend_user_id
				where f.user_id = :userID
				      and e.startdate >= :bDate
				      and e.enddate <= :eDate
				
				union all
				select distinct e.id as event_id, 'friend_saved' as relation, 4 as iorder
				from event e
				     join event_saved s
					       on s.event_id = e.id
				     join friend f
					       on s.user_id = f.friend_user_id
				where f.user_id = :userID
				      and e.startdate >= :bDate
				      and e.enddate <= :eDate
			) e_a
			inner join event e on e.id = e_a.event_id
			left join venue v on v.id = e.venueid
			
			
			union all
			
			
			select
				e_l.event_id as id, e_l.relation
				,e2.name
				,e2.startdate
				,e2.enddate
				,case when relation in ('participant','saved') then 1 else 0 end as is_mine
				,v.id as venueid
				,v.venue
				,'Long' as timeType
				,iorder
			from (
				select distinct e.id as event_id, 'participant' as relation, 1 as iorder
				from event e
				     join event_participant p
					       on p.event_id = e.id
				where p.user_id =  1
				      and e.startdate < :bDate
				      and e.enddate > :eDate
				
				union all
				select distinct e.id as event_id, 'saved' as relation, 2 as iorder
				from event e
				     join event_saved s
					       on s.event_id = e.id
				where s.user_id =  1
				      and e.startdate < :bDate
				      and e.enddate <= :eDate
				
				union all
				select distinct e.id as event_id, 'friend_participant' as relation, 3 as iorder
				from event e
				     join event_participant p
					       on p.event_id = e.id
				     join friend f
					       on p.user_id = f.friend_user_id
				where f.user_id =  1
				      and e.startdate < :bDate
				      and e.enddate <= :eDate
				
				union all
				select distinct e.id as event_id, 'friend_saved' as relation, 4 as iorder
				from event e
				     join event_saved s
					       on s.event_id = e.id
				     join friend f
					       on s.user_id = f.friend_user_id
				where f.user_id =  1
				      and e.startdate < :bDate
				      and e.enddate <= :eDate
			) e_l
			inner join event e2 on e2.id = e_l.event_id
			left join venue v on v.id = e2.venueid
			
			) e_all
			
		order by id, iorder desc
			
        ", array("userID"=>$userID, "bDate"=>$bDate, "eDate"=>$eDate));   

        return $result;
    }

    
    public function getUserIdeas($userID, $pDate)
    {
        $dbAdapter = $this->getAdapter();
        $result = $dbAdapter->fetchAll("
        	select * from (
        	
				select distinct
					e_a.event_id as id
					,e_a.relation
					,e.name
					,e.startdate
					,e.enddate
					,case when relation in ('participant','saved') then 1 else 0 end as is_mine
					,v.id as venueid
					,v.venue
					,'Idea' as timeType
					,iorder
				from (
				select distinct e.id as event_id, 'participant' as relation, 1 as iorder
				from event e
				     join event_participant p
					       on p.event_id = e.id
				where p.user_id = :userID
				      and e.startdate <= :pDate
				      and e.enddate > :pDate
				
				union all
				select distinct e.id as event_id, 'saved' as relation, 2 as iorder
				from event e
				     join event_saved s
					       on s.event_id = e.id
				where s.user_id = :userID
				      and e.startdate <= :pDate
				      and e.enddate > :pDate
				
				union all
				select distinct e.id as event_id, 'friend_participant' as relation, 3 as iorder
				from event e
				     join event_participant p
					       on p.event_id = e.id
				     join friend f
					       on p.user_id = f.friend_user_id
				where f.user_id = :userID
				      and e.startdate <= :pDate
				      and e.enddate > :pDate
				
				union all
				select distinct e.id as event_id, 'friend_saved' as relation, 4 as iorder
				from event e
				     join event_saved s
					       on s.event_id = e.id
				     join friend f
					       on s.user_id = f.friend_user_id
				where f.user_id = :userID
				      and e.startdate <= :pDate
				      and e.enddate > :pDate
			) e_a
			inner join event e on e.id = e_a.event_id
			left join venue v on v.id = e.venueid
			
			) e_all
			
		order by id, iorder desc
			
        ", array("userID"=>$userID, "pDate"=>$pDate));   
        
        return $result;
    }
    
    public function getEventsForImport()
    {
        $dbAdapter = $this->getAdapter();
        $result = $dbAdapter->fetchAll("
	        select
			b_e.`Name`, b_e.`Descr`, b_e.`Startdate`, b_e.`Enddate`, b_e.`Venue`, b_e.`Url`, b_e.`Type0`, b_e.`Type1`
			,v.ID venueid, et0.id type0id, et1.id type1id
			from bufEvent b_e
			left join venue v on b_e.venue=v.venue
			left join event_type et0 on et0.name=b_e.Type0
			left join event_type et1 on et1.name=b_e.Type1	
 		");   
        
        return $result;
    }
}