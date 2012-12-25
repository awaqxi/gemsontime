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
}