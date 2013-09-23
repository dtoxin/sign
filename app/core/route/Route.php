<?php


// ООО самый веселый класс моего микро фреймворка....
namespace App\Core\Route;
use \App\Core\Application as App;
/**
 * Class Route
 * Простая маршрутизация для тестового приложения
 * @author dtoxin <dtoxin10gmail.com>
 * @version 0.1
 * @package App\Core\Route
 */
class Route {

    protected $_method;
    protected $_request_url;
    protected $_http_host;
    protected $_routes;
    protected $_params = null;

    public function __construct($URL)
    {
        $this->_requestUrl = $URL;
        // Заполним свойства из запроса
        $this->_method = (isset($_SERVER['REQUEST_METHOD'])) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        $this->_http_host = $_SERVER['HTTP_HOST'];

        $routesFile = \Config::get('path', 'APP_PATH', false, true) . DIRECTORY_SEPARATOR . 'config/routes.php';
        // Проверим наличие файла с маршрутами
        try{
            if (!file_exists($routesFile)){
                throw new \Exception ('Route file is missing!!!');
            }
            $this->_routes = require $routesFile;
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Начало маршрутизации
     */
    public function pass()
    {
        $this->_parse_utl($this->_requestUrl);
    }

    /**
     * 404
     * @param $msg Текст
     */
    public function send404($msg)
    {
        $genController = new \App\Core\Controller\GenericController();
        $genController->make404(array(
            'msg' => $msg,
        ));
    }

    /**
     * Разбор запроса
     * В данной версии может понимать только запросы вида контроллер/акшэн
     * @param $url request url
     */
    protected function _parse_utl($url)
    {
        // Если только / то нет смысла его парсить
        if ($url == '/') {
            if (isset($this->_routes[$url])) {
                $this->_execRoute($this->_routes[$url]);
            }
        }
        $count_segments = count(explode('/', $url));
        $nativeUrl = $url;
        // Если больше 3 сегментов - разобрать на параметры
        if ($count_segments > 3) {
            $newUrl = $this->_setRouteParams($url);
            $nativeUrl = $newUrl['url'];

        }
        // Если заканчивается на / - убрать / т.к будет расхождение в маршрутах
        $strLen = strlen($nativeUrl);
        if ($nativeUrl[$strLen-1] == '/' && $strLen != 1) {
            $nativeUrl = substr($nativeUrl, 0, -1);
        }
        // Исполняем это в фу-ии _execRoute
        if (isset($this->_routes[$nativeUrl])) {
            $this->_execRoute($this->_routes[$nativeUrl]);
        } else {
            $this->send404('Page not found');
        }
    }

    /**
     * Установка параметро если сегментов больше 3 (Удалить в след версии)
     * @param $paramStr
     * @return array
     */
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

    /**
     * Непосредственные переход по маршруту
     * @param $route
     * @throw 404
     */
    protected function _execRoute($route)
    {
        // Парсим контроллер и экшен через разделитель #
        $items = explode('#', $route);
        $controller = $items[0];
        $action = $items[1];

        // Получим его NS чтобы не уронить ClassLoader
        $classController = $this->_factoryNamespace($controller);

        try {
            if (method_exists($classController, $action)) {
                //Сначала вызовем _before() бывает полезным
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

    /**
     * На входе класс, в контексте NS из конфига на выходе экземпляр класса. Позволяет не ронять мой ClassLoader
     * @param $class Класс контроллера
     * @return mixed эксз. класса
     */
    protected function _factoryNamespace($class)
    {
        $controllerNameSpace = \Config::get('app', 'controllerNameSpace');
        $class = $controllerNameSpace . $class;
        return new $class();
    }


}