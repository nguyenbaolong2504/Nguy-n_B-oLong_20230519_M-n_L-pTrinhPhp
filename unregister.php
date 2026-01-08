<?php
require_once '../includes/auth.php';
require_once '../includes/data.php';
require_once '../includes/flash.php';
require_once '../includes/csrf.php';
require_login();

if (!csrf_verify($_POST['csrf'])) exit('Bad request');

$code = current_student()['student_code'];
$course = $_POST['course_code'];

foreach (read_json('grades.json') as $g) {
    if ($g['student_code']===$code && $g['course_code']===$course) {
        set_flash('error','Môn đã có điểm');
        header('Location: registrations.php'); exit;
    }
}

$en = array_filter(read_json('enrollments.json'),
    fn($e)=>!($e['student_code']===$code && $e['course_code']===$course));
write_json('enrollments.json', array_values($en));
set_flash('info','Đã hủy đăng ký');
header('Location: registrations.php');
