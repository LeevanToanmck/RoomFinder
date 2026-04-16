<?php
ob_start();
?>

<link rel="stylesheet" href="./../public/css/messages.css">

<div class="messages-page">
    <div class="messages-header">
        <a class="back-link" href="./client.php?controller=ownerPost&action=index">← Quay lại</a>
        <h2>Sửa bài đăng</h2>
    </div>

    <form class="comment-form" action="./client.php?controller=ownerPost&action=update" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo (int)$post['id']; ?>">

        <div class="form-group">
            <p>Loại phòng:</p>
            <select name="type_id" required>
                <?php foreach (($types ?? []) as $t): ?>
                    <option value="<?php echo (int)$t['id']; ?>" <?php echo ((int)$post['type_id'] === (int)$t['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($t['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <p>Tiêu đề:</p>
            <input type="text" name="title" required value="<?php echo htmlspecialchars($post['title'] ?? ''); ?>" style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:12px;">
        </div>

        <div class="form-group">
            <p>Mô tả:</p>
            <textarea name="description" rows="4" required><?php echo htmlspecialchars($post['description'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
            <p>Giá (VNĐ/tháng):</p>
            <input type="number" step="0.01" name="price" required value="<?php echo htmlspecialchars($post['price'] ?? 0); ?>" style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:12px;">
        </div>

        <div class="form-group">
            <p>Diện tích (m²):</p>
            <input type="number" step="0.01" name="area" required value="<?php echo htmlspecialchars($post['area'] ?? 0); ?>" style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:12px;">
        </div>

        <div class="form-group">
            <p>Địa chỉ:</p>
            <input type="text" name="address" required value="<?php echo htmlspecialchars($post['address'] ?? ''); ?>" style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:12px;">
        </div>

        <div class="form-group">
            <p>Thành phố:</p>
            <input type="text" name="city" required value="<?php echo htmlspecialchars($post['city'] ?? ''); ?>" style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:12px;">
        </div>

        <div class="form-group">
            <p>Quận/Huyện:</p>
            <input type="text" name="district" required value="<?php echo htmlspecialchars($post['district'] ?? ''); ?>" style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:12px;">
        </div>

        <div class="form-group">
            <p>Trạng thái:</p>
            <select name="status" required>
                <option value="<?php echo htmlspecialchars($post['status'] ?? 'available'); ?>"><?php echo htmlspecialchars($post['status'] ?? 'available'); ?></option>
                <option value="available">available</option>
                <option value="rented">rented</option>
            </select>
        </div>

        <div class="form-group">
            <p>Ảnh hiện tại:</p>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <?php if (!empty($images)): ?>
                    <?php foreach ($images as $img): ?>
                        <img src="./../public/<?php echo htmlspecialchars($img['image_url']); ?>" style="width:120px; height:120px; object-fit:cover; border-radius:12px;" alt="">
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Chưa có ảnh</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <p>Thay ảnh (nếu muốn):</p>
            <input type="file" name="images[]" accept="image/*" multiple>
            <p style="margin-top:6px; opacity:.8;">Nếu upload ảnh mới, hệ thống sẽ thay toàn bộ ảnh cũ.</p>
        </div>

        <button type="submit" class="btn-primary">Cập nhật</button>
    </form>
</div>

<?php
$content = ob_get_clean();
include "./../views/client/layout.php";
?>

