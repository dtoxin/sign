<?php

namespace App\Core;

use \App\Models\User as User;

/**
 * Class Auth
 * Простой класс авторизации и аунтификации
 * @author dtoxin <dtoxin10@gmail.com>
 * @package App\Core
 */
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

    /**
     * Авторизация
     * @param $email
     * @param $password
     * @return bool true если успешно
     */
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

        // сохраним в сессию
        Auth::getInstance()->saveCredentials($user);
        return true;
    }

    /**
     * Сохранение данных входа
     * @param \stdClass $user
     */
    public function saveCredentials(\stdClass $user)
    {
        session_start();
        $_SESSION['id'] = $user->id;
        $_SESSION['name'] = $user->name;
    }

    // выход
    public function logout(){
        session_start();
        unset($_SESSION['id']);
        unset($_SESSION['name']);
    }

    /**
     * Прверка текущего пользователя на авторизованность
     * @return bool
     */
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