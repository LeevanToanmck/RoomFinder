<?php
require_once "./../config/database.php";

class PostModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function getAll()
{
    return $this->pdo->query(
        "SELECT p.*, t.name AS type_name
         FROM posts p
         JOIN post_types t ON t.id = p.type_id
         ORDER BY p.created_at DESC"
    )->fetchAll(PDO::FETCH_ASSOC);
}


    public function search($q)
    {
        $qLike = '%' . $q . '%';
        $stmt = $this->pdo->prepare(
            "SELECT p.*, t.name AS type_name
             FROM posts p
             JOIN post_types t ON t.id = p.type_id
             WHERE p.title LIKE ? OR p.address LIKE ? OR p.city LIKE ? OR p.district LIKE ?
             ORDER BY p.created_at DESC"
        );
        $stmt->execute([$qLike, $qLike, $qLike, $qLike]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($user_id, $type_id, $title, $description, $price, $area, $address, $city, $district, $status)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO posts (user_id, type_id, title, description, price, area, address, city, district, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        return $stmt->execute([$user_id, $type_id, $title, $description, $price, $area, $address, $city, $district, $status]);
    }

    public function lastInsertId()
    {
        return (int)$this->pdo->lastInsertId();
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare(
            "SELECT p.*,
                    u.username AS owner_username,
                    u.fullname AS owner_fullname,
                    u.phone AS owner_phone,
                    u.email AS owner_email
                    ,t.name AS type_name
             FROM posts p
             JOIN users u ON u.id = p.user_id
             JOIN post_types t ON t.id = p.type_id
             WHERE p.id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $user_id, $type_id, $title, $description, $price, $area, $address, $city, $district, $status)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE posts
             SET user_id = ?, type_id = ?, title = ?, description = ?, price = ?, area = ?, address = ?, city = ?, district = ?, status = ?
             WHERE id = ?"
        );

        return $stmt->execute([$user_id, $type_id, $title, $description, $price, $area, $address, $city, $district, $status, $id]);
    }

    public function delete($id)
    {
        return $this->pdo->prepare("DELETE FROM posts WHERE id = ?")->execute([$id]);
    }
}

