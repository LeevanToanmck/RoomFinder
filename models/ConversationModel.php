<?php
require_once "./../config/database.php";

class ConversationModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function findBetweenUsers($userA, $userB)
    {
        $stmt = $this->pdo->prepare(
            "SELECT cu.conversation_id
             FROM conversation_users cu
             WHERE cu.user_id IN (?, ?)
             GROUP BY cu.conversation_id
             HAVING COUNT(DISTINCT cu.user_id) = 2
             LIMIT 1"
        );
        $stmt->execute([$userA, $userB]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['conversation_id'] : null;
    }

    public function create($userA, $userB)
    {
        $this->pdo->beginTransaction();
        try {
            $this->pdo->exec("INSERT INTO conversations () VALUES ()");
            $conversationId = (int)$this->pdo->lastInsertId();

            $stmt = $this->pdo->prepare("INSERT INTO conversation_users (conversation_id, user_id) VALUES (?, ?)");
            $stmt->execute([$conversationId, $userA]);
            $stmt->execute([$conversationId, $userB]);

            $this->pdo->commit();
            return $conversationId;
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function findOrCreateBetweenUsers($userA, $userB)
    {
        $existing = $this->findBetweenUsers($userA, $userB);
        if ($existing) {
            return $existing;
        }
        return $this->create($userA, $userB);
    }

    public function getForUser($userId)
    {
        $stmt = $this->pdo->prepare(
            "SELECT c.id,
                    MAX(m.created_at) AS last_message_at,
                    (SELECT m2.content FROM messages m2 WHERE m2.conversation_id = c.id ORDER BY m2.created_at DESC, m2.id DESC LIMIT 1) AS last_message,
                    (SELECT u.username
                     FROM conversation_users cu2
                     JOIN users u ON u.id = cu2.user_id
                     WHERE cu2.conversation_id = c.id AND cu2.user_id <> ?
                     LIMIT 1) AS with_username,
                    (SELECT u.id
                     FROM conversation_users cu2
                     JOIN users u ON u.id = cu2.user_id
                     WHERE cu2.conversation_id = c.id AND cu2.user_id <> ?
                     LIMIT 1) AS with_user_id
             FROM conversations c
             JOIN conversation_users cu ON cu.conversation_id = c.id
             LEFT JOIN messages m ON m.conversation_id = c.id
             WHERE cu.user_id = ?
             GROUP BY c.id
             ORDER BY last_message_at DESC, c.id DESC"
        );
        $stmt->execute([$userId, $userId, $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function userInConversation($conversationId, $userId)
    {
        $stmt = $this->pdo->prepare("SELECT 1 FROM conversation_users WHERE conversation_id = ? AND user_id = ? LIMIT 1");
        $stmt->execute([$conversationId, $userId]);
        return (bool)$stmt->fetchColumn();
    }
}

