<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dtoxin
 * Date: 9/21/13
 * Time: 2:46 AM
 * To change this template use File | Settings | File Templates.
 */

namespace App\Controllers;


class MainController extends \App\Core\Controller\GenericController
{
    //public $layout

    public function def()
    {
        die('default');
    }
    public function home()
    {
        $this->_render('main/home', array('simple' => '<h1>Today</h1>'));
    }

    public function before()
    {
        parent::before();
    }
}