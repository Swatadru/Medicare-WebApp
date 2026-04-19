<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Message.php';

if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$messageModel = new Message($conn);
$action = $_GET['action'] ?? '';

if ($action === 'fetch') {
    $appointmentId = $_GET['appointment_id'] ?? 0;
    $lastId = $_GET['last_id'] ?? 0;
    
    // Security: Check if user belongs to this appointment
    $stmt = $conn->prepare("SELECT user_id, doctor_id FROM appointments WHERE id = ?");
    $stmt->execute([$appointmentId]);
    $appointment = $stmt->fetch();
    
    if (!$appointment || ($appointment['user_id'] != $_SESSION['user_id'] && $appointment['doctor_id'] != $_SESSION['user_id'])) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Access denied']);
        exit();
    }

    $messages = $messageModel->getNewMessages($appointmentId, $lastId);
    header('Content-Type: application/json');
    echo json_encode($messages);
    exit();
}

if ($action === 'send') {
    $data = json_decode(file_get_contents('php://input'), true);
    $appointmentId = $data['appointment_id'] ?? 0;
    $content = trim($data['content'] ?? '');
    
    if (empty($content)) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Empty message']);
        exit();
    }

    // Security: Check if user belongs to this appointment
    $stmt = $conn->prepare("SELECT user_id, doctor_id FROM appointments WHERE id = ?");
    $stmt->execute([$appointmentId]);
    $appointment = $stmt->fetch();

    if (!$appointment || ($appointment['user_id'] != $_SESSION['user_id'] && $appointment['doctor_id'] != $_SESSION['user_id'])) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Access denied']);
        exit();
    }

    $success = $messageModel->send($appointmentId, $_SESSION['user_id'], $content);
    header('Content-Type: application/json');
    echo json_encode(['success' => $success]);
    exit();
}
