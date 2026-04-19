<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db.php'; 
require_once __DIR__ . '/../config/csrf.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        header("Location: dashboard.php?error=Security+session+expired");
        exit();
    }
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['book_appointment'])) {
    $userId = $_SESSION['user_id'];
    $doctorId = $_POST['doctor_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $purpose = $_POST['purpose'] ?? '';

    // Simple validation
    if (empty($date) || empty($time)) {
        header("Location: book.php?error=Missing+fields&doctor_id=" . $doctorId);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO appointments (user_id, doctor_id, appointment_date, appointment_time, purpose) VALUES (?, ?, ?, ?, ?)");

    if ($stmt->execute([$userId, $doctorId, $date, $time, $purpose])) {
        header("Location: dashboard.php?success=1");
        exit();
    } else {
        header("Location: book.php?error=Database+error&doctor_id=" . $doctorId);
        exit();
    }
} else {
    header("Location: book.php");
    exit();
}
