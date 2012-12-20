<?php

	class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
	{
		protected function _initAutoload()
		{
			$modelLoader = new Zend_Application_Module_Autoloader(array(
                               'namespace' => '',
							   'basePath' => APPLICATION_PATH));
			return $modelLoader;				   
			
		}
		
		public function _initRoute()
		{		
	        $router = Zend_Controller_Front::getInstance()->getRouter();

			$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini', 'production');
			$router->addConfig($config,'routes');	
		}
		
		protected function _initViewHelpers()
		{
			
			$this->bootstrap('layout');
			$layout = $this->getResource('layout');
			$view = $layout->getView();
			
			$view->doctype('HTML5');
			$view->headMeta()->setCharset( 'UTF-8' );
			$view->headLink()->appendStylesheet($view->serverUrl().'/assets/css/style.css')
			                 ->appendStylesheet($view->serverUrl().'/assets/css/bootstrap.min.css')
							 ->headLink(array('rel' => 'icon', 'href' => 'assets/ico/favicon.ico'), 'PREPEND');
							 
			$view->headScript()->appendFile('http://code.jquery.com/jquery-latest.js', 'text/javascript')
			                   ->appendFile($view->serverUrl() . '/assets/js/bootstrap.min.js', 'text/javascript')
							   ->appendFile($view->serverUrl() . '/assets/js/jquery.overscroll.min.js', 'text/javascript')
							   ->appendFile($view->serverUrl() . '/assets/js/script.js', 'text/javascript');
				 
							 
		}
		
		protected function _initMail()
		{
		    $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/mail.ini', 'production');
			
			$mailConfig = array(
		            'auth' => 'login',
		            'username' => $config->email->username,
		            'password' => $config->email->password,
		            'ssl' => $config->email->ssl,
		            'port' => $config->email->port
	        );
			
	        $mailTransport = new Zend_Mail_Transport_Smtp($config->email->server, $mailConfig);
	        Zend_Mail::setDefaultTransport($mailTransport);
		}
}    