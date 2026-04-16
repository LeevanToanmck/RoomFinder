<?php
ob_start();
require_once "./../models/UserModel.php";
if (!isset($_SESSION)) {
    session_start();
}
$userModel = new UserModel();
$user = $userModel->findById($_SESSION['user_id']);
?>
<title>Thanh toán</title>
<link rel="stylesheet" href="./../public/css/checkout.css">
</head>
<body>
    <div class="checkout-container">
        <div class="checkout-header">
            <h1>Thanh toán đơn hàng</h1>
            <a href="./client.php?controller=cart&action=index" class="btn-back">← Quay lại giỏ hàng</a>
        </div>

        <div class="checkout-content">
            <div class="checkout-form-section">
                <h2>Thông tin giao hàng</h2>
                <form action="./client.php?controller=order&action=processPayment" method="post" class="checkout-form">
                    <div class="form-group">
                        <label for="hoten">Họ và tên *</label>
                        <input type="text" id="hoten" name="hoten" value="<?php echo htmlspecialchars($user['fullname'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="sdt">Số điện thoại *</label>
                        <input type="text" id="sdt" name="sdt" value="<?php echo htmlspecialchars($user['sdt'] ?? ''); ?>" required placeholder="Ví dụ: 0912345678">
                    </div>

                    <div class="form-group">
                        <label for="diachi">Địa chỉ giao hàng *</label>
                        <textarea id="diachi" name="diachi" rows="3" required placeholder="Nhập địa chỉ chi tiết..."><?php echo htmlspecialchars($user['diachi'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="phuongthucthanhtoan">Phương thức thanh toán *</label>
                        <select id="phuongthucthanhtoan" name="phuongthucthanhtoan" required>
                            <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                            <option value="banking">Chuyển khoản ngân hàng</option>
                            <option value="momo">Ví điện tử MoMo</option>
                            <option value="zalopay">Ví điện tử ZaloPay</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">Xác nhận đặt hàng</button>
                        <a href="./client.php?controller=cart&action=index" class="btn-cancel">Hủy</a>
                    </div>
                </form>
            </div>

            <div class="checkout-summary-section">
                <h2>Đơn hàng của bạn</h2>
                <div class="order-summary">
                    <?php foreach ($cart_items as $item): ?>
                        <div class="summary-item">
                            <img src="<?php echo $item['hinhanhsp']; ?>" alt="<?php echo htmlspecialchars($item['tensp']); ?>">
                            <div class="summary-item-info">
                                <h4><?php echo htmlspecialchars($item['tensp']); ?></h4>
                                <p>Số lượng: <?php echo $item['soluong']; ?></p>
                                <p class="item-price"><?php echo number_format($item['tongtien']); ?> VNĐ</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="summary-total">
                        <div class="total-row">
                            <span>Tạm tính:</span>
                            <span><?php echo number_format($total); ?> VNĐ</span>
                        </div>
                        <div class="total-row">
                            <span>Phí vận chuyển:</span>
                            <span>Miễn phí</span>
                        </div>
                        <div class="total-row final-total">
                            <span>Tổng cộng:</span>
                            <strong><?php echo number_format($total); ?> VNĐ</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$content = ob_get_clean();
include "./../views/client/layout.php";
?>

