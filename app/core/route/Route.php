<?php

namespace App\Core\Route;
use \App\Core\Application as App;
/**
 * Class Route
 * Простая маршрутизация для тестового приложения
 * @author dtoxin <dtoxin10gmail.com>
 * @version 0.1
 * @package App\Core\Route
 * @todo неверная документация
 */
class Route {

    protected $_method;
    protected $_request_url;
    protected $_http_host;
    protected $_routes;
    protected $_params;

    public function __construct($URL)
    {
        //@todo обработка ошибок и 404
        $this->_requestUrl = $URL;
        $this->_method = (isset($_SERVER['REQUEST_METHOD'])) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        $this->_http_host = $_SERVER['HTTP_HOST'];

        $routesFile = \Config::get('path', 'APP_PATH', false, true) . DIRECTORY_SEPARATOR . 'config/routes.php';
        try{
            if (!file_exists($routesFile)){
                throw new \Exception ('Route file is missing!!!');
            }
            $this->_routes = require $routesFile;
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function pass()
    {
        //Дополнительные действия например фильтры
        $this->_parse_utl($this->_requestUrl);
    }

    protected function _parse_utl($url)
    {
        if ($url == '/') {
            //navigate
        }
        $nativeUrl  = '';
        if (stripos($url, '?')) {
            $tmpParsed = $this->_parseGet($url);
            $this->_setRouteParams($tmpParsed['get_params']);
            $nativeUrl = $tmpParsed['raw_url'];
        } else {
            $nativeUrl = $url;
        }

        if (isset($this->_routes[$nativeUrl])) {
            $this->_execRoute($this->_routes[$nativeUrl]);
        }
    }

    protected function _parseGet($str)
    {
        $data = explode('?', $str);
        if (count($data) > 2) {
            //@todo неверный запрос
        }
        return array(
            'raw_url' => $data[0],
            'get_params' => $data[1],
        );
    }

    //переход с параметрами
    protected function _execWithParams($urlCollect)
    {

    }

    protected function _setRouteParams($paramStr)
    {
        $result = array();
        $allParams = explode('&', $paramStr);
        foreach ($allParams as $item) {
            $singleParam = explode('=', $item);
            array_push($result, $singleParam[1]);
        }
        $this->_params = implode(',', $result);
    }

    protected function _execRoute($route)
    {
        $items = explode('#', $route);
        $controller = $items[0];
        $action = $items[1];

        $classController = $this->_factoryNamespace($controller);
        if (method_exists($classController, $action)) {
            $classController->$action($this->_params);
        }

    }

    protected function _factoryNamespace($class)
    {
        $controllerNameSpace = \Config::get('app', 'controllerNameSpace');
        $class = $controllerNameSpace . $class;
        return new $class();
    }

}