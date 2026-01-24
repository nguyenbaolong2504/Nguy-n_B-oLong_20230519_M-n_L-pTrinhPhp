<h2>Thêm danh mục</h2>

<?php if (!empty($error)): ?>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post">
    <label>Tên danh mục</label><br>
    <input type="text" name="name">
    <br><br>
    <button>Thêm</button>
    <a href="index.php?c=category">Quay lại</a>
</form>
