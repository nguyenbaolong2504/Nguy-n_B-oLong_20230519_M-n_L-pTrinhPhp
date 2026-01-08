<?php
require_once '../includes/auth.php';
require_login();
$s = current_student();
?>
<h2>Hồ sơ sinh viên</h2>
<p>Mã SV: <?= htmlspecialchars($s['student_code']) ?></p>
<p>Họ tên: <?= htmlspecialchars($s['full_name']) ?></p>
<p>Lớp: <?= htmlspecialchars($s['class_name']) ?></p>
<p>Email: <?= htmlspecialchars($s['email']) ?></p>
