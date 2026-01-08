<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
require_once __DIR__ . '/includes/header.php';
?>

<h3>Dashboard</h3>
<p>Xin chào <b><?= htmlspecialchars($_SESSION['user']['username']) ?></b></p>

<ul>
    <li><a href="products.php">Products</a></li>
    <li><a href="cart.php">Cart</a></li>
    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
        <li><b>Admin Panel</b></li>
    <?php endif; ?>
</ul>

<form method="post" action="logout.php">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <button class="btn btn-danger">Logout</button>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
