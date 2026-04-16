<?php
require_once "./../config/database.php";

class CartModel
{

    private $pdo;
    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    // Kiểm tra sản phẩm đã có trong giỏ hàng chưa  
    public function checkProductInCart($makh, $masp)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM giohang WHERE makh = ? AND masp = ?");
        $stmt->execute([$makh, $masp]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($makh, $masp, $soluong)
    {
        $stmt = $this->pdo->prepare("INSERT INTO giohang (makh, masp, soluong) VALUES (?, ?, ?)");
        return $stmt->execute([$makh, $masp, $soluong]);
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCartQuantity($makh, $masp, $soluong)
    {
        $stmt = $this->pdo->prepare("UPDATE giohang SET soluong = ? WHERE makh = ? AND masp = ?");
        return $stmt->execute([$soluong, $makh, $masp]);
    }


    // Lấy tất cả sản phẩm trong giỏ hàng
    public function getCartSanPham($makh)
    {
        $stmt = $this->pdo->prepare("
            SELECT g.*, s.*, (s.giasp * g.soluong) as tongtien 
            FROM giohang g
            JOIN sanpham s ON g.masp = s.masp 
            WHERE g.makh = ?
        ");
        $stmt->execute([$makh]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tính tổng tiền giỏ hàng
    public function getCartTongTienGioHang($makh)
    {
        $stmt = $this->pdo->prepare("
            SELECT SUM(s.giasp * g.soluong) as tongtiengh 
            FROM giohang g
            JOIN sanpham s ON g.masp = s.masp 
            WHERE g.makh = ?
        ");
        
        $stmt->execute([$makh]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['tongtiengh'] ;
    }
        // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($makh, $masp)
    {
        $stmt = $this->pdo->prepare("DELETE FROM giohang WHERE makh = ? AND masp = ?");
        return $stmt->execute([$makh, $masp]);
    }
}
?> 