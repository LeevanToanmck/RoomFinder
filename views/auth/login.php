<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/login.css">
    <title>Đăng nhập</title>
</head>
<body>
    <div class="loginForm">
        <h2>Đăng nhập</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="index.php?controller=auth&action=login" method="post">
            <div class="inputField">
                <input type="text" id="username" name="username" >
                <label for="username">Số điện thoại hoặc tên đăng nhập</label>
            </div>
            <div class="inputField">
                <input type="password" id="password" name="password" >
                <label for="password">Mật khẩu</label>
            </div>
            <button type="submit" name="dangnhap">Đăng nhập</button>
            <div class="link">
                <p><a href="index.php?controller=auth&action=register">Chưa có tài khoản? Đăng ký</a></p>
            </div>
        </form>
    </div>
</body>
</html>