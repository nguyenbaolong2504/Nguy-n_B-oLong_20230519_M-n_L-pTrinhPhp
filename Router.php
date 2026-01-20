<?php
class Router {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function dispatch() {
        $c = $_GET['c'] ?? 'home';
        $a = $_GET['a'] ?? 'index';

        $controller = ucfirst($c) . "Controller";
        $file = "../app/controllers/$controller.php";

        if (!file_exists($file)) die("Controller not found");

        require_once $file;
        $obj = new $controller($this->pdo);

        if (!method_exists($obj, $a)) die("Action not found");
        $obj->$a();
    }
}
