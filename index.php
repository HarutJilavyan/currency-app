
<?php 
session_start();

define('ROOT', dirname(__FILE__));
require_once ROOT . '/app/requires/requires.php';


$router = new Route();
$router->run();
?>
