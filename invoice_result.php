<?php
$data = $_GET; // hoặc $_POST cho đúng với form

$book  = $data['book'] ?? '';
$price = (int)($data['price'] ?? 0);
$days  = (int)($data['days'] ?? 0);

$total = $price * $days;
?>

<h3>HÓA ĐƠN MƯỢN SÁCH</h3>

<ul>
    <li>Sách: <?=htmlspecialchars($book)?></li>
    <li>Đơn giá: <?=number_format($price)?> đ</li>
    <li>Số ngày: <?=$days?></li>
    <li><b>Tổng tiền: <?=number_format($total)?> đ</b></li>
</ul>
