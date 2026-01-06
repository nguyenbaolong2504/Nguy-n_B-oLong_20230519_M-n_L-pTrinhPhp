<?php
$scores = [8.5,7.0,9.25,6.5,8.0,5.75];
$avg = array_sum($scores)/count($scores);
$high = array_filter($scores ,fn($x)=>$x>=8.0);
echo "AVG =" .number_format($avg,2)."<br>";
echo ">=8:".count($high);
?>