<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'session' => array(
        'cache_expire' => 525949,
        //'cookie_domain' => 'teste.com.br',
        'cookie_lifetime' => 31536000,
        //'cookie_path' => '/',
        //'cookie_secure' => TRUE,
        'gc_maxlifetime' => 31536000,
        'remember_me_seconds' => 31536000,
        'use_cookies' => TRUE,
        'cookie_httponly'     => true,

    )
);
