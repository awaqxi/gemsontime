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
                $authAdapter = $this->getAuthAdapter(); 
                
                $user = $data['name'];
                $pass = $data['password'];
                $authAdapter->setIdentity($user)
                            ->setCredential($pass);
                
                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                if($result->isValid())
                {   
                    $identity = $authAdapter->getResultRowObject();
                    $authStorage = $auth->getStorage();
                    $authStorage->write($identity);
                    
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
    
    private function getAuthAdapter()
    {
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('user')
                    ->setIdentityColumn('name')
                    ->setCredentialColumn('password')
                    ->setCredentialTreatment('MD5(CONCAT(name,?))');
                    
        return $authAdapter;
    }
}