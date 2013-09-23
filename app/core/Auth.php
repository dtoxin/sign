<?php

namespace App\Core;

use \App\Models\User as User;
class Auth {

    protected static $_instance;

    private function __construct() {}

    private function __clone() {
    }

    private function __wakeup() {
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * Хэширование пароля
     * @param $password пароль от которого нужен хэш
     * @return string sha1(password)
     */
    public function hashPassword ($password)
    {
        return sha1($password);
    }

    public function authenticate($email, $password)
    {
        // Что бы лишний раз базу не дёргать сверим заполнение полей
        if (empty($email) || empty($password)) { return false; }

        // Сверим по базе
        $user = User::m()->authenticate($email, Auth::getInstance()->hashPassword($password));
        if (!$user) {
            return false;
        }

        // Сохранить время последнего логина
        User::m()->execSql('UPDATE ' . User::m()->getTable() . ' SET last_login = "' . date('Y-m-d H:i:s') . '" WHERE id=' . $user->id);

        Auth::getInstance()->saveCredentials($user);
        return true;
    }

    public function saveCredentials(\stdClass $user)
    {
        session_start();
        $_SESSION['id'] = $user->id;
        $_SESSION['name'] = $user->name;
    }

    public function logout(){
        session_start();
        unset($_SESSION['id']);
        unset($_SESSION['name']);
    }

    public function isAuthenticated()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['id'])) {
            $user = User::m()->getOne($_SESSION['id']);
            if ($user) {
                return true;
            }
        }

        return false;
    }
}