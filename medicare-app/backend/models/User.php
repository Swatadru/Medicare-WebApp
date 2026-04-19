<?php

class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findByUsernameOrEmail($usernameOrEmail) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
        return $stmt->fetch();
    }

    public function create($fullname, $username, $email, $password, $role = 'patient') {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (fullname, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$fullname, $username, $email, $hashedPassword, $role])) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
