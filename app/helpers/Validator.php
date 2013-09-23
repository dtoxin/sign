<?php

/**
 * Class Validator
 * Класс для валидации полей форм
 * Написан на "скорую руку" для проверки данных из _POST формы регистрации
 */
class Validator {

    /**
     * @param $email
     * @param array $params
     * @return bool
     */
    public static function email($email, $params = array())
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
        //if (empty($email)) { return false; }
        /*if(!preg_match("/[a-zA-Z0-9_-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $email)) {
            return false;
        }
        return true;*/
    }

    /**
     * @param $str строка для проверки
     * @param array $params необязательные параметры для совместимости с другими валидаорами
     * @return bool true - валидация прошла
     */
    public static function required($str, $params = array())
    {
        if (!empty($str)) {
            return true;
        }
        return false;
    }

    /**
     * @param $str что проверять
     * @param array $params массив содержащий forConfirm поле
     * @return bool true усли OK
     */
    public static function confirmation($str, $params = array())
    {
        if (empty($str)) { return false;
        }
        if ($str = $params['forConfirm']) {
            return true;
        }
        return false;
    }

    public static function unique($str, $params = array())
    {
        // Проверим пользователя на уникальность

        $status = \App\Models\User::m()->exists($params['field'], array(':value' => $str));
        // Если false (записи нет = уникальный) то валидатор пройден
        if (!$status) {
            return true;
        }

        return false;
    }
}