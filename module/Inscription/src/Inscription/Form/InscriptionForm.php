<?php
namespace Inscription\Form;

use Zend\Form\Form,
    Zend\Form\Element,
    Zend\InputFilter\Factory as InputFactory,
    Zend\InputFilter\InputFilter;

class InscriptionForm extends Form {

    public function __construct() {

        parent::__construct('inscription');
        $this->setName('inscription');
        $this->setAttribute('method', 'post');
        
        $prenom = new Element\Text('prenom');
       	$prenom->setAttribute('size', '32')
               ->setAttribute('required', 'true')
               ->setAttribute('placeholder', 'Prenom')
               ->setAttribute('class', 'form-control');
       	$this->add($prenom);
        
        $password = new Element\Password('password');
        $password->setAttribute('size', '32')
                 ->setAttribute('required', 'true')
                 ->setAttribute('id', 'first')
                 ->setAttribute('placeholder', 'Password')
                 ->setAttribute('class', 'form-control');
       	$this->add($password);
        
        $password2 = new Element\Password('password2');
        $password2->setAttribute('size', '32')
                 ->setAttribute('required', 'true')
                 ->setAttribute('id', 'second')
                 ->setAttribute('placeholder', 'Repeat password')
                 ->setAttribute('class', 'form-control');
       	$this->add($password2);
        
        $nom = new Element\Text('nom');
       	$nom->setAttribute('size', '32')
               ->setAttribute('required', 'true')
               ->setAttribute('placeholder', 'Nom')
               ->setAttribute('class', 'form-control');
       	$this->add($nom);
        
        $mail = new Element\Email('mail');
       	$mail->setAttribute('size', '40')
               ->setAttribute('required', 'true')
               ->setAttribute('placeholder', 'Adresse mail')
               ->setAttribute('class', 'form-control');
       	$this->add($mail);
        
        $submit = new Element\Submit('submit');
       	$submit->setValue('Inscription')
               ->setAttribute('id', 'submit') 
               ->setAttribute('class', 'btn btn-block btn-lg btn-success');
       	$this->add($submit);
        
        $inputFilter = new InputFilter();
        $factory = new InputFactory();
        
        $inputFilter->add($factory->createInput(array(
                    'name' => 'prenom',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'StringTrim'),
                    ),
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
                    'name' => 'nom',
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
                    'name' => 'password',
                    'required' => true,
                    'validators' => array(
                        array(
                            'name' => 'StringLength',
                            'options' => array(
                                'min' => 5
                            )
                        )
                    )
        )));

        $this->setInputFilter($inputFilter);
        
    }
}
