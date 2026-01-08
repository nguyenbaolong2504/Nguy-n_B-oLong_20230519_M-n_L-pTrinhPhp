<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/flash.php';
require_once __DIR__ . '/includes/users.php';

$error = '';
$remembered = $_COOKIE['remember_username'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = (string)($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Vui lòng nhập đầy đủ thông tin.';
    } elseif (!empty($users[$username]) &&
        password_verify($password, $users[$username]['hash'])) {

        $_SESSION['auth'] = true;
        $_SESSION['user'] = [
            'username' => $username,
            'role' => $users[$username]['role']
        ];

        if (!empty($_POST['remember'])) {
            setcookie('remember_username', $username, time() + 7*24*60*60, '/');
        }

        set_flash('success', 'Đăng nhập thành công');
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Sai tài khoản hoặc mật khẩu';
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body class="container mt-5">
<h3>Đăng nhập</h3>

<?php if ($error): ?>
<p class="text-danger"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post">
    Username:
    <input name="username" value="<?= htmlspecialchars($remembered) ?>"><br><br>
    Password:
    <input type="password" name="password"><br><br>
    <label>
        <input type="checkbox" name="remember"> Remember me
    </label><br><br>
    <button class="btn btn-primary">Login</button>
</form>
</body>
</html>
