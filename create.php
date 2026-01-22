<?php
require '../config/db.php';
require '../helpers/flash.php';
require '../helpers/functions.php';

$errors = [];
$name = $slug = $description = '';
$status = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $slug = trim($_POST['slug']);
    $description = trim($_POST['description']);
    $status = $_POST['status'] ?? 1;

    if ($name === '' || mb_strlen($name) < 3)
        $errors['name'] = 'Name từ 3–100 ký tự';

    if ($slug === '' || !valid_slug($slug))
        $errors['slug'] = 'Slug chỉ gồm a-z, 0-9, -';

    $stmt = $pdo->prepare("SELECT id FROM categories WHERE slug=?");
    $stmt->execute([$slug]);
    if ($stmt->fetch())
        $errors['slug'] = 'Slug đã tồn tại';

    if (!in_array($status, ['0','1']))
        $errors['status'] = 'Status không hợp lệ';

    if (!$errors) {
        $stmt = $pdo->prepare("
            INSERT INTO categories(name,slug,description,status)
            VALUES (?,?,?,?)
        ");
        $stmt->execute([$name,$slug,$description,$status]);
        set_flash('Thêm thành công');
        header('Location: index.php');
        exit;
    }
}
?>

<h2>Thêm danh mục</h2>

<form method="post">
Name: <input name="name" value="<?= e($name) ?>">
<span><?= $errors['name'] ?? '' ?></span><br>

Slug: <input name="slug" value="<?= e($slug) ?>">
<span><?= $errors['slug'] ?? '' ?></span><br>

Description:<br>
<textarea name="description"><?= e($description) ?></textarea><br>

Status:
<select name="status">
    <option value="1">Active</option>
    <option value="0">Inactive</option>
</select><br>

<button>Save</button>
<a href="index.php">Back</a>
</form>
