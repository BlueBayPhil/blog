<?php

// Setup auto-loading with namespaces.
spl_autoload_register(function($class) {
    include str_replace('\\', '/', $class) . '.php';
});

use App\App;

// Create a new instance of our app and run.
App::instance()->run();