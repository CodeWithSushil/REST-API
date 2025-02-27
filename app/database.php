<?php

class Database {
  private $host = '127.0.0.1';
  private $port = 3306;
  private $username = 'root';
  private $password = '';
  private $dbname = 'restapi';
  public $conn;

  public function __construct(){
    $this->conn = null;
    
    try {
      $dns = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};";
      $this->conn = new PDO($dns, $this->username, $this->password);
      //$this->conn->setAttribute();
    } catch (\Throwable $th) {
      print($th->getMessage());
      exit();
    }
  }
}

$database = new Database();
