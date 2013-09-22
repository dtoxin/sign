<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dtoxin
 * Date: 9/21/13
 * Time: 9:41 PM
 * To change this template use File | Settings | File Templates.
 */

namespace App\Controllers;


class UsersController extends \App\Core\Controller\GenericController
{
    public function signin()
    {
        $this->_render('users/signin');
    }

    public function signup()
    {
        $this->_render('users/signup');
    }

    public function jxSignin()
    {
        $stat = array(
            'stat' => 1,
            'messages' => 'none',
        );
        $this->_renderJson($stat);
    }
}