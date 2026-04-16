<?php
require_once "./../models/PostModel.php";
require_once "./../models/ImageModel.php";
require_once "./../models/CommentModel.php";
class clientController
{
    private $postModel;
    private $imageModel;
    private $commentModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->imageModel = new ImageModel();
        $this->commentModel = new CommentModel();
    }

    public function index()
    {
        $posts = $this->postModel->getAll();
        include "./../views/client/posts/index.php";
    }

    public function search()
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $posts = [];
        if ($search !== '') {
            $posts = $this->postModel->search($search);
        }
        include "./../views/client/posts/search.php";
    }

    public function detail()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            header("Location: ./client.php?controller=client&action=index");
            return;
        }
        $post = $this->postModel->findById($id);
        if (!$post) {
            header("Location: ./client.php?controller=client&action=index");
            return;
        }
        $images = $this->imageModel->getByPostId($id);
        $comments = $this->commentModel->getByPostId($id);
        include "./../views/client/posts/detail.php";
    }
}
