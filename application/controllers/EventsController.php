<?php

class EventsController extends Zend_Controller_Action
{

    public function init()
    {
       
    }

    public function indexAction()
    {
        
    }
	
	public function listAction()
	{
		//TODO сделать получение userID из сессии, а не из параметра запроса
		$events = Model_Event::getUserEvents($this->getRequest()->getParam("userID"), 
		                                     $this->getRequest()->getParam("bDate"), 
		                                     $this->getRequest()->getParam("eDate"));
        
        $objects = array();
        foreach ($events as $event) {
            $objects[] = $event->getArray();
        }        

        $this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout(); 
        $response = $this->getResponse();
        //$response->setHeader('Content-type', 'application/json;charset=UTF-8', true);
               
        return $response->setBody(Zend_Json::encode($objects));
	}
	
	public function subscribeAction()
	{
		$userID = $this->getRequest()->getParam("userID");
		$eventID = $this->getRequest()->getParam("eventID");
		
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout(); 
        $response = $this->getResponse();
		
		$isUserExists = Model_User::isUserExists($userID);
		if(!$isUserExists)
		{
			$data = array('result' => 'user not exists');
			return $response->setBody(Zend_Json::encode($data));
		}
		
		$isEventExists = Model_Event::isEventExists($eventID);
		if(!$isEventExists)
		{
			$data = array('result' => 'event not exists');
			return $response->setBody(Zend_Json::encode($data));
		}
		
		$isUserEventParticipant = Model_EventParticipant::isUserEventParticipant($userID, $eventID);
		if($isUserEventParticipant)
		{
			$data = array('result' => 'user is already subscribed');
			return $response->setBody(Zend_Json::encode($data));
		}
		else
		{
			Model_EventParticipant::subscribe($userID, $eventID);
			$data = array('result' => 'OK');			
			return $response->setBody(Zend_Json::encode($data));
		}		
		
		
		
		
	}
}