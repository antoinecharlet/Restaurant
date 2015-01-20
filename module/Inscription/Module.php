<?php
namespace Inscription;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Inscription\Model\Inscription;
use Inscription\Model\InscriptionTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Inscription\Model\InscriptionTable' =>  function($sm) {
                     $tableGateway = $sm->get('InscriptionTableGateway');
                     $table = new InscriptionTable($tableGateway);
                     return $table;
                 },
                 'InscriptionTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Inscription());
                     return new TableGateway('client', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }


}
