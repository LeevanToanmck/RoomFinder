<?php
ob_start();
?>

<div>
    <div class="form-container">
        <form action="./admin.php?controller=posts&action=store" method="POST" enctype="multipart/form-data">
            <div class="form-step active">
                <h2>Thêm bài post mới</h2>

                <div class="form-group">
                    <p>User ID:</p>
                    <input type="number" name="user_id" required>
                </div>

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
                    <input type="text" name="title" required>
                </div>

                <div class="form-group">
                    <p>Mô tả:</p>
                    <textarea name="description" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <p>Giá:</p>
                    <input type="number" step="0.01" name="price" required>
                </div>

                <div class="form-group">
                    <p>Diện tích (m²):</p>
                    <input type="number" step="0.01" name="area" required>
                </div>

                <div class="form-group">
                    <p>Địa chỉ:</p>
                    <input type="text" name="address" required>
                </div>

                <div class="form-group">
                    <p>Thành phố:</p>
                    <input type="text" name="city" required>
                </div>

                <div class="form-group">
                    <p>Quận/Huyện:</p>
                    <input type="text" name="district" required>
                </div>

                <div class="form-group">
                    <p>Trạng thái:</p>
                    <select name="status" required>
                        <option value="available">available</option>
                        <option value="rented">rented</option>
                    </select>
                </div>

                <div class="form-group">
                    <p>Hình ảnh bài post (tối thiểu 3 ảnh):</p>
                    <input type="file" name="images[]" accept="image/*" multiple required>
                </div>

                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include './../views/admin/layout.php';
?>

