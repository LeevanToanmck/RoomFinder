<?php
require_once "./../models/CommentModel.php";

class commentController
{
    private $model;

    public function __construct()
    {
        $this->model = new CommentModel();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function store()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ./client.php?controller=auth&action=login");
            exit();
        }

        $post_id = (int)($_POST['post_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');
        if ($post_id <= 0 || $content === '') {
            header("Location: ./client.php?controller=client&action=index");
            exit();
        }

        $this->model->add($post_id, (int)$_SESSION['user_id'], $content);
        header("Location: ./client.php?controller=client&action=detail&id=" . $post_id);
        exit();
    }
}

