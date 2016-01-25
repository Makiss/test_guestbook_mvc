<?php
use components\Router as Router;

// FRONT CONTROLLER

// 1. Main settings.
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. Connection with system files.
define('ROOT', dirname(__FILE__));
include(ROOT . '\\components\\Autoload.php');

//3. Router call.

$router = new Router();
$router->run();
