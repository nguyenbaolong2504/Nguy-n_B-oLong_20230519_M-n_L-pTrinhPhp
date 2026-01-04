<?php
$n = (int)($_GET["n"] ?? 0);

echo "<h3>Bảng cửu chương</h3>";
echo "<table border='1' cellpadding='5'>";
for ($i = 1; $i <= 9; $i++) {
    echo "<tr>";
    for ($j = 1; $j <= 9; $j++) {
        echo "<td>$i x $j = " . ($i * $j) . "</td>";
    }
    echo "</tr>";
}
echo "</table>";

$temp = abs($n);
$sum  = 0;
while ($temp > 0) {
    $sum += $temp % 10;
    $temp = (int)($temp / 10);
}
echo "<p>Tổng chữ số của $n = $sum</p>";

echo "<p>Số lẻ từ 1 đến $n: ";
for ($i = 1; $i <= $n; $i++) {
    if ($i % 2 == 0) continue;
    if ($i > 15) break;
    echo $i . " ";
}
echo "</p>";
?>
