<?php

namespace App\Core;


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
}