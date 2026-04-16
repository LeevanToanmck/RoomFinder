<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/login.css">
    <title>Đăng ký</title>
</head>
<body>
    <div class="registerForm">
        <h2>Đăng ký tài khoản</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form action="index.php?controller=auth&action=register" method="post">
           <div class="inputField">
                <input type="text" id="fullname" name="fullname" placeholder=" " required>
                <label for="fullname">Họ và tên</label>
            </div> 
            <div class="inputField">
                <input type="text" id="username" name="username" placeholder=" " required>
                <label for="username">Tên đăng nhập</label>
            </div>
            <div class="inputField">
                <input type="email" id="email" name="email" placeholder=" " required>
                <label for="email">Email</label>
            </div>
            <div class="inputField">
                <input type="password" id="password" name="password" placeholder=" " required>
                <label for="password">Mật khẩu</label>
            </div>
            <div class="inputField">
                <input type="password" id="confirm_password" name="confirm_password" placeholder=" " required>
                <label for="confirm_password">Xác nhận mật khẩu</label>
            </div>
            <button type="submit" name="dangky">Đăng ký</button>
            <div class="link">
                <p>Đã có tài khoản? <a href="index.php?controller=auth&action=login">Đăng nhập</a></p>
            </div>
        </form>
    </div>
</body>
</html>
