<?php

class Doctor {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM doctors");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT d.*, u.email as contact_email FROM doctors d JOIN users u ON d.id = u.id WHERE d.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function findBySpecialization($spec) {
        $stmt = $this->conn->prepare("SELECT * FROM doctors WHERE specialization LIKE ?");
        $stmt->execute(["%$spec%"]);
        return $stmt->fetchAll();
    }

    public function create($userId, $name, $contact, $specialization, $experience, $availability, $image = null) {
        $stmt = $this->conn->prepare("INSERT INTO doctors (id, name, contact, specialization, experience, availability, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$userId, $name, $contact, $specialization, $experience, $availability, $image]);
    }
}
