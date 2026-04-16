<?php
require_once "./../config/database.php";

class MessageModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function getByConversationId($conversationId)
    {
        $stmt = $this->pdo->prepare(
            "SELECT m.*, u.username
             FROM messages m
             JOIN users u ON u.id = m.sender_id
             WHERE m.conversation_id = ?
             ORDER BY m.created_at ASC, m.id ASC"
        );
        $stmt->execute([$conversationId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($conversationId, $senderId, $content)
    {
        $stmt = $this->pdo->prepare("INSERT INTO messages (conversation_id, sender_id, content) VALUES (?, ?, ?)");
        return $stmt->execute([$conversationId, $senderId, $content]);
    }
}

