<?php
namespace Auth\Form;

use Zend\Form\Form,
    Zend\Form\Element,
    Zend\InputFilter\Factory as InputFactory,
	Zend\InputFilter\InputFilter;

class Login extends Form
{
    public function __construct()
    {
        parent::__construct('login');
        $this->setName('login');
        $this->setAttribute('method', 'post');
        
       	$mail = new Element\Email('mail');
       	$mail->setAttribute('size', '40')
               ->setAttribute('required', 'true')
               ->setAttribute('placeholder', 'adresse mail')
               ->setAttribute('class', 'form-control');
       	$this->add($mail);
       	         
        $password = new Element\Password('password');
        $password->setAttribute('size', '32')
                 ->setAttribute('required', 'true')
                 ->setAttribute('placeholder', 'password')
                 ->setAttribute('class', 'form-control');
       	$this->add($password);
		
       	$csrf = new Element\Csrf('csrf');
       	$this->add($csrf);
       	
       	$submit = new Element\Submit('submit');
       	$submit->setValue('Connexion')
               ->setAttribute('class', 'btn btn-lg btn-success btn-block');
       	$this->add($submit);

        /*permet d'imposer des contraites aux informations saisies*/
        $inputFilter = new InputFilter();
        $factory = new InputFactory();
        
       	$inputFilter->add($factory->createInput(array(
                    'name' => 'mail',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name' => 'StringLength',
                            'options' => array(
                                'min' => 8
                            )
                        )
                    )
        )));
        
        $inputFilter->add($factory->createInput(array(
                    'name' => 'password',
                    'required' => true,
                    'validators' => array(
                        array(
                            'name' => 'StringLength',
                            'options' => array(
                                'min' => 3
                            )
                        )
                    )
        )));
        
        $inputFilter->add($factory->createInput(array(
                    'name' => 'csrf',
                    'required' => true,
                    'validators' => array(
                        array(
                            'name' => 'Csrf',
                            'options' => array(
                                'timeout' => 600
                            )
                        )
                    )
        )));
        $this->setInputFilter($inputFilter);
    }
}