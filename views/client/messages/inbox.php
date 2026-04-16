<?php
ob_start();
?>

<link rel="stylesheet" href="./../public/css/messages.css">

<div class="messages-page">
    <div class="messages-header">
        <h2>Tin nhắn</h2>
    </div>

    <?php if (empty($conversations)): ?>
        <div class="empty-state">Bạn chưa có cuộc trò chuyện nào.</div>
    <?php else: ?>
        <div class="conversation-list">
            <?php foreach ($conversations as $c): ?>
                <a class="conversation-item" href="./client.php?controller=message&action=chat&id=<?php echo (int)$c['id']; ?>">
                    <div class="conversation-title">
                        <strong><?php echo htmlspecialchars($c['with_username'] ?? ''); ?></strong>
                        <span class="conversation-time"><?php echo htmlspecialchars($c['last_message_at'] ?? ''); ?></span>
                    </div>
                    <div class="conversation-preview">
                        <?php echo htmlspecialchars($c['last_message'] ?? ''); ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include "./../views/client/layout.php";
?>

