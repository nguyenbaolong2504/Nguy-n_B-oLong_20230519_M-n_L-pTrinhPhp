<?php
$books = json_decode(file_get_contents("D:\PHP\htdocs\Lad06\data/books.json"), true) ?? [];
?>
<table border="1">
<tr><th>Mã</th><th>Tên</th><th>Tác giả</th><th>Năm</th><th>Thể loại</th><th>SL</th></tr>
<?php foreach ($books as $b): ?>
<tr>
<td><?=htmlspecialchars($b['id'])?></td>
<td><?=htmlspecialchars($b['name'])?></td>
<td><?=htmlspecialchars($b['author'])?></td>
<td><?=$b['year']?></td>
<td><?=$b['category']?></td>
<td><?=$b['qty']?></td>
</tr>
<?php endforeach ?>
</table>
