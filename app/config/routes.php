<?php

return array(
    // маршруты не должны оканчиваться на / !!!!!!!!
    '/' => 'MainController#home',
    '/signin' => 'UsersController#signin',
    '/signup' => 'UsersController#signup',
    '/users/postSignup' => 'UsersController#postSignup',
    '/users/jxSignin' => 'UsersController#jxSignin',
);