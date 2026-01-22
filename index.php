<?php
require '../config/db.php';
require '../helpers/flash.php';
require '../helpers/functions.php';

$keyword = trim($_GET['keyword'] ?? '');
$flash = get_flash();


if ($keyword === '') {
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY id DESC");
} else {
    $stmt = $pdo->prepare("
        SELECT * FROM categories
        WHERE name LIKE ? OR ID LIKE ?
        ORDER BY id DESC
    ");
    $kw = '%' . $keyword . '%';
    $stmt->execute([$kw, $kw]); //
}

$rows = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh mục</title>
    <style>
        table { border-collapse: collapse; width: 80%; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h2>Danh sách danh mục</h2>

<?php if ($flash): ?>
    <p style="color:green"><?= e($flash['msg']) ?></p>
<?php endif; ?>

<form method="get">
    <input type="text"
           name="keyword"
           value="<?= e($keyword) ?>"
           placeholder="Tìm theo name hoặc slug">
    <button type="submit">Tìm</button>
    <a href="create.php">➕ Thêm mới</a>
</form>

<br>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Slug</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    <?php if (count($rows) === 0): ?>
        <tr>
            <td colspan="5">Không tìm thấy dữ liệu</td>
        </tr>
    <?php endif; ?>

    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?= e($r['id']) ?></td>
            <td><?= e($r['name']) ?></td>
            <td><?= e($r['slug']) ?></td>
            <td><?= $r['status'] ? 'Active' : 'Inactive' ?></td>
            <td>
                <a href="edit.php?id=<?= $r['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $r['id'] ?>"
                   onclick="return confirm('Bạn chắc chắn muốn xóa?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
