<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
    	
    }

    public function indexAction()
    {
    	$this->view->headScript()->appendFile($this->view->serverUrl() . '/assets/js/script.js', 'text/javascript')
				                 ->appendFile($this->view->serverUrl() . '/assets/js/event.js', 'text/javascript');
    }
	
	public function testAction()
    {	
        $this->view->headScript()->appendFile($this->view->serverUrl() . '/assets/js/event.js', 'text/javascript');
    }
}