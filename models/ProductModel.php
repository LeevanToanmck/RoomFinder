<?php
require_once "./../config/database.php";

// Khởi tạo đối tượng ProductModel
class ProductModel
{
    // Khởi tạo thuộc tính
    private $pdo;

    // Phướng thức khởi tạo mặc định lúc đầu
    public function __construct()
    {
        $this->pdo = Database::connect();
    }
    // Phương thức hiển thị danh sách sản phẩm

    public function getAll()
    {
        return $this->pdo->query(
            "SELECT * FROM sanpham" 
        )->fetchAll(PDO::FETCH_ASSOC);
    }


    public function add($tensp, $hinhanhsp, $loaisp, $giasp, $baohanh, $soluongsp)
    {
        $stmt = $this->pdo->prepare("INSERT INTO sanpham (tensp, hinhanhsp, loaisp, giasp, baohanh, soluongsp) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$tensp, $hinhanhsp, $loaisp, $giasp, $baohanh, $soluongsp]);
    }

    // Phương thức lấy sản phẩm theo id
    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM sanpham WHERE masp=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Cập nhật dữ liêu
    public function update($tensp, $giasp, $baohanh, $soluongsp, $hinhanhsp, $loaisp, $id)
    {
        $stmt = $this->pdo->prepare("UPDATE sanpham SET tensp=?, giasp=?, baohanh=?, soluongsp=?, hinhanhsp=?, loaisp=? WHERE masp=?");
        return $stmt->execute([$tensp, $giasp, $baohanh, $soluongsp, $hinhanhsp, $loaisp, $id]);

    }
    public function delete($id)
    {
        return $this->pdo->prepare("DELETE FROM sanpham  WHERE masp = ?")->execute([$id]);
    }


}

