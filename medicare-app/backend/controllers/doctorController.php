<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Doctor.php';

$doctorModel = new Doctor($conn);

// Handle specialization search
$specialization = isset($_GET['specialization']) ? trim($_GET['specialization']) : '';
$doctors = [];

if (!empty($specialization)) {
    $doctors = $doctorModel->findBySpecialization($specialization);
} else {
    $doctors = $doctorModel->getAll();
}

// If this is an AJAX request or being included in a view, the variables are now set.
