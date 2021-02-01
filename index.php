<?php

spl_autoload_register(function($class) {
    include str_replace('\\', '/', $class) . '.php';
});

use App\App;

define('BASE_PATH', dirname(__DIR__));
define('VIEW_PATH', BASE_PATH . 'App/Views/');

App::instance()->run();

