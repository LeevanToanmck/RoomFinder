<?php
require_once "./../models/CartModel.php";
require_once "./../models/ProductModel.php";

class cartController
{
    private $model;
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    // Hiển thị giỏ hàng
    public function index()
    {
            session_start();
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('Vui lòng đăng nhập để xem giỏ hàng!'); window.location.href='./client.php?controller=auth&action=login';</script>";
            exit();
        }
        $makh = $_SESSION['user_id'];
        $cart_items = $this->model->getCartSanPham($makh);
        $total = $this->model->getCartTongTienGioHang($makh);
        include "./../views/client/cart.php";
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart()
    {
        session_start();
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('Vui lòng đăng nhập để thêm vào giỏ hàng!'); window.location.href='./client.php?controller=auth&action=login';</script>";
            exit();
        }
        // Kiểm tra phương thức POST và tồn tại tham số add_to_cart
        if (isset($_POST['add_to_cart'])) {
            $makh = $_SESSION['user_id'];
            $masp = $_POST['product_id'];
            $soluong = 1;
            
            // Kiểm tra số lượng sản phẩm còn lại
            $product = $this->productModel->findById($masp);
            if (!$product || (int)$product['soluongsp'] <= 0) {
                echo "<script>alert('Sản phẩm đã hết hàng!'); window.location.href='./client.php?controller=client&action=index';</script>";
                exit();
            }
            
            // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $checkcart = $this->model->checkProductInCart($makh, $masp);
            if ($checkcart) {
                // Kiểm tra tổng số lượng trong giỏ + số lượng muốn thêm có vượt quá số lượng còn lại không
                $totalInCart = (int)$checkcart['soluong'] + $soluong;
                if ($totalInCart > (int)$product['soluongsp']) {
                    echo "<script>alert('Số lượng sản phẩm không đủ! Số lượng còn lại: " . $product['soluongsp'] . "'); window.location.href='./client.php?controller=cart&action=index';</script>";
                    exit();
                }
                $this->model->updateCartQuantity($makh, $masp, $totalInCart);
            } else {
                // Thêm mới vào giỏ hàng
                $this->model->addToCart($makh, $masp, $soluong);
            }
            
            header('Location: ./client.php?controller=cart&action=index');
            exit();
        }
    }

    // Cập nhật số lượng sản phẩm
    public function updateQuantity()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='./client.php?controller=auth&action=login';</script>";
            exit();
        }
        if (isset($_POST['update_quantity']) ) {
            $makh = $_SESSION['user_id'];
            $masp = $_POST['product_id'];
            $soluong = (int)$_POST['quantity'];
            
            if ($soluong > 0) {
                // Kiểm tra số lượng sản phẩm còn lại
                $product = $this->productModel->findById($masp);
                if (!$product || (int)$product['soluongsp'] <= 0) {
                    echo "<script>alert('Sản phẩm đã hết hàng!'); window.location.href='./client.php?controller=cart&action=index';</script>";
                    exit();
                }
                
                // Kiểm tra số lượng cập nhật có vượt quá số lượng còn lại không
                if ($soluong > (int)$product['soluongsp']) {
                    echo "<script>alert('Số lượng không đủ! Số lượng còn lại: " . $product['soluongsp'] . "'); window.location.href='./client.php?controller=cart&action=index';</script>";
                    exit();
                }
                
                $this->model->updateCartQuantity($makh, $masp, $soluong);
            } else {
                $this->model->removeFromCart($makh, $masp);
            }
            
            header('Location: ./client.php?controller=cart&action=index');
            exit();
        }
    }
    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart()
    {
        session_start();
        
        if (isset($_GET['remove'])) {
            $makh = $_SESSION['user_id'];
            $masp = $_GET['remove'];
            $this->model->removeFromCart($makh, $masp);
            header('Location: ./client.php?controller=cart&action=index');
            exit();
        }
    }

}
?>