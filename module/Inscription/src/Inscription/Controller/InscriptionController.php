<?php

namespace Inscription\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Inscription\Model\Inscription,
    Inscription\Form\InscriptionForm;

class InscriptionController extends AbstractActionController {

    protected $inscriptionTable;

    public function getInscriptionTable() {
        if (!$this->inscriptionTable) {
            $sm = $this->getServiceLocator();
            $this->inscriptionTable = $sm->get('Inscription\Model\InscriptionTable');
        }
        return $this->inscriptionTable;
    }

    public function indexAction() {
        $authService = $this->serviceLocator->get('auth_service');
        if ($authService->hasIdentity()) {
            return $this->redirect()->toUrl('enfant');
        }    
            
        $form = new InscriptionForm();

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                if($this->getRequest()->getPost('password')==$this->getRequest()->getPost('password2')){
                    $inscription = new Inscription();
                    $inscription->exchangeArray($form->getData());
                    $this->getInscriptionTable()->saveInscription($inscription);

                    // Redirect to list of inscriptions
                    return $this->redirect()->toRoute('login');
                }else{
                    $this->flashMessenger()->addMessage('Les mots de passe ne sont pas identiques!');
                    return new ViewModel(array(
                    'title' => 'Inscription',
                    'form' => $form,
                    'flashMessages' => $this->flashMessenger()->getMessages()
                ));
                }
            }else{
                $this->flashMessenger()->addMessage("Le formulaire n'a pas été correctement remplis!");
                return new ViewModel(array(
                    'title' => 'Inscription',
                    'form' => $form,
                    'flashMessages' => $this->flashMessenger()->getMessages()
                ));
            }
        }
        return array('form' => $form,
            'flashMessages' => $this->flashMessenger()->getMessages()
        );
    }

    

}
