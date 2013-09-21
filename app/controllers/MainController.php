<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dtoxin
 * Date: 9/21/13
 * Time: 2:46 AM
 * To change this template use File | Settings | File Templates.
 */

namespace App\Controllers;
use \App\Models\User as User;

class MainController extends \App\Core\Controller\GenericController
{

    public function def()
    {
        die('default');
    }
    public function home()
    {
        /*$users = User::m()->getAll();
        foreach($users as $u)
        {
            print($u->name);
        }*/
        //$user = User::m()->getOne(1);
        //insert
        //$user = User::m()->create(array(':name' => 'kosty', ':psw' => '55445'));
        //update
        //$user = User::m()->update(array(':name' => 'kosty', ':psw' => '55445', ':id' => 1));
        //$user = User::m()->delete(1);
        //$user = User::m()->exists('name', array(':value' => 'Dima'));
        $this->_render('main/home', array('user' => 'test'));
    }

    public function before()
    {
        parent::before();
    }
}