<?php
require("./php/database.php");

if(!isset($_SESSION['username'])){
  header('Location: ./public/login.php');
  exit();
} else {
  require_once('./public/index.php');
}
