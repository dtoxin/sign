<?php

return array(
    // маршруты не должны оканчиваться на / !!!!!!!!
    '/' => 'MainController#home',
    '/signin' => 'UsersController#signin',
    '/signup' => 'UsersController#signup',
    '/signout' => 'UsersController#signout',
    '/users/profile' => 'UsersController#profile',
    '/users/jxSignin' => 'UsersController#jxSignin',
);