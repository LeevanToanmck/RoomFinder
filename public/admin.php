<?php
session_start();
if($_SESSION['role'] != 'admin'){
    echo "<script>alert('Bạn không có quyền vào trang này!'); window.location.href='./client.php';</script>";
}
$controllerName = $_GET['controller'] ?? 'admin';// đường dẫn đến controller ?? 
$action = $_GET['action'] ?? 'index';// đường dẫn đến action ??
$controllerClass = $controllerName . 'Controller'; // tên class của controller
require_once "./../controllers/{$controllerClass}.php";// đường dẫn đến file controller
$controller = new $controllerClass();// khởi tạo đối tượng của controller
$controller->$action(); // gọi phương thức action của controller