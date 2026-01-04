<?php
$fullName = "Nguyễn Văn A";
$age = 20;
$gpa = 3.25;
$isActive = true;

const SCHOOL = "Đại học CNTT";

// In dạng câu
echo "Họ tên: $fullName <br>";
echo "Tuổi: $age <br>";
echo "GPA: $gpa <br>";
echo "Trạng thái: $isActive <br>";
echo "Trường: " . SCHOOL . "<br><br>";

// Debug
var_dump($fullName);
echo "<br>";
var_dump($age);
echo "<br>";
var_dump($gpa);
echo "<br>";
var_dump($isActive);
echo "<br><br>";

// Nội suy chuỗi
echo "Nháy kép: Tuoi: $age <br>";
echo 'Nháy đơn: Tuoi: $age <br>';

// Nhận xét:
// Nháy kép sẽ phân tích biến, nháy đơn thì không.
?>
