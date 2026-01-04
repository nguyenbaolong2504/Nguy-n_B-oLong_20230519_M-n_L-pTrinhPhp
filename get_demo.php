<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin người dùng</title>
</head>
<body>

<h2>Thông tin người dùng</h2>

<?php
// Kiểm tra có đủ tham số không
if (isset($_GET['name']) && isset($_GET['age'])) {

    // Lấy dữ liệu và chống lỗi ký tự đặc biệt
    $name = htmlspecialchars($_GET['name']);
    $age  = htmlspecialchars($_GET['age']);

    echo "<p>Xin chào <b>$name</b>, tuổi: <b>$age</b></p>";

} else {
    echo "<p><b>Thiếu tham số!</b></p>";
    echo "<p>Vui lòng nhập theo mẫu:</p>";
    echo "<code>?name=Long&age=20</code>";
}
?>

</body>
</html>
