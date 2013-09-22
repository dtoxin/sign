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
    protected $_params = null;

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

    public function send404($msg)
    {
        //@todo отобразить через VIEW 404
        $genController = new \App\Core\Controller\GenericController();
        $genController->make404(array(
            'msg' => $msg,
        ));
    }

    protected function _parse_utl($url)
    {
        if ($url == '/') {
            if (isset($this->_routes[$url])) {
                $this->_execRoute($this->_routes[$url]);
            }
        }
        $count_segments = count(explode('/', $url));
        $nativeUrl = $url;
        if ($count_segments > 3) {
            $newUrl = $this->_setRouteParams($url);
            $nativeUrl = $newUrl['url'];

        }
        if (isset($this->_routes[$nativeUrl])) {
            $this->_execRoute($this->_routes[$nativeUrl]);
        } else {
            $this->send404('Page not found');
        }
    }

    /**
     * Не нужна но оставлю на будущее
     * @deprecated
     * @param $str
     * @return array
     */
   /* protected function _parseGet($str)
    {
        $data = explode('?', $str);
        if (count($data) > 2) {
            //@todo неверный запрос
        }
        return array(
            'raw_url' => $data[0],
            'get_params' => $data[1],
        );
    }*/


    //@todo deprecated
    protected function _setRouteParams($paramStr)
    {
        $result_url = array('url' => '/');
        $result_params = array();
        $allParams = explode('/', $paramStr);
        $scount = count($allParams);
        for ($i = 1; $i < $scount; $i++) {
            if ($i <= 2) {
                $result_url['url'] = $result_url['url'] . $allParams[$i];
                if ($i != 2) {
                    $result_url['url'] = $result_url['url'] . '/';
                }
                continue;
            }
            array_push($result_params, $allParams[$i]);
        }

        $this->_params = $result_params;

        return $result_url;
    }

    protected function _execRoute($route)
    {
        $items = explode('#', $route);
        $controller = $items[0];
        $action = $items[1];

        $classController = $this->_factoryNamespace($controller);

        try {
            if (method_exists($classController, $action)) {
                //Сначала вызовем _before()
                if (method_exists($classController, 'before')) { $classController->before();}
                $classController->$action($this->_params);
            } else {
                if (method_exists($classController, 'def')) {
                    $classController->def($this->_params);
                } else {
                    throw new \Exception ('404 Not found');
                }
            }
        } catch (\Exception $e) {
            die($e->getMessage());

        }
    }

    protected function _factoryNamespace($class)
    {
        $controllerNameSpace = \Config::get('app', 'controllerNameSpace');
        $class = $controllerNameSpace . $class;
        return new $class();
    }


}