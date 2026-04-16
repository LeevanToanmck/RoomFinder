<?php
ob_start();
?>

<link rel="stylesheet" href="./../public/css/posts.css">

<div class="posts-page">
    <div class="posts-header">
        <h2>Danh sách bài đăng</h2>
    </div>

    <div class="posts-grid">
        <?php foreach ($posts as $p): ?>
            <?php
            $imgModel = new ImageModel();
            $first = $imgModel->getFirstByPostId($p['id']);
            $thumb = $first ? "./../public/" . $first['image_url'] : "./../public/image/banner (2).png";
            ?>
            <a class="post-card" href="./client.php?controller=client&action=detail&id=<?php echo $p['id']; ?>">
                <div class="post-thumb">
                    <img src="<?php echo htmlspecialchars($thumb); ?>" alt="">
                </div>
                <div class="post-body">
                    <h3><?php echo htmlspecialchars($p['title'] ?? ''); ?></h3>
                    <div class="post-meta">
                        <span><?php echo htmlspecialchars($p['city'] ?? ''); ?><?php echo ($p['district'] ?? '') ? ' - ' . htmlspecialchars($p['district']) : ''; ?></span>
                        <span class="post-status"><?php echo htmlspecialchars($p['type_name'] ?? ''); ?></span>
                    </div>
                    <div class="post-meta" style="margin-top:-6px;">
                        <span><?php echo htmlspecialchars($p['status'] ?? ''); ?></span>
                    </div>
                    <div class="post-price">
                        <?php echo number_format((float)($p['price'] ?? 0)); ?> VNĐ / tháng
                    </div>
                    <div class="post-area">
                        <?php echo htmlspecialchars($p['area'] ?? ''); ?> m² • <?php echo htmlspecialchars($p['address'] ?? ''); ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include "./../views/client/layout.php";
?>

