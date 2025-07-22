<?php

require_once BASE_PATH . '/bootstrap.php';
require_once BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Store values in an array
$typeConfig = [
    'pgHost' => $_ENV['PG_HOST'],
    'pgPort' => $_ENV['PG_PORT'],
    'pgDb'   => $_ENV['PG_DB'],
    'pgUser' => $_ENV['PG_USER'],
    'pgPass' => $_ENV['PG_PASS'],
];

return [
    'pgHost' => $_ENV['PG_HOST'],
    'pgPort' => $_ENV['PG_PORT'],
    'pgDb'   => $_ENV['PG_DB'],
    'pgUser' => $_ENV['PG_USER'],
    'pgPass' => $_ENV['PG_PASS'],
];