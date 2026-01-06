<?php
function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

$products = [
    ['name' => 'Sách PHP cơ bản', 'price' => 50000, 'qty' => 2],
    ['name' => 'Sách MySQL',     'price' => 70000, 'qty' => 1],
    ['name' => 'Sách Laravel',  'price' => 120000,'qty' => 3],
    ['name' => 'Sách HTML/CSS', 'price' => 40000, 'qty' => 4],
];

$products = array_map(function ($p) {
    $p['amount'] = $p['price'] * $p['qty'];
    return $p;
}, $products);

$totalAmount = array_reduce($products, function ($sum, $p) {
    return $sum + $p['amount'];
}, 0);

$maxProduct = array_reduce($products, function ($max, $p) {
    if ($max === null || $p['amount'] > $max['amount']) {
        return $p;
    }
    return $max;
}, null);

$productsSorted = $products;
usort($productsSorted, function ($a, $b) {
    return $b['price'] <=> $a['price'];
});
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài 3 - Giỏ hàng</title>
    <style>
        table {
            border-collapse: collapse;
            width: 70%;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }
        th {
            background: #f0f0f0;
        }
        .total {
            font-weight: bold;
            background: #fafafa;
        }
    </style>
</head>
<body>

<h2>Giỏ hàng</h2>

<table>
    <tr>
        <th>STT</th>
        <th>Name</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Amount</th>
    </tr>

    <?php foreach ($products as $i => $p): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= h($p['name']) ?></td>
            <td><?= number_format($p['price']) ?></td>
            <td><?= $p['qty'] ?></td>
            <td><?= number_format($p['amount']) ?></td>
        </tr>
    <?php endforeach; ?>

    <tr class="total">
        <td colspan="4">Tổng tiền</td>
        <td><?= number_format($totalAmount) ?></td>
    </tr>
</table>

<h3>Sản phẩm có thành tiền cao nhất</h3>
<p>
    <?= h($maxProduct['name']) ?> –
    <?= number_format($maxProduct['amount']) ?> VND
</p>

<h3>Danh sách sản phẩm (Price giảm dần)</h3>
<table>
    <tr>
        <th>STT</th>
        <th>Name</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Amount</th>
    </tr>

    <?php foreach ($productsSorted as $i => $p): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= h($p['name']) ?></td>
            <td><?= number_format($p['price']) ?></td>
            <td><?= $p['qty'] ?></td>
            <td><?= number_format($p['amount']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
