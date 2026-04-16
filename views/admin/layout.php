<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./../public/css/admin.css">
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar bên trái -->
        <div class="sidebar">
        <div class="anh">
        <a href="./admin.php"><img src="./../public/image/logodripped.png" alt=""></a>
        </div>
            <nav>
                <ul>
                    <li>
                        <a href="./admin.php?controller=posts&action=index">Quản lý bài posts</a>
                    </li>
                    <li>
                        <a href="admin.php?controller=user&action=index"> Quản lý người dùng</a>
                    </li>
                    <!-- <li>
                        <a href="./admin.php?controller=category&action=index"> Quản lý danh mục</a> -->
                    <li>
                        <a href="./admin.php?controller=auth&action=logout"> Đăng xuất</a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main content area -->
        <div class="main">
            <div class="content">
            <?php
        if (isset($content) && !empty($content)) {
            echo $content;
        } else {
           echo "<h1>Xin chào ".$_SESSION['username']." đến với trang quản lý"."</h1>";

        }
        ?>
                <?php include './../views/client/include/footer.php'; ?>
            </div>
        </div>
        
    </div>
</body>

</html>