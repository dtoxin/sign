<?php

/**
 * Интернациализация
 * Class L
 */
class L {

    /**
     * Возвращает переведённую строку
     * @param $msg строка для перевода
     * @return mixed переведённая строка или исходная
     */
    public static function t($msg)
    {
        $currentLocale = (!empty($_COOKIE['locale'])) ? $_COOKIE['locale'] : 'en';
        // Если текущий язык родной язык приложения (английский) то не переводим и возвратим исходную строку
        if ($currentLocale == 'en') {
            return $msg;
        }

        $lngFile = require realpath(__DIR__ . '/../lang' . DIRECTORY_SEPARATOR . $currentLocale . DIRECTORY_SEPARATOR . 'dictionary.php');
        if (isset($lngFile[$msg])) {
            return $lngFile[$msg];
        }

        // Если отсутствует то вернем исходную строку
        return $msg;
    }
}