<h2>Chi tiết phiếu mượn</h2>

<p>Người mượn: <?= htmlspecialchars($borrow['full_name']) ?></p>
Ngày mượn: <?= $borrow['borrow_date'] ?><br>

<ul>
<?php foreach($items as $i): ?>
<li><?= $i['title'] ?> - SL: <?= $i['qty'] ?></li>
<?php endforeach ?>
</ul>

<a href="index.php?c=borrows">Quay lại</a>
