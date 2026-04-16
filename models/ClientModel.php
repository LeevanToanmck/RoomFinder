<?php
require_once "./../config/database.php";

class ClientModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }
    // Phương thức hiển thị danh sách sản phẩm
    // public function getAll()
    // {
    //     return $this->pdo->query(
    //         "SELECT * FROM sanpham" 
    //     )->fetchAll(PDO::FETCH_ASSOC);
    // }
    // public function getByCategory($loaisp)
    // {
    //     $stmt = $this->pdo->prepare("SELECT * FROM sanpham WHERE loaisp = ?");
    //     $stmt->execute([$loaisp]);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
    // public function search($search)
    // {
    //     return $this->pdo->query("SELECT * FROM sanpham WHERE tensp LIKE '%$search%'")
    //     ->fetchAll(PDO::FETCH_ASSOC);
    // }

    // // Lấy chi tiết sản phẩm theo mã sản phẩm
    // public function findById($id)
    // {
    //     $stmt = $this->pdo->prepare("SELECT * FROM sanpham WHERE masp = ?");
    //     $stmt->execute([$id]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }

}   