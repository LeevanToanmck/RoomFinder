<?php
ob_start();
?>

<link rel="stylesheet" href="./../public/css/messages.css">

<div class="messages-page">
    <div class="messages-header">
        <a class="back-link" href="./client.php?controller=ownerPost&action=index">← Quay lại</a>
        <h2>Tạo bài đăng</h2>
    </div>

    <form class="comment-form" action="./client.php?controller=ownerPost&action=store" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <p>Loại phòng:</p>
            <select name="type_id" required>
                <?php foreach (($types ?? []) as $t): ?>
                    <option value="<?php echo (int)$t['id']; ?>"><?php echo htmlspecialchars($t['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <p>Tiêu đề:</p>
            <input type="text" name="title" required style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:12px;">
        </div>

        <div class="form-group">
            <p>Mô tả:</p>
            <textarea name="description" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <p>Giá (VNĐ/tháng):</p>
            <input type="number" step="0.01" name="price" required style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:12px;">
        </div>

        <div class="form-group">
            <p>Diện tích (m²):</p>
            <input type="number" step="0.01" name="area" required style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:12px;">
        </div>

        <div class="form-group">
            <p>Địa chỉ:</p>
            <input type="text" name="address" required style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:12px;">
        </div>

        <div class="form-group">
            <p>Thành phố:</p>
            <input type="text" name="city" required style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:12px;">
        </div>

        <div class="form-group">
            <p>Quận/Huyện:</p>
            <input type="text" name="district" required style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:12px;">
        </div>

        <div class="form-group">
            <p>Trạng thái:</p>
            <select name="status" required>
                <option value="available">available</option>
                <option value="rented">rented</option>
            </select>
        </div>

        <div class="form-group">
            <p>Hình ảnh (tối thiểu 3 ảnh):</p>
            <input type="file" name="images[]" accept="image/*" multiple required>
        </div>

        <button type="submit" class="btn-primary">Đăng bài</button>
    </form>
</div>

<?php
$content = ob_get_clean();
include "./../views/client/layout.php";
?>

