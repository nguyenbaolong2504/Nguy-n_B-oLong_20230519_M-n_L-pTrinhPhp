<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Form Đăng Ký</title>
    <style>
        body {
            font-family: Arial;
            margin: 40px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        button {
            margin-top: 15px;
            padding: 6px 15px;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<h2>Form Đăng Ký</h2>
<p><b>Bộ môn Công nghệ Phần mềm, Khoa CNTT, Đại học Công nghệ Đông Á</b></p>

<?php
// Khởi tạo biến
$name = $email = $gender = "";
$hobbies = [];

// Kiểm tra submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Lấy dữ liệu
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $gender = $_POST["gender"] ?? "";
    $hobbies = $_POST["hobby"] ?? [];

    // Kiểm tra lỗi
    if ($name == "" || $email == "") {
        echo "<p class='error'>❌ Vui lòng nhập đầy đủ Họ tên và Email!</p>";
    } else {
        echo "<div class='result'>";
        echo "<h3>Thông tin đã gửi:</h3>";
        echo "<ul>";

        echo "<li><b>Họ tên:</b> " . htmlspecialchars($name) . "</li>";
        echo "<li><b>Email:</b> " . htmlspecialchars($email) . "</li>";
        echo "<li><b>Giới tính:</b> " . htmlspecialchars($gender) . "</li>";

        echo "<li><b>Sở thích:</b> ";
        if (!empty($hobbies)) {
            echo htmlspecialchars(implode(", ", $hobbies));
        } else {
            echo "Không có";
        }
        echo "</li>";

        echo "</ul>";
        echo "</div>";
    }
}
?>

<form method="POST" action="">
    <label>
        Họ tên:
        <input type="text" name="name">
    </label>

    <label>
        Email:
        <input type="email" name="email">
    </label>

    <label>Giới tính:</label>
    <input type="radio" name="gender" value="Nam"> Nam
    <input type="radio" name="gender" value="Nữ"> Nữ
    <input type="radio" name="gender" value="Khác"> Khác

    <label>Sở thích:</label>
    <input type="checkbox" name="hobby[]" value="Lập trình"> Lập trình
    <input type="checkbox" name="hobby[]" value="Đọc sách"> Đọc sách
    <input type="checkbox" name="hobby[]" value="Nghe nhạc"> Nghe nhạc

    <br><br>
    <button type="submit">Gửi</button>
</form>

</body>
</html>
