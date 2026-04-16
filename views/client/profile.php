<?php
ob_start();
?>
<link rel="stylesheet" href="./../public/css/profile.css">

<div class="profile-page">
    <div class="profile-card">
        <div class="profile-header">
            <h1>Thông tin tài khoản</h1>
            <p>Cập nhật thông tin cá nhân và bảo mật của bạn.</p>
        </div>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="./client.php?controller=profile&action=edit" method="post" class="profile-form">
            <div class="form-row">
                <div class="form-field">
                    <label for="fullname">Họ và tên</label>
                    <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($formData['fullname'] ?? ''); ?>" required>
                </div>
                <div class="form-field">
                    <label for="username">Tên đăng nhập</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($formData['username'] ?? ''); ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>" required>
                </div>
                <div class="form-field">
                    <label for="sdt">Số điện thoại</label>
                    <input type="text" id="sdt" name="sdt" value="<?php echo htmlspecialchars($formData['sdt'] ?? ''); ?>" placeholder="Ví dụ: 0912345678">
                </div>
            </div>

            <div class="form-row">
                        
                <div class="form-field">
                    <label for="password">Mật khẩu mới (Nếu muốn đổi mật khẩu)</label>
                    <input type="password" id="password" name="password" placeholder="Để trống nếu không đổi">
                </div>
                <div class="form-field">
                    <label for="confirm_password">Xác nhận mật khẩu mới (Nếu muốn đổi mật khẩu) </label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu mới">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Lưu thay đổi</button>
                <a href="./client.php" class="btn-secondary">Quay lại trang chủ</a>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include "./../views/client/layout.php";
?>
