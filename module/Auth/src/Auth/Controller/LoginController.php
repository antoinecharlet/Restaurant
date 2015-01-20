<?php
namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\Session\Container,
    Zend\Authentication\Adapter\DbTable,
    Zend\View\Model\ViewModel,
    Auth\Form\Login;

class LoginController extends AbstractActionController {

    public function loginAction() {

        $authService = $this->serviceLocator->get('auth_service');
        if ($authService->hasIdentity()) {

            // if not log in, redirect to login page
            return $this->redirect()->toUrl('client');
        }

        $form = new Login;
        $loginMsg = array();
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if (!$form->isValid()) {
                // not valid form
                $formenonvalide = "zut";
                return new ViewModel(array(
                    'title' => 'Connexion',
                    'form' => $form,
                    'formenonvalide' => $formenonvalide
                ));
            }
            
            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'); 
            $loginData = $form->getData();
            $authAdapter = new DbTable($dbAdapter, 'client', 'mail', 'password');
            $authAdapter->setIdentity($loginData['mail'])
                        ->setCredential($loginData['password']);
            $authService = $this->serviceLocator->get('auth_service');
            $authService->setAdapter($authAdapter);
            $result = $authService->authenticate();
            if ($result->isValid()) {
                // set id as identifier in session
                $userId = $authAdapter->getResultRowObject('id')->id; 
                $authService->getStorage()->write($userId);
                
                $userContainer = new Container('user');
                $userContainer->id = $userId;
                
                return $this->redirect()->toUrl('client');

            } else {
                $loginMsg = $result->getMessages();
            }
        }

        return new ViewModel(array('title' => 'Connexion',
            'form' => $form,
            'loginMsg' => $loginMsg
        ));
    }

    public function logoutAction() {
        $authService = $this->serviceLocator->get('auth_service');

        $authService->clearIdentity();
        $userContainer = new Container('user');
        $userContainer->getManager()->getStorage()->clear('user');
        $form = new Login();
        $aurevoir = "aurevoir";
        $viewModel = new ViewModel(array('title' => 'Deconnexion',
            'form' => $form,
            'title' => 'Deconnexion',
            'aurevoir' => $aurevoir
        ));
        $viewModel->setTemplate('auth/login/login.phtml');
        return $viewModel;
    }

    public function getUserTable() {
        if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Auth\Model\UserTable');
        }

        return $this->userTable;
    }

}
