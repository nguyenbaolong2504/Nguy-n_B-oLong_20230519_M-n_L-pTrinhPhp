<?php

$a = $_GET['a'] ?? 8;
$b = $_GET['b'] ?? 7;

echo "<h3>Tính toán cơ bản</h3>";
echo "a = $a <br>";
echo "b = $b <br><br>";

echo "Cộng: " . ($a + $b) . "<br>";
echo "Trừ: " . ($a - $b) . "<br>";
echo "Nhân: " . ($a * $b) . "<br>";

if ($b != 0) {
    echo "Chia: " . ($a / $b) . "<br>";
} else {
    echo "Chia: Không thể chia cho 0";
}
?>