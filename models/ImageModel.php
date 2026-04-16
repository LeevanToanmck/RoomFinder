<?php
require_once "./../config/database.php";

class ImageModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function getByPostId($post_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM images WHERE post_id = ? ORDER BY id ASC");
        $stmt->execute([$post_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFirstByPostId($post_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM images WHERE post_id = ? ORDER BY id ASC LIMIT 1");
        $stmt->execute([$post_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($post_id, $image_url)
    {
        $stmt = $this->pdo->prepare("INSERT INTO images (post_id, image_url) VALUES (?, ?)");
        return $stmt->execute([$post_id, $image_url]);
    }

    public function deleteByPostId($post_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM images WHERE post_id = ?");
        return $stmt->execute([$post_id]);
    }
}

