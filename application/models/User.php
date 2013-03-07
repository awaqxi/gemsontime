<?php
    
class Model_User
{
	public static function createUser(Model_Entity_User $user)
	{
		$table = new Model_DbTable_User();
		
		$data = array('name' => $user->getName(),
					  'email' => $user->getEmail(),
					  'password' => $user->getPassword(),
					  'check_sum' => $user->getCheckSum());
					  
		$id = $table->insert($data);		
		$user->setID($id);
		
		return $user;
	}
	
	public static function isCheckSumExists($userID, $checkSum)
	{
		$table = new Model_DbTable_User();
		$select = $table->select()
		                ->where('check_sum = ?', $checkSum)
						->where('id = ?', $userID)
						->where('is_confirmed = 0');
		$result = $table->fetchAll($select);
		
		if(count($result) > 0)
			return true;
		else {
			return false;
		}
	}
	
	public static function setUserConfirmed($userID)
	{
		$table = new Model_DbTable_User();
		$data = array('is_confirmed' => 1);
		
		$where = $table->getAdapter()->quoteInto('id = ?', $userID);
		
		$table->update($data, $where);
	}
	
	public static function isUserExists($userID)
	{
		$table = new Model_DbTable_User();
		$select = $table->select()
		                ->where('id = ?', $userID);
		$result = $table->fetchAll($select);
		
		if(count($result) > 0)
			return true;
		else {
			return false;
		}
	}
}