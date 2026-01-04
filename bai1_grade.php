<?php
$score = isset($_GET["score"]) ? (float)$_GET["score"] : null;
if ($score === null) {
echo "Hãy truyền ?score=...";
exit;
}
$score = (float)$score;

if($score<0 || $score>10){
        echo "Điểm không hợp lệ! Điểm phải từ 0 đến 10.";
exit;
}

if ($score >= 8.5) {
    $rank = "Giỏi";
} elseif ($score >= 7.0) {
    $rank = "Khá";
} elseif ($score >= 5.0) {
    $rank = "Trung bình";
} else {
    $rank = "Yếu";
}

echo "Điểm: $score – Xếp loại: $rank";
?>