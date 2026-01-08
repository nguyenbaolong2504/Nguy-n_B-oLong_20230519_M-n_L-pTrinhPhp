<?php
require_once 'includes/csrf.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify($_POST['csrf'] ?? null)) {
    session_unset();     
    session_destroy();   
}

header('Location: login.php');
exit;
