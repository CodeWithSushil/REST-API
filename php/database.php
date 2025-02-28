<?php
session_start();

$pdo = new PDO("sqlite:database.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$pdo->exec("INSERT INTO `crud`(`id`, `title`, `content`) VALUES ('1', 'Test Title', 'test content')");
