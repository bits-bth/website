<?php

use bits\Controller\DevController;
use bits\Facade\Router;

Router::get("/dev/about", [DevController::class, "about"]);
Router::get("/dev/json", [DevController::class, "handleJSON"]);
Router::get("/dev/:file", [DevController::class, "handleIndex"]);
