<?php
declare(strict_types=1);

define('ROOT', dirname(__DIR__));

require ROOT . '/config.php';

$router = new Router();
$router->dispatch();
