<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
    	
    }

    public function indexAction()
    {
        $this->forward('events');

    }
	
	public function testAction()
    {	
        $this->view->headScript()->appendFile($this->view->serverUrl() . '/assets/js/event.js', 'text/javascript');
		$this->view->headLink()->appendStylesheet($this->view->serverUrl().'/assets/css/events.css');
		
		$this->view->eventGroups = Model_Mapper_EventGroup::getGroups();
    }

    public function eventsAction()
    {
        $user = Model_Auth::getInstance()->getUser();

        if(false === is_null($user)){
            $utilDate = new Model_Util_Date();
            $bDate = $this->getRequest()->getParam("bDate");
            $eDate = $this->getRequest()->getParam("eDate");

            $bDate = $utilDate->checkDate($bDate) ? $bDate : $utilDate->getFirstMonthDate();
            $eDate = $utilDate->checkDate($eDate) ? $eDate : $utilDate->getLastMonthDate();
            $events = Model_Mapper_Event::getUserEvents($user->getId(), $bDate, $eDate);

            $this->view->bDate = $bDate;
            $this->view->eDate = $eDate;
            $this->view->events = $events;
        }
        else{
            $this->renderScript('auth/NotAuthorised.php');
        }
    }

//    public function indexAction()
//    {
//        $this->view->headScript()->appendFile($this->view->serverUrl() . '/assets/js/DateFuncs.js', 'text/javascript')
//            ->appendFile($this->view->serverUrl() . '/assets/js/script.js', 'text/javascript')
//            ->appendFile($this->view->serverUrl() . '/assets/js/event.js', 'text/javascript');
//
//        $this->view->headLink()->appendStylesheet($this->view->serverUrl().'/assets/css/events.css');
//
//        $this->view->eventGroups = Model_EventGroup::getGroups();
//
//
//        $userInfo = Zend_Auth::getInstance()->getStorage()->read();
//
//        $this->view->isAuthorised = Zend_Auth::getInstance()->hasIdentity();
//    }
}