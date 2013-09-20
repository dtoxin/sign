<?php
namespace App;

// Создаю константу APP_ENV определяю её как переменную среды из файла .htaccess, если нет то production
// Это нужно для разделения конфигурации
use Core\Autoloader;

define('APP_ENV', getenv('APP_ENV') ? getenv('APP_ENV') : 'production');

// Взависимости от от APP_ENV загружаю конфигурацию
$path = require_once '../app/config/' . APP_ENV . '/path.php';

// Регистрируем свой ClassLoader
require ($path['CORE_PATH'] . DIRECTORY_SEPARATOR . 'Autoloader.php');
spl_autoload_register('Autoloader::loadClass');
spl_autoload_register('Autoloader::helpersLoadClass');

/*$a = new \App\Controllers\MainController();
$a->home();
die();*/
// Запускаем этот дъявольский веллосипед x)
\App\Core\Application::start($path);
