<?php
ob_start();
?>
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="./../public/css/cart.css">
</head>
<body>     
        <div class="cart-container">
            <div class="cart-header">
                <h1>Giỏ hàng của bạn</h1>
                <br>    
                <div class="cart-header-buttons">
                    <a href="./client.php?controller=client&action=index" class="btn-back">← Tiếp tục mua sắm</a>
                    <a href="./client.php?controller=order&action=history" class="btn-view-orders">Xem đơn hàng</a>
                </div>
            </div>
            
            <?php if (empty($cart_items)): ?>
                <div class="empty-cart">
                    <p>Giỏ hàng của bạn đang trống.</p>
                    <a href="./client.php?controller=client&action=findCategory&loaisp=ALL">Tiếp tục mua sắm</a>
                </div>
            <?php else: ?>
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item">
                        <img src="<?php echo $item['hinhanhsp']; ?>" alt="<?php echo $item['tensp']; ?>">
                        <div class="cart-item-details">
                            <h3><?php echo $item['tensp']; ?></h3>
                            <p class="cart-item-price"><?php echo number_format($item['giasp']); ?> VNĐ</p>
                            <div class="cart-item-quantity">
                                <form action="./client.php?controller=cart&action=updateQuantity" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $item['masp']; ?>">
                                    <label>Số lượng:</label>
                                    <input type="number" name="quantity" value="<?php echo $item['soluong']; ?>">
                                    <button type="submit" name="update_quantity">Cập nhật</button>
                                </form>
                                <a href="./client.php?controller=cart&action=removeFromCart&remove=<?php echo $item['masp']; ?>" 
                                   class="remove-btn" 
                                   onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                    Xóa
                                </a>
                            </div>
                            <p class="subtotal">Tổng: <?php echo number_format($item['tongtien']); ?> VNĐ</p>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div class="cart-total">
                    <p>Tổng cộng: <strong><?php echo number_format($total); ?> VNĐ</strong></p>
                    <div class="cart-action-buttons">
                        <a class="checkout-btn" href="./client.php?controller=order&action=checkout">Thanh toán</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
</body>
</html>
<?php
$content = ob_get_clean();
include "./../views/client/layout.php";
?> 