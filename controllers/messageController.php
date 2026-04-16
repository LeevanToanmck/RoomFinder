<?php
require_once "./../models/ConversationModel.php";
require_once "./../models/MessageModel.php";
require_once "./../models/PostModel.php";

class messageController
{
    private $conversationModel;
    private $messageModel;
    private $postModel;

    public function __construct()
    {
        $this->conversationModel = new ConversationModel();
        $this->messageModel = new MessageModel();
        $this->postModel = new PostModel();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function ensureAuthenticated()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ./client.php?controller=auth&action=login");
            exit();
        }
    }

    public function inbox()
    {
        $this->ensureAuthenticated();
        $conversations = $this->conversationModel->getForUser((int)$_SESSION['user_id']);
        include "./../views/client/messages/inbox.php";
    }

    public function start()
    {
        $this->ensureAuthenticated();
        $postId = (int)($_GET['post_id'] ?? 0);
        if ($postId <= 0) {
            header("Location: ./client.php?controller=client&action=index");
            exit();
        }

        $post = $this->postModel->findById($postId);
        if (!$post) {
            header("Location: ./client.php?controller=client&action=index");
            exit();
        }

        $me = (int)$_SESSION['user_id'];
        $owner = (int)$post['user_id'];
        if ($owner <= 0 || $owner === $me) {
            header("Location: ./client.php?controller=client&action=detail&id=" . $postId);
            exit();
        }

        $conversationId = $this->conversationModel->findOrCreateBetweenUsers($me, $owner);
        header("Location: ./client.php?controller=message&action=chat&id=" . $conversationId);
        exit();
    }

    public function chat()
    {
        $this->ensureAuthenticated();
        $conversationId = (int)($_GET['id'] ?? 0);
        if ($conversationId <= 0) {
            header("Location: ./client.php?controller=message&action=inbox");
            exit();
        }
        $me = (int)$_SESSION['user_id'];
        if (!$this->conversationModel->userInConversation($conversationId, $me)) {
            header("Location: ./client.php?controller=message&action=inbox");
            exit();
        }

        $messages = $this->messageModel->getByConversationId($conversationId);
        include "./../views/client/messages/chat.php";
    }

    public function send()
    {
        $this->ensureAuthenticated();
        $conversationId = (int)($_POST['conversation_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');
        if ($conversationId <= 0 || $content === '') {
            header("Location: ./client.php?controller=message&action=inbox");
            exit();
        }
        $me = (int)$_SESSION['user_id'];
        if (!$this->conversationModel->userInConversation($conversationId, $me)) {
            header("Location: ./client.php?controller=message&action=inbox");
            exit();
        }
        $this->messageModel->add($conversationId, $me, $content);
        header("Location: ./client.php?controller=message&action=chat&id=" . $conversationId);
        exit();
    }
}

