<?php
class Database {
    protected static $conn = null;

    public static function connect() {
        if (self::$conn === null) {
            $config = require __DIR__ . '/../config/database.php';
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
            self::$conn = new PDO($dsn, $config['user'], $config['pass']);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
}
