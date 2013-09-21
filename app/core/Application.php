<?php


namespace App\Core;

use \App\Core\Route\Route as Route;

class Application {

    public static function start($paths)
    {
        $route = new \App\Core\Route\Route($_SERVER['REQUEST_URI']);
        $route->pass();
    }

    public static function stop($status)
    {
        header('Content-type: text/html');
        http_response_code ($status);
        ob_end_flush();
        die();
    }
}