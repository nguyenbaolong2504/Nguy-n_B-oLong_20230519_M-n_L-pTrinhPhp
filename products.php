<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
require_once __DIR__ . '/includes/cart.php';
require_once __DIR__ . '/includes/header.php';

$products = [
    1 => ['name' => 'Book PHP', 'price' => 100],
    2 => ['name' => 'Book SQL', 'price' => 120],
    3 => ['name' => 'Book HTML', 'price' => 80],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cart_add((int)$_POST['id']);
    set_flash('success', 'Đã thêm vào giỏ');
    header('Location: products.php');
    exit;
}
?>

<h3>Products</h3>

<?php foreach ($products as $id => $p): ?>
<form method="post" class="mb-2">
    <?= htmlspecialchars($p['name']) ?> - <?= $p['price'] ?>k
    <input type="hidden" name="id" value="<?= $id ?>">
    <button class="btn btn-sm btn-success">Add</button>
</form>
<?php endforeach; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
