<?php
require_once "./../models/PostModel.php";
require_once "./../models/ImageModel.php";
require_once "./../models/PostTypeModel.php";

class postsController
{
    private $model;
    private $imageModel;
    private $typeModel;

    public function __construct()
    {
        $this->model = new PostModel();
        $this->imageModel = new ImageModel();
        $this->typeModel = new PostTypeModel();
    }

    private function normalizeMultiFiles($files)
    {
        $out = [];
        if (!isset($files['name']) || !is_array($files['name'])) {
            return $out;
        }
        $count = count($files['name']);
        for ($i = 0; $i < $count; $i++) {
            $out[] = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i] ?? null,
                'tmp_name' => $files['tmp_name'][$i] ?? null,
                'error' => $files['error'][$i] ?? UPLOAD_ERR_NO_FILE,
                'size' => $files['size'][$i] ?? 0,
            ];
        }
        return $out;
    }

    private function storeUploadedImagesOrFail($post_id, $minCount = 0)
    {
        $files = isset($_FILES['images']) ? $this->normalizeMultiFiles($_FILES['images']) : [];
        $valid = array_values(array_filter($files, fn($f) => isset($f['error']) && $f['error'] === UPLOAD_ERR_OK));

        if ($minCount > 0 && count($valid) < $minCount) {
            echo "<script>alert('Vui lòng chọn tối thiểu {$minCount} hình ảnh cho bài post!'); window.history.back();</script>";
            exit();
        }

        if (empty($valid)) {
            return;
        }

        foreach ($valid as $f) {
            $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
                echo "<script>alert('File ảnh không hợp lệ: {$f['name']}'); window.history.back();</script>";
                exit();
            }

            $safeName = uniqid('post_', true) . '.' . $ext;
            $destRel = 'image/' . $safeName;
            $destAbs = './../public/' . $destRel;

            if (!move_uploaded_file($f['tmp_name'], $destAbs)) {
                echo "<script>alert('Upload ảnh thất bại!'); window.history.back();</script>";
                exit();
            }

            $this->imageModel->add($post_id, $destRel);
        }
    }

    public function index()
    {
        $posts = $this->model->getAll();
        include "./../views/admin/posts/list.php";
    }

    public function add()
    {
        $types = $this->typeModel->getAll();
        
        include "./../views/admin/posts/add.php";
    }

    public function store()
    {
        $user_id = (int)($_POST['user_id'] ?? 0);
        $type_id = (int)($_POST['type_id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $area = (float)($_POST['area'] ?? 0);
        $address = trim($_POST['address'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $district = trim($_POST['district'] ?? '');
        $status = $_POST['status'] ?? 'available';

        $this->model->add($user_id, $type_id, $title, $description, $price, $area, $address, $city, $district, $status);
        $post_id = $this->model->lastInsertId();

        // yêu cầu nhiều hơn 2 hình => tối thiểu 3 hình khi tạo mới
        $this->storeUploadedImagesOrFail($post_id, 3);
        header("Location: ./admin.php?controller=posts&action=index");
    }

    public function edit()
    {
        $post = $this->model->findById($_GET['id']);
        $images = $this->imageModel->getByPostId($_GET['id']);
        $types = $this->typeModel->getAll();
        include "./../views/admin/posts/edit.php";
    }

    public function update()
    {
        $id = (int)($_POST['id'] ?? 0);
        $user_id = (int)($_POST['user_id'] ?? 0);
        $type_id = (int)($_POST['type_id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $area = (float)($_POST['area'] ?? 0);
        $address = trim($_POST['address'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $district = trim($_POST['district'] ?? '');
        $status = $_POST['status'] ?? 'available';

        $this->model->update($id, $user_id, $type_id, $title, $description, $price, $area, $address, $city, $district, $status);

        // Nếu có upload ảnh mới thì thay toàn bộ ảnh cũ
        $files = isset($_FILES['images']) ? $this->normalizeMultiFiles($_FILES['images']) : [];
        $hasNew = false;
        foreach ($files as $f) {
            if (($f['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
                $hasNew = true;
                break;
            }
        }
        if ($hasNew) {
            $this->imageModel->deleteByPostId($id);
            $this->storeUploadedImagesOrFail($id, 0);
        }

        header("Location: ./admin.php?controller=posts&action=index");
    }

    public function delete()
    {
        $this->model->delete($_GET['id']);
        header("Location: ./admin.php?controller=posts&action=index");
    }
}

