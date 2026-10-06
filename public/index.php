<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Controller\MatrizController;

$controller = new MatrizController();
$data = $controller->handleRequest($_POST);

require_once __DIR__ . '/../View/home.php';