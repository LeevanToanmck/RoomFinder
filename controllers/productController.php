<?php
require_once "./../models/ProductModel.php";

class productController
{
    // Khởi tạo thuộc tính $model
    private $model;


    public function __construct()
    {
        // kết nối $model từ ProductModel
        $this->model = new ProductModel();
    }

    // hiên thị danh sách sản phẩm
    public function index()
    {
        $sanpham = $this->model->getAll();
        include "./../views/admin/product/list.php";
    }

    // Form thêm mới sản phẩm
    public function add()
    {
        include "./../views/admin/product/add.php";
    }

    // Cập nhật thêm mới sản phẩm
    public function store()
    {

        $tensp = $_POST['tensp'];
        $loaisp = $_POST['id_loaisp'];
        $giasp = $_POST['giasp'];
        $baohanh = $_POST['baohanh'];
        $soluongsp = $_POST['soluongsp'];
        $hinhanhsp = '';
        if (isset($_FILES['hinhanhsp'])) {
            $hinhanhsp_tmp_name = $_FILES['hinhanhsp']['tmp_name'];
            $hinhanhsp_name = $_FILES['hinhanhsp']['name'];
            if (move_uploaded_file($hinhanhsp_tmp_name, './../public/image/' . $hinhanhsp_name)) {
                $hinhanhsp = 'image/' . $hinhanhsp_name;
            }
        }
        $this->model->add($tensp, $hinhanhsp, $loaisp, $giasp, $baohanh, $soluongsp);
        header("Location: ./admin.php?controller=product&action=index");
    }


    // Chỉnh sửa sản phẩm
    public function edit()
    {
        $sanpham = $this->model->findById($_GET['id']);
        include "./../views/admin/product/edit.php";
    }

    // Cập nhật dữ liệu sản phẩm
    public function update()
    {
        $tensp = $_POST['tensp'];
        $giasp = $_POST['giasp'];
        $baohanh = $_POST['baohanh'];
        $soluongsp = $_POST['soluongsp'];
        $loaisp = $_POST['loaisp'];
        $id = $_POST['id'];
        if (isset($_FILES['hinhanhsp']) && $_FILES['hinhanhsp']['error'] == 0) {
            $hinhanhsp_tmp_name = $_FILES['hinhanhsp']['tmp_name'];
            $hinhanhsp_name = $_FILES['hinhanhsp']['name'];
            if (move_uploaded_file($hinhanhsp_tmp_name, './../public/image/' . $hinhanhsp_name)) {
                $hinhanhsp = 'image/' . $hinhanhsp_name;
            }
        } 
        else { 
            $sp = $this->model->findById($id);
            $hinhanhsp = $sp['hinhanhsp'];
        }
        $this->model->update($tensp, $giasp, $baohanh, $soluongsp, $hinhanhsp, $loaisp, $id);
        header("Location: ./admin.php?controller=product&action=index");
    }



    // Xóa dữ liệu sản phẩm
    public function delete()
    {
        $this->model->delete($_GET['id']);
        header("Location: ./admin.php?controller=product&action=index");
    }
}
