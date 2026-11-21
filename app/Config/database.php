<?php

declare(strict_types=1);

session_start();

$host    = '127.0.0.1';
$port    = 3306;
$dbname  = 'api';
$charset = 'utf8mb4';
$username = 'root';
$password = '';

$dsn = sprintf(
    'mysql:host=%s;port=%d;dbname=%s;charset=%s',
    $host,
    $port,
    $dbname,
    $charset
);

$pdo = new PDO($dsn, $username, $password, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

