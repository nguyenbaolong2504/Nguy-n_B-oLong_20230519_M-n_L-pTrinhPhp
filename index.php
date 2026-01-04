<?php
require_once "function.php";

$action = $_GET['action'] ?? 'home';

echo "<h2>LAB03 - Mini Utility</h2>";
echo "<p>
<a href='?action=max&a=10&b=22'>Max</a> |
<a href='?action=min&a=10&b=22'>Min</a> |
<a href='?action=prime&n=17'>Prime</a> |
<a href='?action=fact&n=6'>Factorial</a> |
<a href='?action=gcd&a=12&b=18'>GCD</a>
</p>";

echo "<hr>";

switch ($action) {
    case 'max':
        $a = $_GET['a'] ?? 0;
        $b = $_GET['b'] ?? 0;
        echo "Max của $a và $b là: <b>" . Max2($a, $b) . "</b>";
        break;

    case 'min':
        $a = $_GET['a'] ?? 0;
        $b = $_GET['b'] ?? 0;
        echo "Min của $a và $b là: <b>" . Min2($a, $b) . "</b>";
        break;

    case 'prime':
        $n = $_GET['n'] ?? 0;
        if (isPrime($n)) {
            echo "$n là <b>số nguyên tố</b>";
        } else {
            echo "$n <b>không</b> phải số nguyên tố";
        }
        break;

    case 'fact':
        $n = $_GET['n'] ?? 0;
        echo "Giai thừa của $n là: <b>" . factorial($n) . "</b>";
        break;

    case 'gcd':
        $a = $_GET['a'] ?? 0;
        $b = $_GET['b'] ?? 0;
        echo "UCLN của $a và $b là: <b>" . gcd($a, $b) . "</b>";
        break;

    default:
        echo "👉 Chọn chức năng ở menu phía trên";
}
?>