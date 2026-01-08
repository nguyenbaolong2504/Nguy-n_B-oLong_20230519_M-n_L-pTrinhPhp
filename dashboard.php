<?php
require_once 'includes/auth.php';
require_login();

$student = current_student();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <style>
        body { font-family: Arial; background:#f5f5f5; }
        .box { width:600px; margin:40px auto; background:#fff; padding:20px; border-radius:8px }
        a { display:block; margin:10px 0; text-decoration:none; color:#0066cc }
        a:hover { text-decoration:underline }
        .logout { margin-top:20px }
    </style>
</head>
<body>

<div class="box">
    <h2>🎓 Student Portal</h2>
    <p>Xin chào, <b><?= htmlspecialchars($student['full_name']) ?></b></p>
    <hr>

    <a href="student/profile.php">👤 Hồ sơ sinh viên</a>
    <a href="student/grades.php">📊 Xem điểm</a>
    <a href="student/courses.php">📚 Danh sách học phần</a>
    <a href="student/registrations.php">📝 Học phần đã đăng ký</a>

    <a href="#" onclick="document.getElementById('logoutForm').submit(); return false;"
   style="color:red; display:block; margin-top:15px;">
    🚪 Đăng xuất
</a>

<form id="logoutForm" method="post" action="logout.php" style="display:none;">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
</form>

    </form>
</div>

</body>
</html>
