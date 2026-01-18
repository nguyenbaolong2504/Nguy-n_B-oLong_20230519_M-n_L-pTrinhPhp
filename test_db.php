<?php
require_once '../app/core/Database.php';

$db = Database::getInstance();
$stmt = $db->query("SELECT COUNT(*) FROM students");
$count = $stmt->fetchColumn();

echo "Kết nối OK. Tổng sinh viên: " . $count;
