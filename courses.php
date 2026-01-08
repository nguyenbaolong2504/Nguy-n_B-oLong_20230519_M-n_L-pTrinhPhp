<?php
require_once '../includes/auth.php';
require_once '../includes/data.php';
require_once '../includes/flash.php';
require_once '../includes/csrf.php';

require_login();

$courses = read_json('courses.json', []);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh mục học phần</title>
</head>
<body>

<h2>📚 Danh mục học phần mở đăng ký</h2>

<?php if ($msg = get_flash('error')): ?>
    <p style="color:red"><?= htmlspecialchars($msg) ?></p>
<?php endif; ?>

<?php if ($msg = get_flash('success')): ?>
    <p style="color:green"><?= htmlspecialchars($msg) ?></p>
<?php endif; ?>

<table border="1" cellpadding="8">
<tr>
    <th>Mã HP</th>
    <th>Tên học phần</th>
    <th>Số tín chỉ</th>
    <th>Thao tác</th>
</tr>

<?php foreach ($courses as $c): ?>
<tr>
    <td><?= htmlspecialchars($c['course_code']) ?></td>
    <td><?= htmlspecialchars($c['course_name']) ?></td>
    <td><?= htmlspecialchars($c['credits']) ?></td>
    <td>
        <form method="post" action="register.php" style="margin:0">
            <input type="hidden" name="course_code"
                   value="<?= htmlspecialchars($c['course_code']) ?>">
            <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
            <button type="submit">Đăng ký</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>

</table>

<p><a href="../dashboard.php">⬅ Quay về Dashboard</a></p>

</body>
</html>
