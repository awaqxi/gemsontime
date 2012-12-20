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
		$events = Model_Event::getUserEvents($this->getRequest()->getParam("userID"), 
		                                     $this->getRequest()->getParam("bDate"), 
		                                     $this->getRequest()->getParam("eDate"));
        
        $objects = array();
        foreach ($events as $event) {
            $objects[] = $event->getArray();
        }        

        $this->_helper->viewRenderer->setNoRender(true);
        $response = $this->getResponse();
        $response->setHeader('Content-type', 'application/json;charset=UTF-8', true);
               
        return $response->setBody(Zend_Json::encode($objects));
	}
}