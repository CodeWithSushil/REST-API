<?php
session_start();

$pdo = new PDO("sqlite:database.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
