<?php
namespace Client;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Client\Model\Client;
use Client\Model\ClientTable;
use Client\Model\Restaurant;
use Client\Model\RestaurantTable;
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
                 'Client\Model\ClientTable' =>  function($sm) {
                     $tableGateway = $sm->get('ClientTableGateway');
                     $table = new ClientTable($tableGateway);
                     return $table;
                 },
                 'ClientTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Client());
                     return new TableGateway('client', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Client\Model\RestaurantTable' =>  function($sm) {
                     $tableGateway = $sm->get('RestaurantTableGateway');
                     $table = new RestaurantTable($tableGateway);
                     return $table;
                 },
                 'RestaurantTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Restaurant());
                     return new TableGateway('restaurant', $dbAdapter, null, $resultSetPrototype);
                 },        
             ),
         );
     }


}
