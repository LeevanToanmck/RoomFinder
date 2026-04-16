<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$me = (int)($_SESSION['user_id'] ?? 0);
?>

<link rel="stylesheet" href="./../public/css/messages.css">

<div class="messages-page">
    <div class="messages-header">
        <a class="back-link" href="./client.php?controller=message&action=inbox">← Hộp thư</a>
        <h2>Trò chuyện</h2>
    </div>

    <div class="chat-box">
        <?php if (empty($messages)): ?>
            <div class="empty-state">Chưa có tin nhắn. Hãy gửi lời chào.</div>
        <?php else: ?>
            <?php foreach ($messages as $m): ?>
                <?php $isMine = (int)$m['sender_id'] === $me; ?>
                <div class="chat-row <?php echo $isMine ? 'mine' : 'theirs'; ?>">
                    <div class="chat-bubble">
                        <div class="chat-meta">
                            <strong><?php echo htmlspecialchars($m['username'] ?? ''); ?></strong>
                            <span><?php echo htmlspecialchars($m['created_at'] ?? ''); ?></span>
                        </div>
                        <div class="chat-content"><?php echo nl2br(htmlspecialchars($m['content'] ?? '')); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <form class="chat-form" action="./client.php?controller=message&action=send" method="post">
        <input type="hidden" name="conversation_id" value="<?php echo (int)($_GET['id'] ?? 0); ?>">
        <input type="text" name="content" placeholder="Nhập tin nhắn..." required>
        <button type="submit" class="btn-primary">Gửi</button>
    </form>
</div>

<?php
$content = ob_get_clean();
include "./../views/client/layout.php";
?>

