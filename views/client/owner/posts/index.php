<?php
ob_start();
?>

<link rel="stylesheet" href="./../public/css/posts.css">
<link rel="stylesheet" href="./../public/css/messages.css">

<div class="posts-page">
    <div class="posts-header" style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
        <h2>Bài đăng của tôi</h2>
        <a class="btn-primary" href="./client.php?controller=ownerPost&action=add">Tạo bài đăng</a>
    </div>

    <?php if (empty($posts)): ?>
        <div class="no-results">Bạn chưa có bài đăng nào.</div>
    <?php else: ?>
        <div class="posts-grid">
            <?php foreach ($posts as $p): ?>
                <div class="post-card" style="overflow:hidden;">
                    <a class="post-card" style="border:none; border-radius:0;" href="./client.php?controller=client&action=detail&id=<?php echo (int)$p['id']; ?>">
                        <div class="post-body">
                            <div style="display:flex; justify-content:space-between; gap:10px; align-items:flex-start;">
                                <h3 style="margin:0;"><?php echo htmlspecialchars($p['title'] ?? ''); ?></h3>
                                <span class="post-status"><?php echo htmlspecialchars($p['type_name'] ?? ''); ?></span>
                            </div>
                            <div class="post-meta">
                                <span><?php echo htmlspecialchars($p['city'] ?? ''); ?><?php echo ($p['district'] ?? '') ? ' - ' . htmlspecialchars($p['district']) : ''; ?></span>
                                <span class="post-status"><?php echo htmlspecialchars($p['status'] ?? ''); ?></span>
                            </div>
                            <div class="post-price"><?php echo number_format((float)($p['price'] ?? 0)); ?> VNĐ / tháng</div>
                            <div class="post-area"><?php echo htmlspecialchars($p['area'] ?? ''); ?> m² • <?php echo htmlspecialchars($p['address'] ?? ''); ?></div>
                        </div>
                    </a>
                    <div style="display:flex; gap:10px; padding: 0 12px 14px;">
                        <a class="btn-primary" href="./client.php?controller=ownerPost&action=edit&id=<?php echo (int)$p['id']; ?>">Sửa</a>
                        <a class="btn-primary" href="./client.php?controller=ownerPost&action=delete&id=<?php echo (int)$p['id']; ?>" onclick="return confirm('Xóa bài đăng này?')">Xóa</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include "./../views/client/layout.php";
?>

