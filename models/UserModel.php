<?php
require_once("../config/database.php");

class userModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    // Phương thức hiển thị danh sách sản phẩm
    public function getAll()
    {
        return $this->pdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
    // Kiểm tra username đã tồn tại
    private function checkUsername($username, $excludeId = null)
    {
        $query = "SELECT COUNT(*) FROM users WHERE username = ?";
        $params = [$username];

        if ($excludeId !== null) {
            $query .= " AND id <> ?";
            $params[] = $excludeId;
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function isUsernameTaken($username, $excludeId = null)
    {
        return $this->checkUsername($username, $excludeId);
    }
    // Phương thức thêm mới form user
    public function add($fullname, $username, $password, $phone, $email, $role)
    {
        // Kiểm tra username đã tồn tại chưa
        if ($this->checkUsername($username)) {
            return false;
        }
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (fullname, username, password, phone, email, role) 
            VALUES (?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$fullname, $username, $password, $phone, $email, $role]);
    }

    //Phương thức lấy dữ liệu 1 user
    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật dữ liệu
    public function update($id, $fullname,$username, $password, $phone, $email, $role)
    {
        // Kiểm tra username đã tồn tại chưa (trừ user hiện tại)
        if ($this->checkUsername($username, $id)) {
            return false;
        }
        $stmt = $this->pdo->prepare("UPDATE users SET fullname=?, username=?,  password=?,phone=?, email=?, role=? WHERE id=?");
        return $stmt->execute([$fullname, $username, $password, $phone, $email, $role, $id]);
    }

    public function updateProfile($id, $fullname, $username,$phone, $email,  $password = null)
    {
        if ($this->checkUsername($username, $id)) {
            return false;
        }
        $query = "UPDATE users SET fullname = ?, username = ?, phone = ?,email = ?";
        $params = [$fullname, $username, $email, $phone];
        
        if ($password !== null) {
            $query .= ", password = ?";
            $params[] = $password;
        }
        $query .= " WHERE id = ?";
        $params[] = $id;

        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($params);
    }
    
    //Phương thức Xóa
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id=?");
        return $stmt->execute([$id]);
    }

}
