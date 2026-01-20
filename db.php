<?php
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=lab10_library;charset=utf8mb4",
        "lib_user",
        "123456",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    error_log($e->getMessage());
    die("Không thể kết nối CSDL");
}
