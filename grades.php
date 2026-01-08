<?php
require_once '../includes/auth.php';
require_once '../includes/data.php';
require_login();

$code = current_student()['student_code'];
$grades = array_filter(read_json('grades.json'), fn($g) => $g['student_code'] === $code);
?>
<h2>Bảng điểm</h2>
<table border="1">
<tr><th>Môn</th><th>Giữa kỳ</th><th>Cuối kỳ</th><th>Tổng</th></tr>
<?php foreach ($grades as $g): ?>
<tr>
<td><?= htmlspecialchars($g['course_code']) ?></td>
<td><?= $g['midterm'] ?></td>
<td><?= $g['final'] ?></td>
<td><?= $g['total'] ?></td>
</tr>
<?php endforeach ?>
</table>
