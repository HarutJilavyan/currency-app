<?php
// Установка базового пути
define('ROOT', dirname(__FILE__));

// Автозагрузка нужных файлов
require_once ROOT . '/app/requires/requires.php';
var_dump(1);
// Запуск маршрутизатора
$router = new Route();
$router->run();
?>