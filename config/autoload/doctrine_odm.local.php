<?php
return array(
    'doctrine' => array(
        'connection' => array(
            'odm_default' => array(
                'server' => '127.0.0.1',
                'port' => '27017',
                'dbname' => 'dtux',
                 'options' => array(
                )
            )
        ),
        'documentmanager' => array(
            'odm_default' => array(
                'connection' => 'odm_default',
                'configuration' => 'odm_default',
                'eventmanager' => 'odm_default'
            )
        ),
        'eventmanager' => array(
            'odm_default' => array(
                'subscribers' => array(

                )
            )
        ),

        'mongo_logger_collector' => array(
            'odm_default' => array(),
        ),


    ),
    'service_manager' => array(
        'aliases' => array(
            'Doctrine\ODM\MongoDB\DocumentManager' => 'doctrine.documentmanager.odm_default',

        )
    )




);
