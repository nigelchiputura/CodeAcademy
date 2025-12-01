<?php

return [
    'DB_DSN'  => "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']};charset=utf8mb4",
    'DB_USER' => $_ENV['DB_USERNAME'] ?? 'root',
    'DB_PASS' => $_ENV['DB_PASSWORD'] ?? ''
];
