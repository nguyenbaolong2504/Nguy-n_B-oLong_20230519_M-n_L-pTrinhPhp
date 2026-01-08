<?php
require_once 'includes/data.php';
session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['student_code'] ?? '');
    $pass = $_POST['password'] ?? '';
    $students = read_json('students.json');

    foreach ($students as $s) {
        if ($s['student_code'] === $code &&
            password_verify($pass, $s['password_hash'])) {
            $_SESSION['auth'] = true;
            $_SESSION['student'] = $s;
            header('Location: dashboard.php');
            exit;
        }
    }
    $error = 'Sai mã SV hoặc mật khẩu';
}
?>
<form method="post">
    <h2>Đăng nhập</h2>
    <?= htmlspecialchars($error) ?>
    <input name="student_code" placeholder="Mã SV">
    <input name="password" type="password" placeholder="Mật khẩu">
    <button>Login</button>
</form>
