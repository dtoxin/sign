<?php

class Usr {

    public static function getLoginAss()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['name'])) {
            return $_SESSION['name'];
        }
    }

    public static function hasCredentials()
    {
        return \App\Core\Auth::getInstance()->isAuthenticated();
    }


}