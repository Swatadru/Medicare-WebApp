<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../backend/config/db.php';
require_once __DIR__ . '/../backend/controllers/appointmentController.php';

require_once __DIR__ . '/../backend/config/csrf.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// CSRF check
$token = $_GET['csrf_token'] ?? $_POST['csrf_token'] ?? '';
if (!verifyCsrfToken($token)) {
    header("Location: dashboard.php?error=Security+session+expired");
    exit();
}

$appointmentController = new AppointmentController($conn);

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$appointmentId = $_GET['id'] ?? $_POST['id'] ?? null;
$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];

if (!$appointmentId || !$action) {
    header("Location: dashboard.php?error=Invalid+request");
    exit();
}

if ($action === 'confirm') {
    $result = $appointmentController->updateStatus($appointmentId, 'confirmed', $userId, $role);
    $msg = $result['success'] ? 'success=Appointment+confirmed' : 'error=' . urlencode($result['message']);
    header("Location: dashboard.php?" . $msg);
    exit();
}

if ($action === 'cancel') {
    $result = $appointmentController->updateStatus($appointmentId, 'cancelled', $userId, $role);
    $msg = $result['success'] ? 'success=Appointment+cancelled' : 'error=' . urlencode($result['message']);
    header("Location: dashboard.php?" . $msg);
    exit();
}

header("Location: dashboard.php");
exit();
