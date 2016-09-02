<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.13
 * Time: 10:11
 */

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

function enviroment()
{

    $params = null;
    if ($_SERVER['SERVER_NAME'] === "localhost") {
        $params = require_once 'params_dev.php';
    } else {
        $params = require_once 'params_prod.php';
    }

    $driver = $params['driver'];
    $host = $params['host'];
    $database = $params['database'];
    $username = $params['username'];
    $password = $params['password'];

    return [$driver, $host, $database, $username, $password];
}

list($driver, $host, $database, $username, $password) = enviroment();

$capsule->addConnection([
    'driver' => $driver
    , 'host' => $host
    , 'database' => $database
    , 'username' => $username
    , 'password' => $password
    , 'charset' => 'utf8'
    , 'collation' => 'utf8_unicode_ci'
    , 'prefix' => ''
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();

function dbRaw()
{
    list($driver, $host, $database, $username, $password) = enviroment();

    $connection = new PDO("mysql:host=" . $host . ";dbname=" . $database . ";charset=utf8", $username, $password);

    return $connection;
}