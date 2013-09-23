<?php

namespace App\Core;

use \App\Core\Route\Route as Route;

/**
 * Class Application
 * Класс отвечающий за запуск приложения и старт маршрутизации
 * @package App\Core
 */
class Application {

    /**
     * Старт приложения начинается отсюда
     */
    public static function start()
    {
        $route = new \App\Core\Route\Route($_SERVER['REQUEST_URI']);
        $route->pass();
    }

    /**
     * Выполняет роль стоп крана. Использовался сразу после рендеринга view
     * @param $status код завершения (200 например)
     */
    public static function stop($status)
    {
        header('Content-type: text/html');
        http_response_code ($status);

    }

    /**
     * Ajax ответ
     * @param $status
     */
    public static function stopAjax($status)
    {
        // Установка заголовка
        header('Content-type: application/json');
        http_response_code ($status);
    }

    /**
     * Внутренний редирект
     * @param $utl ссылка точб в точь такая как в конфигурации routes.php
     */
    public static function redirect($utl)
    {
        header("Location: http://".$_SERVER['HTTP_HOST'] . $utl);
    }
}