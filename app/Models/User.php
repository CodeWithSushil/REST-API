<?php

declare(strict_types=1);

namespace App\Models;

use App\Config\Database;

final class User extends Database
{
    public string $id;
    public string $name;
    public string $email;
    public string $password;

    public function login(): bool
    {
        $sql = 'SELECT id, name, email, password
                FROM users
                WHERE email = :email
                LIMIT 1';

        $statement = $this->conn->prepare($sql);
        $statement->execute([
            ':email' => $this->email,
        ]);

        $user = $statement->fetch();

        if ($user === false || !password_verify($this->password, $user['password'])) {
            return false;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => md5($user['id']),
            'name' => $user['name'],
            'email' => $user['email'],
        ];

        return true;
    }

    public function register()
    {
        $sql = "SELECT email FROM users WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':email' => $this->email,
        ]);

        if($stmt->rowCount() > 0){
            return false;
        } else {
            $sql2 = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->execute([
                ':name' => $this->name,
                ':email' => $this->email,
                ':password' => password_hash($this->password, PASSWORD_BCRYPT),
            ]);

            return true;
        }
    }
}
