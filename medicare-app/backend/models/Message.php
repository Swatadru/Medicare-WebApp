<?php

class Message {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getByAppointment($appointmentId) {
        $stmt = $this->conn->prepare("
            SELECT m.*, u.fullname as sender_name 
            FROM messages m 
            JOIN users u ON m.sender_id = u.id 
            WHERE m.appointment_id = ? 
            ORDER BY m.timestamp ASC
        ");
        $stmt->execute([$appointmentId]);
        return $stmt->fetchAll();
    }

    public function send($appointmentId, $senderId, $content) {
        $stmt = $this->conn->prepare("INSERT INTO messages (appointment_id, sender_id, content) VALUES (?, ?, ?)");
        return $stmt->execute([$appointmentId, $senderId, $content]);
    }

    public function getNewMessages($appointmentId, $lastId) {
        $stmt = $this->conn->prepare("
            SELECT m.*, u.fullname as sender_name 
            FROM messages m 
            JOIN users u ON m.sender_id = u.id 
            WHERE m.appointment_id = ? AND m.id > ?
            ORDER BY m.timestamp ASC
        ");
        $stmt->execute([$appointmentId, $lastId]);
        return $stmt->fetchAll();
    }
}
