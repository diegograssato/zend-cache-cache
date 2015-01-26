<?php
return array(
    'doctrine' => array(
        'configuration' => array(
            'odm_default' => array(
                'metadata_cache' => 'my_memcache',
                'driver' => 'odm_default',
                'generate_proxies' => true,
                'proxy_dir' => 'data/DoctrineMongoODMModule/Proxy',
                'proxy_namespace' => 'DoctrineMongoODMModule\Proxy',
                'generate_hydrators' => true,
                'hydrator_dir' => 'data/DoctrineMongoODMModule/Hydrator',
                'hydrator_namespace' => 'DoctrineMongoODMModule\Hydrator',
                'default_db' => 'zf-cache',
                'filters' => array()
            ),
            'orm_default' => array(
                'metadata_cache'    => 'my_memcache',
                'query_cache'       => 'my_memcache',
                'result_cache'      => 'my_memcache',
                'hydration_cache'   => 'my_memcache',
            )
        )

    ),
    'service_manager' => array(
        'factories' => array(
            'doctrine.cache.my_redis' => function ($sm) {
                $cache = new \Doctrine\Common\Cache\RedisCache();
                $memcache = new \Redis();
                $memcache->connect('127.0.0.1','6379');
                $cache->setRedis($memcache);
                return $cache;
            },
            'doctrine.cache.my_memcache' => function ($sm) {
                $cache = new \Doctrine\Common\Cache\MemcacheCache();
                $memcache = new \Memcache();
                $memcache->connect('localhost', 11211);
                $cache->setMemcache($memcache);
                return $cache;
            }
        )
    )



);
