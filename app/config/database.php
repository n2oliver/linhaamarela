<?php 

define('BASEPATH', '/jogos/linhaamarela/');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'   => '',
    'hostname' => env('DB_HOST'),
    'username' => env('DB_USER'),
    'password' => env('DB_PASS'),
    'database' => env('DB_NAME'),
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'autoinit' => TRUE,
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array()
);

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => $db['default']['hostname'],
    'database'  => $db['default']['database'],
    'username'  => $db['default']['username'],
    'password'  => $db['default']['password'],
    'charset'   => $db['default']['char_set'],
    'collation' => $db['default']['dbcollat'],
    'prefix'    => $db['default']['dbprefix'],
]);

// Event dispatcher, not required, but very handy
$capsule->setEventDispatcher(new Dispatcher(new Container())); 

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Query logging, you can also commented it out, when you don't need it
$capsule->connection()->enableQueryLog();