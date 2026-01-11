<?php
$books = json_decode(file_get_contents("D:\PHP\htdocs\Lad06\data/books.json"), true) ?? [];
$kw = strtolower($_GET['kw'] ?? '');
$result = array_filter($books, fn($b)=> !$kw || str_contains(strtolower($b['name']), $kw));
?>

<form>
<input name="kw" value="<?=htmlspecialchars($kw)?>">
<button>Search</button>
</form>

<table border="1">
<?php foreach ($result as $b): ?>
<tr><td><?=$b['name']?></td><td><?=$b['author']?></td></tr>
<?php endforeach ?>
</table>
