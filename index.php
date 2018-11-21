<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('INSTALL_PATH', __DIR__);
require INSTALL_PATH . '/vendor/autoload.php';

$di = new \bits\DI\DI();
$di->loadServices(INSTALL_PATH . '/config/services');