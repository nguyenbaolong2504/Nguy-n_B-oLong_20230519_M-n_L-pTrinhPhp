<?php
require_once '../includes/auth.php';
require_once '../includes/data.php';
require_once '../includes/flash.php';
require_once '../includes/csrf.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify($_POST['csrf'])) {
    exit('Bad request');
}

$code = current_student()['student_code'];
$course = $_POST['course_code'];
$en = read_json('enrollments.json');

foreach ($en as $e) {
    if ($e['student_code']===$code && $e['course_code']===$course) {
        set_flash('error','Đã đăng ký');
        header('Location: courses.php'); exit;
    }
}

$en[] = [
    'student_code'=>$code,
    'course_code'=>$course,
    'created_at'=>date('Y-m-d H:i:s')
];
write_json('enrollments.json',$en);
set_flash('success','Đăng ký thành công');
header('Location: registrations.php');
