<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Inscription\Controller\Inscription' => 'Inscription\Controller\InscriptionController',
        ),
    ),
    
    
    'router' => array(
         'routes' => array(
             'inscription' => array(
                 'type'    => 'literal',
                 'options' => array(
                     'route'    => '/inscription',
                     'defaults' => array(
                         'controller' => 'Inscription\Controller\Inscription',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

    
    'view_manager' => array(
        'template_path_stack' => array(
            'inscription' => __DIR__ . '/../view',
        ),
    ),
);
