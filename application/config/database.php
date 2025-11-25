<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Active Database Group
|--------------------------------------------------------------------------
*/
$active_group = 'default';
$query_builder = TRUE;

/*
|--------------------------------------------------------------------------
| Database Configuration
|--------------------------------------------------------------------------
| Disesuaikan untuk XAMPP (localhost)
| Database: sistem_sales_order
| Username: root
| Password: (kosong)
|--------------------------------------------------------------------------
*/

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'	   => '',
    'hostname' => 'db',
    'username' => 'root',
    'password' => 'root',
    'database' => 'sistem_sales_order',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

/*
|--------------------------------------------------------------------------
| Environment-specific Configuration (Opsional)
|--------------------------------------------------------------------------
| Kamu bisa menambahkan konfigurasi lain misalnya untuk hosting / staging:
| 
| $db['production'] = array(
|     'hostname' => 'your-server.com',
|     'username' => 'db_user',
|     'password' => 'your_pass',
|     'database' => 'sistem_sales_order',
|     'dbdriver' => 'mysqli',
|     'pconnect' => FALSE,
|     'db_debug' => FALSE,
|     'char_set' => 'utf8mb4',
|     'dbcollat' => 'utf8mb4_unicode_ci'
| );
|
|--------------------------------------------------------------------------
*/
