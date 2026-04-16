<body>

    <form action="./client.php" method="get">
        <input type="hidden" name="controller" value="client">
        <input type="hidden" name="action" value="search">
        <div id="khung">
            <div id="dau">
                <div class="anh"><a href="./client.php?controller=client&action=index"><img
                            src="./../public/image/banner (2).png" alt=""></a></div>
                <div class="menu">
                    <ul class="menu-ul">
                        <li class="menu-li">
                            <a href="./client.php?controller=client&action=index">Trang chủ</a>
                        </li>
                        <li class="menu-li">
                            <a href="./client.php?controller=client&action=index">Bài đăng</a>
                        </li>

                        <li class="menu-li search-form">
                            <input type="text" placeholder="Tìm theo tiêu đề/địa chỉ/thành phố..." name="search"
                                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                            <button type="submit">Search</button>
                        </li>
                        <?php

                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        ?>
                        <?php

                        if (isset($_SESSION['username'])) {
                            if (isset($_SESSION['role']) && ($_SESSION['role'] === 'owner' || $_SESSION['role'] === 'admin')) {
                                echo '<li class="menu-li"><a href="./client.php?controller=ownerPost&action=index">Đăng bài</a></li>';
                            }
                            echo '<li class="menu-li"><a href="./client.php?controller=message&action=inbox">Tin nhắn</a></li>';
                            echo '<li class="menu-li"><a href="./client.php?controller=profile&action=edit">Tài khoản</a></li>';
                            echo '<li class="menu-li"><a href="./client.php?controller=auth&action=logout">Đăng xuất</a></li>';
                        } else {
                            echo '<li class="menu-li"><a href="./client.php?controller=auth&action=login"> Login</a> </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        </div>
    </form>

</body>

</html>