<?php
ob_start();
?>

<link rel="stylesheet" href="./../public/css/posts.css">
<link rel="stylesheet" href="./../public/css/messages.css">

<div class="post-detail">
    <div class="post-detail-header">
        <a class="back-link" href="./client.php?controller=client&action=index">← Quay lại</a>
        <h2><?php echo htmlspecialchars($post['title'] ?? ''); ?></h2>
        <div class="post-detail-meta">
            <span><?php echo htmlspecialchars($post['city'] ?? ''); ?><?php echo ($post['district'] ?? '') ? ' - ' . htmlspecialchars($post['district']) : ''; ?></span>
            <span class="post-status"><?php echo htmlspecialchars($post['type_name'] ?? ''); ?></span>
        </div>
        <div class="post-detail-meta" style="margin-top:-10px;">
            <span></span>
            <span class="post-status"><?php echo htmlspecialchars($post['status'] ?? ''); ?></span>
        </div>
    </div>

    <div class="post-detail-grid">
        <div class="post-gallery">
            <?php if (!empty($images)): ?>
                <div class="gallery-grid">
                    <?php foreach ($images as $img): ?>
                        <img src="./../public/<?php echo htmlspecialchars($img['image_url']); ?>" alt="">
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-images">Bài đăng chưa có hình ảnh.</div>
            <?php endif; ?>
        </div>

        <div class="post-info">
            <div class="info-block">
                <?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
                <div style="margin-bottom:10px;">
                    <div class="label">Người đăng</div>
                    <div class="value">
                        <?php echo htmlspecialchars(($post['owner_fullname'] ?? '') !== '' ? $post['owner_fullname'] : ($post['owner_username'] ?? '')); ?>
                        <?php if (!empty($post['owner_username'])): ?>
                            <span style="opacity:.75;">(@<?php echo htmlspecialchars($post['owner_username']); ?>)</span>
                        <?php endif; ?>
                        <?php if (!empty($post['owner_phone'])): ?>
                            <div style="opacity:.85; margin-top:4px;">SĐT: <?php echo htmlspecialchars($post['owner_phone']); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] !== (int)$post['user_id']): ?>
                    <a class="btn-primary" href="./client.php?controller=message&action=start&post_id=<?php echo (int)$post['id']; ?>">Nhắn tin chủ bài</a>
                <?php elseif (!isset($_SESSION['user_id'])): ?>
                    <a class="btn-primary" href="./client.php?controller=auth&action=login">Đăng nhập để nhắn tin</a>
                <?php endif; ?>
            </div>
            <div class="info-block price">
                <div class="label">Giá</div>
                <div class="value"><?php echo number_format((float)($post['price'] ?? 0)); ?> VNĐ / tháng</div>
            </div>
            <div class="info-block">
                <div class="label">Diện tích</div>
                <div class="value"><?php echo htmlspecialchars($post['area'] ?? ''); ?> m²</div>
            </div>
            <div class="info-block">
                <div class="label">Địa chỉ</div>
                <div class="value"><?php echo htmlspecialchars($post['address'] ?? ''); ?></div>
            </div>
            <div class="info-block">
                <div class="label">Mô tả</div>
                <div class="value"><?php echo nl2br(htmlspecialchars($post['description'] ?? '')); ?></div>
            </div>
        </div>
    </div>

    <div class="post-comments">
        <h3>Bình luận</h3>

        <?php if (isset($_SESSION['user_id'])): ?>
            <form class="comment-form" action="./client.php?controller=comment&action=store" method="post">
                <input type="hidden" name="post_id" value="<?php echo (int)$post['id']; ?>">
                <textarea name="content" rows="3" placeholder="Viết bình luận..." required></textarea>
                <button type="submit" class="btn-primary">Gửi bình luận</button>
            </form>
        <?php else: ?>
            <p><a href="./client.php?controller=auth&action=login">Đăng nhập</a> để bình luận.</p>
        <?php endif; ?>

        <div class="comment-list">
            <?php if (empty($comments)): ?>
                <p>Chưa có bình luận nào.</p>
            <?php else: ?>
                <?php foreach ($comments as $c): ?>
                    <div class="comment-item">
                        <div class="comment-head">
                            <strong><?php echo htmlspecialchars($c['username'] ?? ''); ?></strong>
                            <span class="comment-time"><?php echo htmlspecialchars($c['created_at'] ?? ''); ?></span>
                        </div>
                        <div class="comment-body"><?php echo nl2br(htmlspecialchars($c['content'] ?? '')); ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include "./../views/client/layout.php";
?>

