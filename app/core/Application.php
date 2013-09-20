<?php


namespace App\Core;

use \App\Core\Route\Route as Route;

class Application {

    public static function start($paths)
    {
        $route = new \App\Core\Route\Route($_SERVER['REQUEST_URI']);
        $route->pass();
    }
}