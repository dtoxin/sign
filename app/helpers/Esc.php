<?php

/**
 * Class Esc
 * Экранирование символов
 */
class Esc {
    public static function cape($str)
    {
        return htmlspecialchars($str);
    }
}