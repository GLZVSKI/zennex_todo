<?php

namespace php;

use php\core\Route;

spl_autoload_register(function (string $className) {
    include_once str_replace('\\', '/', $className . '.php');
});

Route::start();
