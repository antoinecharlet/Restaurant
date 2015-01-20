<?php

namespace Client\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Client\Model\Client;
use Client\Form\ClientForm;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class ClientController extends AbstractActionController {

    protected $clientTable;
    protected $restaurantTable;

    public function getClientTable() {
        if (!$this->clientTable) {
            $sm = $this->getServiceLocator();
            $this->clientTable = $sm->get('Client\Model\ClientTable');
        }
        return $this->clientTable;
    }
    
    public function getRestaurantTable() {
        if (!$this->restaurantTable) {
            $sm = $this->getServiceLocator();
            $this->restaurantTable = $sm->get('Client\Model\RestaurantTable');
        }
        return $this->restaurantTable;
    }

    public function indexAction() {
        
        $authService = $this->serviceLocator->get('auth_service');
        if (!$authService->hasIdentity()) {
            return $this->redirect()->toUrl('../login');
        }else{
            $userContainer = new Container('user');
            $id = $userContainer->offsetGet('id');
            
        $form = new ClientForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $client = new Client();
            $form->setData($request->getPost());
            $date_restaurant = $request->getPost('date_restaurant');
            $nb_place = $request->getPost('nb_place');
            $date = $request->getPost('date');
            

            if ($form->isValid() AND $nb_place>0 AND $date_restaurant==$date) {
                $nb_place--;
                $client->exchangeArray($form->getData());
                $this->getClientTable()->saveClient($client);
                
                $this->getRestaurantTable()->decrementePlace($nb_place, $date);
                
                $this->flashMessenger()->addMessage('Réservation effectué avec succès!');

                // Redirect to list of clients
                return $this->redirect()->toRoute('client');
            }else{
                $this->flashMessenger()->addMessage('Mauvais jour saisi ou plus de place disponible!');
                return $this->redirect()->toRoute('client');
            }
        }
        return new ViewModel(array('form' => $form,
            'restaurants' => $this->getRestaurantTable()->fetchAll(),
            'flashMessages' => $this->flashMessenger()->getMessages(),
            ));
        }
    }


}
