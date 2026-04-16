<?php
require_once "./../models/userModel.php";
session_start();

class profileController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new userModel();
    }

    private function ensureAuthenticated()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ./client.php?controller=auth&action=login");
            exit();
        }
    }

    public function edit()
    {
        $this->ensureAuthenticated();

        $userId = (int) $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);

        if (!$user) {
            header("Location: ./client.php?controller=auth&action=logout");
            exit();
        }

        $errors = [];
        $success = "";
        $formData = [
            'fullname' => $user['fullname'] ?? '',
            'username' => $user['username'] ?? '',
            'email' => $user['email'] ?? '',
            'sdt' => $user['sdt'] ?? '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData['fullname'] = trim($_POST['fullname'] ?? '');
            $formData['username'] = trim($_POST['username'] ?? '');
            $formData['email'] = trim($_POST['email'] ?? '');
            $formData['sdt'] = trim($_POST['sdt'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if ($formData['fullname'] === '') {
                $errors[] = "Vui lòng nhập họ và tên.";
            }

            if ($formData['username'] === '') {
                $errors[] = "Vui lòng nhập tên đăng nhập.";
            } elseif ($this->userModel->isUsernameTaken($formData['username'], $userId)) {
                $errors[] = "Tên đăng nhập đã tồn tại.";
            }

            if ($formData['email'] === '') {
                $errors[] = "Vui lòng nhập email.";
            } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ.";
            }

            if ($formData['sdt'] !== '' && !preg_match('/^[0-9+]{9,15}$/', $formData['sdt'])) {
                $errors[] = "Số điện thoại không hợp lệ.";
            }

            $passwordToSave = null;
            if ($password !== '' || $confirmPassword !== '') {
                if ($password !== $confirmPassword) {
                    $errors[] = "Mật khẩu xác nhận không khớp.";
                } elseif (strlen($password) < 6) {
                    $errors[] = "Mật khẩu phải có ít nhất 6 ký tự.";
                } else {
                    $passwordToSave = $password;
                }
            }

            if (empty($errors)) {
                $updated = $this->userModel->updateProfile(
                    $userId,
                    $formData['fullname'],
                    $formData['username'],
                    $formData['email'],
                    $formData['sdt'],
                    $passwordToSave
                );

                if ($updated) {
                    $success = "Cập nhật thông tin thành công.";
                    $user = $this->userModel->findById($userId);
                    $formData = [
                        'fullname' => $user['fullname'] ?? '',
                        'username' => $user['username'] ?? '',
                        'email' => $user['email'] ?? '',
                        'sdt' => $user['sdt'] ?? '',
                    ];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['sdt'] = $user['sdt'];
                } else {
                    $errors[] = "Không thể cập nhật thông tin. Vui lòng thử lại.";
                }
            }
        }

        include "./../views/client/profile.php";
    }
}
