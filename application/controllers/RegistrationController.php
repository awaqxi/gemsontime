<?php

class RegistrationController extends Zend_Controller_Action
{
	private $form;
    public function init()
    {
    	$this->form = new Application_Form_Registration();
    }

    public function indexAction()
    {	
        
		if ($this->getRequest()->isPost()){
			$this->validateForm();
		}			
		else {
			$this->view->form = $this->form;
		}			
    }
	
	private function validateForm()
	{
		$formData = $this->getRequest()->getPost();
		if($this->form->isValid($formData)){
			$this->createUser();			
		}
		else {
			$this->view->form = $this->form;
		}
	}
	
	private function createUser()
	{
		$data = $this->form->getValues();
		$user = new Model_Entity_User();
		$user->setName($data['name']);
		$user->setEmail($data['email']);
		$user->setPassword(md5($data['name'] . $data['password']));
		$user->setcheckSum(md5($data['name'] . time()));
		//получаем объект user - уже с ИД в базе
		$user = Model_User::createUser($user);
		
		$this->_forward('thankyou','registration', null, array('user'=>$user));
	}
	
	public function thankyouAction()
	{
		$user=$this->getRequest()->getParam('user');	
		if(empty($user))
			$this->_helper->redirector->gotoSimple('index', 'index');
		
		$mail = new Zend_Mail('UTF-8');
		$mail->addTo($user->getEmail());
		$mail->setSubject('Подтверждение регистрации');
		$mail->setBodyHtml($this->getMailBody($user));
		$mail->send();
	}
	
	private function getMailBody($user)
	{
		 $emailConfirmTemplate = new Zend_View(array('basePath'=>APPLICATION_PATH.'/views'));
		 $emailConfirmTemplate->userName = $user->getName();
		 $emailConfirmTemplate->userID = $user->getID();
		 $emailConfirmTemplate->checkSum = $user->getCheckSum();
		 $body = $emailConfirmTemplate->render("/templates/mail/registration_confirm.phtml");
		 
		 return $body;
	}
	
	public function confirmAction()
	{
		$checkSum = $this->getRequest()->getParam('checkSum');
		$userID = $this->getRequest()->getParam('userID');
		
		if(Model_User::isCheckSumExists($userID, $checkSum))
		{
			Model_User::setUserConfirmed($userID);
		}
		else
		{
			//TODO попробовать $this->_redirect($url);
			$this->_helper->redirector->gotoSimple('index', 'index');	
		}				
	}
}