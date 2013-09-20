<?php

class Autoloader
{
    public static function loadClass($className)
    {
        /*spl_autoload_extensions(".php");
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        //var_dump(strtolower($path)); die();
        require_once strtolower('../' . $path);*/
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
        //var_dump('controller: ' . $fileToLoad . " status: " . file_exists($fileToLoad) . '<br>');
        if (file_exists($fileToLoad)) {
            require $fileToLoad;
        }

    }


    public static function normalizePath($path)
    {
        $expPath = explode("/", $path);
        $fileName = end($expPath);
        $lowerPath = strtolower($path);
        $result = str_replace(strtolower($fileName), $fileName, $lowerPath);
        return $result;
    }

    public static function helpersLoadClass($className)
    {
        require_once realpath(__DIR__ . '/../helpers' . DIRECTORY_SEPARATOR . $className . '.php' );
    }


}