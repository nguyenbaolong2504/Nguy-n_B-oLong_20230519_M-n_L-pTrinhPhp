<?php
require_once '../includes/auth.php';
require_once '../includes/data.php';
require_once '../includes/flash.php';
require_once '../includes/csrf.php';

require_login();

$student = current_student();
$code = $student['student_code'];

$enrollments = read_json('enrollments.json', []);
$courses = read_json('courses.json', []);
$grades = read_json('grades.json', []);

// map course_code => course
$courseMap = [];
foreach ($courses as $c) {
    $courseMap[$c['course_code']] = $c;
}

// danh sách môn đã có điểm
$graded = [];
foreach ($grades as $g) {
    if ($g['student_code'] === $code) {
        $graded[] = $g['course_code'];
    }
}

// lọc học phần của SV
$myEnrollments = array_filter($enrollments, fn($e) =>
    $e['student_code'] === $code
);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Học phần đã đăng ký</title>
</head>
<body>

<h2>📝 Học phần đã đăng ký</h2>

<?php if ($msg = get_flash('error')): ?>
    <p style="color:red"><?= htmlspecialchars($msg) ?></p>
<?php endif; ?>

<?php if ($msg = get_flash('info')): ?>
    <p style="color:blue"><?= htmlspecialchars($msg) ?></p>
<?php endif; ?>

<table border="1" cellpadding="8">
<tr>
    <th>Mã HP</th>
    <th>Tên học phần</th>
    <th>Trạng thái</th>
    <th>Thao tác</th>
</tr>

<?php foreach ($myEnrollments as $e): 
    $c = $courseMap[$e['course_code']] ?? null;
    if (!$c) continue;
?>
<tr>
    <td><?= htmlspecialchars($c['course_code']) ?></td>
    <td><?= htmlspecialchars($c['course_name']) ?></td>
    <td>
        <?= in_array($c['course_code'], $graded) ? 'Đã có điểm' : 'Chưa có điểm' ?>
    </td>
    <td>
        <?php if (!in_array($c['course_code'], $graded)): ?>
        <form method="post" action="unregister.php" style="margin:0">
            <input type="hidden" name="course_code"
                   value="<?= htmlspecialchars($c['course_code']) ?>">
            <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
            <button type="submit">Hủy</button>
        </form>
        <?php else: ?>
            ❌ Không thể hủy
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>

</table>

<p><a href="../dashboard.php">⬅ Quay về Dashboard</a></p>

</body>
</html>
