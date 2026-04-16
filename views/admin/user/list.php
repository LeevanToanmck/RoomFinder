<?php
$obstart = ob_start();
?>
<div>
    <h2>Danh sách người dùng</h2>
</div>

<div>
    <a href="./admin.php?controller=user&action=add"
        class="ws-btn mb-2">Thêm mới</a>
</div>
<table class="my_table">
    <tr>
        <th>ID</th>
        <th>Họ tên</th>
        <th>Tài khoản</th>
        <th>Mật khẩu</th>
        <th>Email</th>
        <th>Quyền</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($nguoidung as $nd): ?>
        <tr>
            <td><?= $nd['id'] ?></td>
            <td><?= $nd['fullname'] ?></td>
            <td><?= $nd['username'] ?></td>
            <td><?= $nd['password'] ?></td>
            <td><?= $nd['email'] ?></td>
            <td><?= $nd['role'] ?></td>
            <td>
                <a class="ws-btn"
                    href="./admin.php?controller=user&action=edit&id=<?= $nd['id'] ?>">
                    Sửa</a>
                <a class="ws-btn"
                    href="./admin.php?controller=user&action=delete&id=<?= $nd['id'] ?>"
                    onclick="return confirm('Bạn có chắc chắn Xóa?')">Xóa</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php
$content = ob_get_clean();
include './../views/admin/layout.php';
?>