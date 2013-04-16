<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
    	
    }

    public function indexAction()
    {
        $this->view->headScript()->appendFile($this->view->serverUrl() . '/assets/js/gemsontime/timeline/timeline.js', 'text/javascript')
                                 ->appendFile($this->view->serverUrl() . '/assets/js/gemsontime/timeline/event.js', 'text/javascript')
                                 ->appendFile($this->view->serverUrl() . '/assets/js/gemsontime/view/index.js', 'text/javascript');
        $this->view->headLink()->appendStylesheet($this->view->serverUrl().'/assets/css/events.css');
    }
	
	public function testAction()
    {	
        $this->view->headScript()->appendFile($this->view->serverUrl() . '/assets/js/event.js', 'text/javascript');
		$this->view->headLink()->appendStylesheet($this->view->serverUrl().'/assets/css/events.css');
		
		$this->view->eventGroups = Model_EventGroup::getGroups();
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