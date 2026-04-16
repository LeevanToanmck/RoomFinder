<?php
$ControllerName = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'loginForm';
require_once "./../controllers/{$ControllerName}Controller.php";
$controller = new $controllerClass();
$controller->$action();
?>