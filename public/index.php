<?php
namespace App;

// Создаю константу APP_ENV определяю её как переменную среды из файла .htaccess, если нет то production
// Это нужно для разделения конфигурации
use Core\Autoloader;

define('APP_ENV', getenv('APP_ENV') ? getenv('APP_ENV') : 'production');

// Взависимости от от APP_ENV загружаю конфигурацию
$conf = require_once '../app/config/' . APP_ENV . '/path.php';

// Регистрируем свой ClassLoader
require_once($conf['CORE_PATH'] . DIRECTORY_SEPARATOR . 'Autoloader.php');
spl_autoload_register('Autoloader::loadClass');


