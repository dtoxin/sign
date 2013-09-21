<?php


namespace App\Core\Controller;


class GenericController {

    //Базовый layout в который можно вложить view
    public $layout; //Файл layout
    protected $_template_path; //директория шаблонов
    protected $_path; //Views_Path

    //массивы Assets для подключения статики из view
    protected $_css_files = array();
    protected $_js_files = array();

    //Тэг title
    protected $_title = '';

    /**
     * Заполним необходимые свойства
     */
    public function __construct()
    {
        $this->_path = \Config::get('path', 'VIEWS_PATH', false, true);
        $this->_template_path = $this->_path . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . \Config::get('app', 'template') . DIRECTORY_SEPARATOR;
    }

    /**
     * Выполнять это действие перед вызовом Action из формы
     * Подойдет для проверки на авторизацию
     */
    public function before()
    {

    }

    /**
     * Отображение view
     * Да признаю что немного неправильно выводить тут. Надо бы создать класс View но для тестового задания еще важна скорость
     * @param bool|string $layout имя файла layout
     * @param $viewName - фалй view
     * @param array $data массив который будет доступен во view
     */
    protected function _render($viewName, $data = array(), $layout = false)
    {
        try{
            ob_start();
            if (file_exists($this->_template_path . $viewName . '.php')) {
                $content = include($this->_template_path . $viewName . '.php');
            } else {
                throw new \Exception ("View not found!");
            }
            //Формируем путь до layout
            //Если $layout false то по дефолту 'layout.php'
            $_layout = ($layout) ? $layout : 'layout';
            if (file_exists($this->_template_path . $_layout . '.php')) {
                $layout = include ($this->_template_path . $_layout .'.php');
            } else {
                throw new \Exception ('Layout not found');
            }
            \App\Core\Application::stop(200);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Вывод коллекции css файлов из view
     */
    protected function _renderCss()
    {
        foreach($this->_css_files as $css) {
            echo "<link rel='stylesheet' type='text/css' href='{$css}'> \n";
        }
    }

    /**
     * Вывод коллекции JS
     */
    protected function _renderJs()
    {
        foreach($this->_js_files as $js) {
            echo "<script type='text/javascript' src='{$js}'></script>\n";
        }
    }

    /**
     * Добавление css файла в коллекцию
     * @param $file файл css
     */
    protected function _addCss($file)
    {
        array_push($this->_css_files, $file);
    }

    /**
     * Добавление в коллекцию js файла
     * @param $file js
     */
    protected function _addJs($file)
    {
        array_push($this->_js_files, $file);
    }

    /**
     * Установка заголовка страницы
     * @param $title тэг title
     */
    protected function _setTitle($title)
    {
        $this->_title = $title;
    }
}