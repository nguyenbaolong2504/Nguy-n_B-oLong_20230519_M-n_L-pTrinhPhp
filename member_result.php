<?php
$data = $_GET;

$dir  = __DIR__ . "/data";
$file = $dir . "/members.csv";

/* ===== TẠO THƯ MỤC ===== */
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

/* ===== SINH MÃ THÀNH VIÊN ===== */
$memberId = 1;
if (file_exists($file)) {
    $lines = file($file, FILE_IGNORE_NEW_LINES);
    if (count($lines) > 0) {
        $last = str_getcsv(end($lines));
        $memberId = (int)$last[0] + 1;
    }
}

/* format 001, 002, 003 */
$memberId = str_pad($memberId, 3, '0', STR_PAD_LEFT);

/* ===== GHI FILE ===== */
$fp = fopen($file, "a");
if (!$fp) {
    die("Không thể ghi file members.csv");
}

/* ĐƯA MÃ THÀNH VIÊN LÊN ĐẦU */
fputcsv($fp, array_merge([$memberId], $data));
fclose($fp);
?>

<h3>✅ Đăng ký thành công</h3>

<ul>
    <li><b>Mã thành viên:</b> <?=htmlspecialchars($memberId)?></li>
    <?php foreach ($data as $k => $v): ?>
        <li><?=htmlspecialchars($k)?>: <?=htmlspecialchars($v)?></li>
    <?php endforeach ?>
</ul>
