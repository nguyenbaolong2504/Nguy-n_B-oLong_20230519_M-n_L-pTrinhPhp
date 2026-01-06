<?php
$raws= 'An,Binh,Chi Dung';
$names = array_map('trim',explode(",",$raws));
$names = array_filter($names,fn($x)=>$x!=="");

echo "<ul>";
foreach ($names as $n){
    echo "<li>" .htmlspecialchars($n) ."</li>";

}
echo"</ul>";
?>