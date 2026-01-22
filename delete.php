<?php
require '../config/db.php';
require '../helpers/flash.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("DELETE FROM categories WHERE id=?");
$stmt->execute([$id]);

set_flash('Xóa thành công');
header('Location: index.php');
