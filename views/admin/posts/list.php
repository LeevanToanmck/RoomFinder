<?php
ob_start();
?>

<div>
    <h2>Danh sách bài posts</h2>
    <a href="./admin.php?controller=posts&action=add" class="ws-btn mb-2">Thêm mới</a>
</div>

<table class="my_table">
    <tr>
        <th>ID</th>
        <th>User ID</th>
        <th>Loại phòng</th>
        <th>Tiêu đề</th>
        <th>Giá</th>
        <th>Diện tích</th>
        <th>Địa chỉ</th>
        <th>Thành phố</th>
        <th>Quận/Huyện</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($posts as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['user_id'] ?></td>
            <td><?= htmlspecialchars($p['type_name'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['title'] ?? '') ?></td>
            <td><?= $p['price'] ?></td>
            <td><?= $p['area'] ?></td>
            <td><?= htmlspecialchars($p['address'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['city'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['district'] ?? '') ?></td>
            <td><?= $p['status'] ?></td>
            <td>
                <a class="ws-btn" href="./admin.php?controller=posts&action=edit&id=<?= $p['id'] ?>">Sửa</a>
                <a class="ws-btn" href="./admin.php?controller=posts&action=delete&id=<?= $p['id'] ?>" onclick="return confirm('Bạn có chắc chắn Xóa?')">Xóa</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php
$content = ob_get_clean();
include './../views/admin/layout.php';
?>

