<?php

/**
 * Самый полезный файл приложения
 * Конечно можно было composer прикрутить но я и так слишком сильно заморочился
 * Автозагрузчик классов
 * Class Autoloader
 */
class Autoloader
{
    /**
     * Загрузка через ns
     * @param $className класс
     */
    public static function loadClass($className)
    {
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        //@todo лишний коммент
        $fileToLoad = realpath(__DIR__ . "/../../") . DIRECTORY_SEPARATOR . Autoloader::normalizePath($fileName);
        if (file_exists($fileToLoad)) {
            require $fileToLoad;
        }

    }


    /**
     * Превращает /App/Controllers/HomeController.php в /app/controllers/HomeController.php
     * @param $path путь
     * @return mixed результат
     */
    public static function normalizePath($path)
    {
        $expPath = explode("/", $path);
        $fileName = end($expPath);
        $lowerPath = strtolower($path);
        $result = str_replace(strtolower($fileName), $fileName, $lowerPath);
        return $result;
    }

    /**
     * Загрузка хэлперов
     * @param $className
     */
    public static function helpersLoadClass($className)
    {
        require_once realpath(__DIR__ . '/../helpers' . DIRECTORY_SEPARATOR . $className . '.php' );
    }


}