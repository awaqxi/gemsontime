<?php

class Application_Form_Registration extends Zend_Form
{
	public function init()
	{
		$this->setAttrib('class', 'form-horizontal')
		     ->setMethod('post')
			 ->setFields();
		//TODO добавить action	Zend_Controller_Front::getInstance()->getBaseUrl()
	}
	
	private function setFields()
	{
		$email = new Zend_Form_Element_Text('email');
		$email->setLabel('E-mail')
			  ->setRequired(TRUE)
			  ->addValidator('NotEmpty', true, array('messages' => 'Поле E-mail должно быть заполнено'))
			  ->addValidator('EmailAddress', true, array('messages' => 'Поле E-mail имеет неправильный формат'));
		$this->setBootstrapDecorators($email);
	    $this->addElement($email);
					 
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Логин')
			 ->setRequired(TRUE)
			 ->addValidator('NotEmpty', true, array('messages' => 'Поле логин должно быть заполнено'))
			 ->addValidator('Db_NoRecordExists', true, array('messages' => 'Данный логин уже занят',
			                                                 'table' => 'user',
															 'field' => 'name'));
		$this->setBootstrapDecorators($name);													 															 
		$this->addElement($name);
			 
		$password = new Zend_Form_Element_Password('password');
		$password->setLabel('Пароль')
			     ->setRequired(TRUE)
			     ->addValidator('NotEmpty', true, array('messages' => 'Поле пароль должно быть заполнено'));
		$this->setBootstrapDecorators($password);
		$this->addElement($password);
		
		$confirmPassword = new Zend_Form_Element_Password('confirmPassword');	 
		$confirmPassword->setLabel('Подтверждение')
			            ->setRequired(TRUE)
			            ->addValidator('NotEmpty', true, array('messages' => 'Поле подтверждение пароля должно быть заполнено'))
			            ->addValidator('Identical', true, array('token' => 'password',
			                                                     'messages' => 'Поля "пароль" и "подтверждение пароля" не совпадают'));
		$this->setBootstrapDecorators($confirmPassword);
		$this->addElement($confirmPassword);
		
		$buttonSave = new Zend_Form_Element_Submit('save');	 
		$buttonSave ->setDecorators(array(
			                        array('ViewHelper'),
			                        array('HtmlTag', array('tag' => 'div', 'class' => 'submit_group'))))
	                    ->setLabel('Регистрация')
					    ->setAttribs(array('class' => 'btn btn-primary'));
						
		$this->addElement($buttonSave);
		return $this;
	}

	private function setBootstrapDecorators($field)
	{
		$field->setDecorators(array(
				'ViewHelper',
				array(array('wrapper_element' => 'HtmlTag'), array('tag' => 'div', 'class'  => 'controls')),
				array('Label', array('class'  => 'control-label', 'for'  => $field->getName())),
				array(array('wrapper' => 'HtmlTag'), array('tag' => 'div', 'class'  => 'control-group'))
				));	
	}
}
