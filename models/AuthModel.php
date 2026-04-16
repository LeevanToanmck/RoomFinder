<?php
require_once "./../config/database.php";
class AuthModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }
    // Kiểm tra username đã tồn tại
        private function checkUsername($username)
        {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
            $stmt->execute([$username]);
            return $stmt->fetchColumn() > 0;
        }
    // Phương thức đăng nhập
   
    public function loginModel( $username, $password)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM users WHERE username = ? AND password = ?"
        );
        $stmt->execute([ $username, $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Phương thức đăng ký
    public function registerModel($fullname, $username, $password, $email)
    {
        // Kiểm tra username đã tồn tại chưa
        if ($this->checkUsername($username)) {
            return false;
        }
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (fullname, username, password, email, role)
            VALUES (?, ?, ?, ?, 'tenant')"
        );
        return $stmt->execute([$fullname, $username, $password, $email]);
    }

}