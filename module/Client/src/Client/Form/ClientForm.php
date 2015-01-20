<?php
namespace Client\Form;

use Zend\Form\Form,
    Zend\Session\Container,
    Zend\Form\Element;

class ClientForm extends Form {

    public function __construct() {

        parent::__construct('client');
        $this->setName('client');
        $this->setAttribute('method', 'post');

        $userContainer = new Container('user');
        $session_id = $userContainer->offsetGet('id');
        $id = new Element\Hidden('id');
        $id->setValue($session_id);
        $this->add($id);
        
        $date = new Element\Date('date');
       	$date->setAttribute('class', 'form-control');
       	$this->add($date);

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Réserver',
                'class' => 'btn btn-success pull-right col-lg-3',
            ),
        ));
    }

}
