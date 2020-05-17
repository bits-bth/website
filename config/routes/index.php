<?php

use bits\Controller\FlatFileController;
use bits\Facade\Router;

Router::get("/:file", [FlatFileController::class, "serveFile"]);
