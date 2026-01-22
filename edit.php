<?php
require '../config/db.php';
require '../helpers/flash.php';
require '../helpers/functions.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$cat = $stmt->fetch();

if (!$cat) {
    die('Không tìm thấy dữ liệu');
}

$errors = [];
$name = $cat['name'];
$slug = $cat['slug'];
$description = $cat['description'];
$status = (string)$cat['status'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $slug = trim($_POST['slug']);
    $description = trim($_POST['description']);
    $status = $_POST['status'];

    if ($name === '' || mb_strlen($name) < 3 || mb_strlen($name) > 100) {
        $errors['name'] = 'Name từ 3–100 ký tự';
    }

    if ($slug === '' || !valid_slug($slug)) {
        $errors['slug'] = 'Slug không hợp lệ';
    } else {
        $stmt = $pdo->prepare(
            "SELECT id FROM categories WHERE slug = ? AND id != ?"
        );
        $stmt->execute([$slug, $id]);
        if ($stmt->fetch()) {
            $errors['slug'] = 'Slug đã tồn tại';
        }
    }

    if (!in_array($status, ['0','1'])) {
        $errors['status'] = 'Status không hợp lệ';
    }

    if (!$errors) {
        $stmt = $pdo->prepare("
            UPDATE categories
            SET name=?, slug=?, description=?, status=?
            WHERE id=?
        ");
        $stmt->execute([$name,$slug,$description,$status,$id]);

        set_flash('Cập nhật thành công');
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sửa danh mục</title>
</head>
<body>

<h2>Sửa danh mục</h2>

<form method="post">
    Name:<br>
    <input name="name" value="<?= e($name) ?>">
    <div style="color:red"><?= $errors['name'] ?? '' ?></div>

    Slug:<br>
    <input name="slug" value="<?= e($slug) ?>">
    <div style="color:red"><?= $errors['slug'] ?? '' ?></div>

    Description:<br>
    <textarea name="description"><?= e($description) ?></textarea><br>

    Status:<br>
    <select name="status">
        <option value="1" <?= $status=='1'?'selected':'' ?>>Active</option>
        <option value="0" <?= $status=='0'?'selected':'' ?>>Inactive</option>
    </select>

    <br><br>
    <button>Update</button>
    <a href="index.php">Back</a>
</form>

</body>
</html>
