<?php
require_once "./../models/AuthModel.php";
session_start();
class authController {
    //khởi tạo thuộc tính   
    private $model; 

    public function __construct() {
        //kết nối đến model từ UserModel
        $this->model = new AuthModel();
    }
    //loginForm
    public function loginForm() {
        include "./../views/auth/login.php";
    }

    //trang login
    public function login() {
        $error = " ";
        // Xử lý form đăng nhập
        if (isset($_POST['dangnhap']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            // Validate input
            if (empty($username) || empty($password)) {
                $error = "Vui lòng nhập đầy đủ thông tin đăng nhập.";
            }
            else {
                $user = $this->model->loginModel($username, $password);
                if ($user) {
                    // Lưu thông tin vào session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];  
                    // Chuyển hướng theo
                    if ($user['role'] == 'admin') {
                        header("Location: ./admin.php");
                    } 
                    else {
                        header("Location: ./client.php");
                    }
                    exit();
                    // }
                } else {
                    $error = "Tên đăng nhập hoặc mật khẩu không đúng. Vui lòng thử lại.";
                }
            }
        }
        
        include "./../views/auth/login.php";
    }

    public function logout() {
        // Xóa tất cả session
        session_unset();
        session_destroy();
        // chuyển hướng về trang Client
        header("Location: ./client.php");
        exit();
    }
    
    // Trang đăng ký
    public function register() {
        $error = "";
        $success = "";
        // Xử lý form đăng ký
        if ( isset($_POST['dangky'])) {
            $fullname = trim($_POST['fullname']);
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
                $error = "Vui lòng nhập đầy đủ thông tin.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email không hợp lệ.";
            } elseif (strlen($password) < 6) {
                $error = "Mật khẩu phải có ít nhất 6 ký tự.";
            } elseif ($password !== $confirm_password) {
                $error = "Mật khẩu xác nhận không khớp.";
            } else {
                // Thực hiện đăng ký
                $result = $this->model->registerModel($fullname, $username, $password, $email);
                if ($result) {
                    $success = "Đăng ký thành công! Vui lòng đăng nhập.";
                } else {
                    $error = "Đăng ký thất bại. Tên đăng nhập đã tồn tại.";
                }
            }
        }
        include "./../views/auth/register.php";
    }
}
?>