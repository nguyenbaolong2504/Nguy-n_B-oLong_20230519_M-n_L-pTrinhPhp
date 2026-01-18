<?php
$controller = $_GET['c'] ?? 'student';
$action = $_GET['a'] ?? 'index';

require_once "../app/controllers/StudentController.php";

$ctrl = new StudentController();

if (!method_exists($ctrl, $action)) {
    die("Action không tồn tại");
}
$ctrl->$action();
