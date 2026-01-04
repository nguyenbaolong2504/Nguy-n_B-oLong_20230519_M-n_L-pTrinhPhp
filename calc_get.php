<?php
if (!isset($_GET['a']) || !isset($_GET['b']) || !isset($_GET['op'])) {
    echo "Vui lòng nhập theo mẫu:<br>";
    echo "http://localhost/Lad02/ex04/calc_get.php?a=10&b=3&op=add";
    exit;
}

$a = (float) $_GET['a'];
$b = (float) $_GET['b'];
$op = $_GET['op'];

switch ($op) {
    case 'add':
        $result = $a + $b;
        echo "$a + $b = $result";
        break;

    case 'sub':
        $result = $a - $b;
        echo "$a - $b = $result";
        break;

    case 'mul':
        $result = $a * $b;
        echo "$a * $b = $result";
        break;

    case 'div':
        if ($b == 0) {
            echo "Không thể chia cho 0";
        } else {
            $result = $a / $b;
            echo "$a / $b = $result";
        }
        break;

    default:
        echo "Phép toán không hợp lệ!";
}
?>
