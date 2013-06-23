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
        $objects = array();
        $Auth = Model_Auth::getInstance();

        if(false === is_null($Auth->getUser())){

            $events = Model_Mapper_Event::getUserEvents($Auth->getUser()->getId(),
                                                        $this->getRequest()->getParam("bDate"),
                                                        $this->getRequest()->getParam("eDate"));

            foreach ($events as $event) {
                $objects[] = $event->getArray();
            }
        }

        $this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
        $response = $this->getResponse();
        //$response->setHeader('Content-type', 'application/json;charset=UTF-8', true);

        return $response->setBody(Zend_Json::encode($objects));
	}
	
	public function getideasAction()
	{
        $Auth = Model_Auth::getInstance();

		$events = Model_Mapper_Event::getUserIdeas($Auth->getUser()->getId(),
		                                           $this->getRequest()->getParam("pDate"));
        
        $objects = array();
        foreach ($events as $event) {
            $objects[] = $event->getArray();
        }        

        $this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout(); 
        $response = $this->getResponse();
               
        return $response->setBody(Zend_Json::encode($objects));
	}
	
	public function importAction()
	{
		$events = Model_Event::importEvents();        

        $this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout(); 
        $response = $this->getResponse();
               
        return $response->setBody("[]");
	}

	public function subscribeAction()
	{
		$userID = Model_Auth::getInstance()->getUser()->getId();
		$eventID = $this->getRequest()->getParam("eventID");

		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
        $response = $this->getResponse();

		$isUserExists = Model_Mapper_User::isUserExists($userID);
		if(!$isUserExists)
		{
			$data = array('result' => 'user not exists');
			return $response->setBody(Zend_Json::encode($data));
		}

		$isEventExists = Model_Mapper_Event::isEventExists($eventID);
		if(!$isEventExists)
		{
			$data = array('result' => 'event not exists');
			return $response->setBody(Zend_Json::encode($data));
		}

		$isUserEventParticipant = Model_Mapper_EventParticipant::isUserEventParticipant($userID, $eventID);
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