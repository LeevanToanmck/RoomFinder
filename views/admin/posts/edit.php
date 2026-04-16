<?php
ob_start();
?>

<div>
    <div class="form-step active">
        <h1>Sửa bài post</h1>
        <form action="./admin.php?controller=posts&action=update" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>ID:</label>
                <input type="text" value="<?php echo $post['id']; ?>" disabled>
                <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
            </div>

            <div class="form-group">
                <label>User ID:</label>
                <input type="number" name="user_id" value="<?php echo $post['user_id']; ?>" required>
            </div>

            <div class="form-group">
                <label>Loại phòng:</label>
                <select name="type_id" required>
                    <?php foreach (($types ?? []) as $t): ?>
                        <option value="<?php echo (int)$t['id']; ?>" <?php echo ((int)$post['type_id'] === (int)$t['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($t['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Tiêu đề:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($post['title'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Mô tả:</label>
                <textarea name="description" rows="4" required><?php echo htmlspecialchars($post['description'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label>Giá:</label>
                <input type="number" step="0.01" name="price" value="<?php echo $post['price']; ?>" required>
            </div>

            <div class="form-group">
                <label>Diện tích (m²):</label>
                <input type="number" step="0.01" name="area" value="<?php echo $post['area']; ?>" required>
            </div>

            <div class="form-group">
                <label>Địa chỉ:</label>
                <input type="text" name="address" value="<?php echo htmlspecialchars($post['address'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Thành phố:</label>
                <input type="text" name="city" value="<?php echo htmlspecialchars($post['city'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Quận/Huyện:</label>
                <input type="text" name="district" value="<?php echo htmlspecialchars($post['district'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Trạng thái:</label>
                <select name="status" required>
                    <option value="<?php echo $post['status']; ?>"><?php echo $post['status']; ?></option>
                    <option value="available">available</option>
                    <option value="rented">rented</option>
                </select>
            </div>

            <div class="form-group">
                <label>Ảnh hiện tại:</label>
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <?php if (!empty($images)): ?>
                        <?php foreach ($images as $img): ?>
                            <img src="./../public/<?php echo htmlspecialchars($img['image_url']); ?>" style="width:120px; height:120px; object-fit:cover;" alt="">
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Chưa có ảnh</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label>Thay ảnh (chọn nhiều ảnh nếu muốn):</label>
                <input type="file" name="images[]" accept="image/*" multiple>
                <p style="margin-top:6px; opacity:.8;">Nếu upload ảnh mới, hệ thống sẽ thay toàn bộ ảnh cũ.</p>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include './../views/admin/layout.php';
?>

