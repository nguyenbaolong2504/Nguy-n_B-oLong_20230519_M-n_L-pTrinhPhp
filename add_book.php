<?php
$file = "D:\PHP\htdocs\Lad06\data/books.json";
$books = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id']);
    $year = (int)$_POST['year'];
    $qty = (int)$_POST['qty'];

    foreach ($books as $b)
        if ($b['id'] === $id) $errors[] = "Trùng mã sách";

    if ($year < 1900 || $year > date('Y')) $errors[] = "Năm không hợp lệ";
    if ($qty < 0) $errors[] = "Số lượng >= 0";

    if (!$errors) {
        $books[] = $_POST;
        file_put_contents($file, json_encode($books, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
        header("Location: list_books.php");
    }
}
?>

<form method="post">
Mã sách: <input name="id"><br>
Tên sách: <input name="name"><br>
Tác giả: <input name="author"><br>
Năm XB: <input type="number" name="year"><br>
Thể loại:
<select name="category">
<option>Giáo trình</option>
<option>Kỹ năng</option>
<option>Văn học</option>
<option>Khoa học</option>
<option>Khác</option>
</select><br>
Số lượng: <input type="number" name="qty"><br>
<button>Thêm</button>
</form>

<?php foreach ($errors as $e) echo "<p style='color:red'>$e</p>"; ?>
