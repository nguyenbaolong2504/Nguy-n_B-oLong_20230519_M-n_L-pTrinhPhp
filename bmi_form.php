<?php
$name = $_GET['name'] ?? '';
$height = $_GET['height'] ?? '';
$weight = $_GET['weight'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tính BMI</title>
</head>
<body>

<h2>Tính BMI</h2>

<form method="GET">
    Họ tên: <input type="text" name="name" value="<?= $name ?>"><br><br>
    Chiều cao (m): <input type="number" step="0.01" name="height" value="<?= $height ?>"><br><br>
    Cân nặng (kg): <input type="number" step="0.1" name="weight" value="<?= $weight ?>"><br><br>
    <button type="submit">Tính BMI</button>
</form>

<?php
if ($name && $height > 0 && $weight > 0) {
    $bmi = $weight / ($height * $height);
    $bmi = round($bmi, 2);

    if ($bmi < 18.5) $type = "Gầy";
    elseif ($bmi < 25) $type = "Bình thường";
    elseif ($bmi < 30) $type = "Thừa cân";
    else $type = "Béo phì";

    echo "<h3>Kết quả:</h3>";
    echo "Họ tên: $name <br>";
    echo "BMI: $bmi <br>";
    echo "Phân loại: $type";
}
?>

</body>
</html>
