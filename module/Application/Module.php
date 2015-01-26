<?php

namespace Application;

use Zend\Cache\StorageFactory;
use Zend\Session\SaveHandler\Cache;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SaveHandler\MongoDB;
use Zend\Session\SaveHandler\MongoDBOptions;
use Zend\Session\SessionManager;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        if (php_sapi_name() != 'cli')
            $this->initRedisSession($e);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }


    private function initRedisSession(MvcEvent $e)
    {
        $application  = $e->getApplication();
        $config = $application->getServiceManager()->get('config');

        $config = $config['session'];
        $config['phpSaveHandler'] = 'redis';
        $config['savePath'] = 'tcp://127.0.0.1:6379?weight=1&timeout=1';
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config);
        $manager = new SessionManager($sessionConfig);

        Container::setDefaultManager($manager);

    }

    private function initMemCachedSession(MvcEvent $e)
    {
        $application  = $e->getApplication();
        $config = $application->getServiceManager()->get('config');
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config['session']);


        $cache = StorageFactory::factory(array(
            'adapter' => array(
                'name' => 'memcached',
                'options' => array(
                    'servers' => '127.0.0.1',
                ),
            )
        ));
        $saveHandler = new Cache($cache);
        $manager = new SessionManager($sessionConfig);
        $manager->setSaveHandler($saveHandler);

        Container::setDefaultManager($manager);

    }
    private function initSession(MvcEvent $e)
    {
        $application  = $e->getApplication();
        $config = $application->getServiceManager()->get('config');


        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config['session']);
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->rememberMe(31536000);

        $options        = new MongoDBOptions(array(
            'database'   => 'zf-cache',
            'collection' => 'session-cache',
        ));
        $mongo = $application->getServiceManager()->get('Doctrine\ODM\MongoDB\DocumentManager')->getConnection()->getMongo();
        $saveHandler    = new MongoDB($mongo, $options);

        $sessionManager->setSaveHandler($saveHandler);
        $sessionManager->regenerateId(true);

        Container::setDefaultManager($sessionManager);

    }
}
