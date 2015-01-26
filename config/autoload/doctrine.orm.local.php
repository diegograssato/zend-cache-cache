<?php
return array(
    'doctrine' => array(
        'connection' => array(
            // default connection name
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => 'root',
                    'dbname'   => 'zf-cache',
                    'charset' => 'utf8', // extra
                    'driverOptions' => array(
                        1002=>'SET NAMES utf8'
                    )

                ),
                'doctrine_type_mappings' => array(
                    'enum' => 'string'
                ),

            )
        ),

    ),
    'service_manager' => array(
        'factories' => array(
            'doctrine.cache.my_memcache' => function ($sm) {
                $cache = new \Doctrine\Common\Cache\RedisCache();
                $memcache = new \Redis();
                $memcache->connect('127.0.0.1','6379');
                $cache->setRedis($memcache);
                return $cache;
            },
        ),
    ),

);