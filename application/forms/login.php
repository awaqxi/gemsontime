<?php

class Application_Form_Login extends Zend_Form
{
	public function init()
	{
		$this->setAttrib('class', 'form-horizontal')
		     ->setMethod('post')
			 ->setFields();
	}
	
	private function setFields()
	{			 
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Логин')
			 ->setRequired(TRUE)
			 ->addValidator('NotEmpty', true, array('messages' => 'Поле логин обязательно для заполнения'));
		$this->setBootstrapDecorators($name);													 															 
		$this->addElement($name);
			 
		$password = new Zend_Form_Element_Password('password');
		$password->setLabel('Пароль')
			     ->setRequired(TRUE)
			     ->addValidator('NotEmpty', true, array('messages' => 'Поле пароль должно быть заполнено'));
		$this->setBootstrapDecorators($password);
		$this->addElement($password);
		
		$buttonSave = new Zend_Form_Element_Submit('save');	 
		$buttonSave ->setDecorators(array(
			                        array('ViewHelper'),
			                        array('HtmlTag', array('tag' => 'div', 'class' => 'submit_group'))))
	                    ->setLabel('Вход')
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
