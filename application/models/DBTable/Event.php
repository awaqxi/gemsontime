<?php
    
class Model_DbTable_Event extends Zend_Db_Table_Abstract
{
	protected $_name = 'event';
	
	public function getUserEvents($userID, $bDate, $eDate)
    {
        $dbAdapter = $this->getAdapter();
        $result = $dbAdapter->fetchAll("
            select id, user_id, name, date
            from event
            where user_id = :userID
                  and date >= :bDate
                  and date <= :eDate
            union all
            select e.id, e.user_id, name, date
			from event e
			     join friend f
			          on e.user_id = f.friend_user_id
			where f.user_id = :userID
			      and date >= :bDate
                  and date <= :eDate
            order by user_id, date     
        ", array("userID"=>$userID, "bDate"=>$bDate, "eDate"=>$eDate));   
        
        return $result;
    }	
}