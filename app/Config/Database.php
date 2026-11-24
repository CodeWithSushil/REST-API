<?php

declare(strict_types=1);

namespace App\Config;

use PDO;
use PDOException;
use Exception;

class Database
{
    private string $host;
    private string $dbname;
    private string $charset;
    private int $port;
    private string $username;
    private string $password;

    public ?PDO $conn = null;

    public function __construct()
    {
        try {

            // Database configuration
            $this->host = '127.0.0.1';
            $this->port = 3306;
            $this->dbname = 'api';
            $this->charset = 'utf8mb4';

            $this->username = 'root';
            $this->password = '';

            // DSN
            $dns = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                $this->host,
                $this->port,
                $this->dbname,
                $this->charset
            );

            // PDO options
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_STRINGIFY_FETCHES => true,
            ];

            // Database connection
            $this->conn = new PDO(
                $dns,
                $this->username,
                $this->password,
                $options
            );

        } catch (PDOException $e) {

            throw new Exception(
                $this->handleError($e)
            );
        }
    }

    // SQL error handler
    public function handleError(PDOException $e): string
    {
        return json_encode([
            'status' => false,
            'message' => 'Database Connection Error',
            'error' => $e->getMessage(),
            'code' => $e->getCode()
        ], JSON_PRETTY_PRINT) ?: '{"status":false,"message":"Database Error"}';
    }

    // Execute SQL query
    public function query(string $sql, array $params = []): array
    {
        try {

            $stmt = $this->conn->prepare($sql);

            $stmt->execute($params);

            return [
                'status' => true,
                'message' => 'Query executed successfully',
                'data' => $stmt->fetchAll()
            ];

        } catch (PDOException $e) {

            return [
                'status' => false,
                'message' => 'SQL Query Error',
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        }
    }
}
