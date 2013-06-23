<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
    	
    }

    public function indexAction()
    {
        
    }
    
    public function loginAction()
    {
        if(Zend_Auth::getInstance()->hasIdentity())
        {
            $this->redirect('');   
        }
       
        $form = new Application_Form_Login();

        if ($this->getRequest()->isPost()){            
            $formData = $this->getRequest()->getPost();
            
            if($form->isValid($formData)){
                $data = $form->getValues();
                $user = $data['name'];
                $pass = $data['password'];

                $result = Model_Auth::getInstance()->login($user, $pass);

                if($result){
                    $this->redirect('');   
                }
                else {
                    $this->view->invalid = true; 
                    $this->view->form = $form;
                }
            }
            else {
                $this->view->form = $form;
            }
        }           
        else {
            $this->view->form = $form;
        }              
    }
    
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->redirect('auth/login');
    }
}