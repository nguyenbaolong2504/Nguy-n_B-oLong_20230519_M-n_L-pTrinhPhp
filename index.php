<?php
session_start();

require_once "../app/config/db.php";
require_once "../app/core/Router.php";
require_once "../app/core/Controller.php";

$router = new Router($pdo);
$router->dispatch();
