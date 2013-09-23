<?php

/**
 * маршруты
 */
return array(
    // маршруты не должны оканчиваться на / !!!!!!!!
    //Главная
    '/' => 'MainController#home',
    // Вход
    '/signin' => 'UsersController#signin',
    // регистрация
    '/signup' => 'UsersController#signup',
    // Выход
    '/signout' => 'UsersController#signout',
    // Профиль
    '/users/profile' => 'UsersController#profile',
    // Ajax логин
    '/users/jxSignin' => 'UsersController#jxSignin',
);