<?php
require_once "./../models/userModel.php";

class userController {
    // Khởi tạo thuộc tính $model
    private $model;
    public function __construct() {
        // kết nối $model từ ProductModel
        $this->model = new userModel();
    }

    // hiên thị danh sách sản phẩm
    public function index() {
        $nguoidung = $this->model->getAll();
        include "./../views/admin/user/list.php";
    }

    // form thêm mới người dùng
    public function add() {
        include "./../views/admin/user/add.php";
    }

    // Lưu dữ liệu thêm mới người dùng
    public function store() {
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $phone= $_POST['phone'];
        $email= $_POST['email'];
        $role= $_POST['role'];
        $this->model->add( $fullname, $username, $password, $phone,  $email,  $role);
        header("Location: ./admin.php?controller=user&action=index");
    }
    // Form chỉnh sửa người dùng
    public function edit() {
        $user   = $this->model->findById($_GET['id']);
        include './../views/admin/user/edit.php';
    }
    // Cập nhật dữ liệu người dùng
    public function update() {
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $phone= $_POST['phone'];
        $email= $_POST['email'];
        $role= $_POST['role'];
        $id = $_POST['id'];
        $this->model->update($id, $fullname,$username,  $password,  $phone, $email, $role);
   
        header("Location: ./admin.php?controller=user&action=index");
    }
    // Xóa dữ liệu người dùng
    public function delete() {
        $this->model->delete($_GET['id']);
        header("Location: ./admin.php?controller=user&action=index");
    }
}

