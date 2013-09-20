<?php

/**
 * Class Config
 * Хэлпер для получения конфигурации
 * @author dtoxin <dtoxin10@gmail.com>
 * @version 0.1
 */
class Config {

    /**
     * Получает значение конфигурации из app/config
     * Пример использования echo \Config::get('app', 'test', 99);
     * @param $fileName имя файла содержащий ассоциативный массив
     * @param $key ключ в массиве
     * @param bool $default значение по умолчанию (если файла или ключа нет)
     * @param bool $useEnv если true то будет загружен файл из app/config/{APP_ENV}
     * @return |mixed| значение ключа или $default
     */
    public static function get($fileName, $key, $default = false, $useEnv = false)
    {
        $path = require __DIR__ . '/../config/' . APP_ENV . '/path.php';
        $configFile = ($useEnv) ? $path['CONFIG_PATH'] . DIRECTORY_SEPARATOR . APP_ENV . DIRECTORY_SEPARATOR . $fileName  : $path['CONFIG_PATH'] . DIRECTORY_SEPARATOR . $fileName;
        $configFile .= '.php';
        if (file_exists($configFile)) {
            $configuration = require $configFile;
            if (!empty($configuration[$key])) {
                return $configuration[$key];
            }
        }
        return $default;
    }
}