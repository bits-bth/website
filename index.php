<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('INSTALL_PATH', __DIR__);
require INSTALL_PATH . '/vendor/autoload.php';

$di = new \bits\DI\DI();
$di->addServices([
    \bits\Request\Request::class,
    \bits\Response\Response::class,
    \bits\Router\Router::class,
    \bits\Markdown\Markdown::class,
    \bits\Translation\I18n::class,
]);
\bits\DI\Facade::setRoot($di);

foreach (glob(INSTALL_PATH . "/config/routes/*.php") as $file)
    require $file;

$di->res->send(
    $di->router->handle(
        $di->req->getRoute(),
        $di->req->getMethod()
    )
);
