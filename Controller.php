<?php
class Controller {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    protected function view($path, $data = []) {
        extract($data);
        require "../app/views/$path.php";
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
}
