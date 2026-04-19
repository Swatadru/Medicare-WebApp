<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Medicine.php';

$medicineModel = new Medicine($conn);

// Handle search
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$medicines = [];

if (!empty($searchQuery)) {
    $medicines = $medicineModel->search($searchQuery);
} else {
    $medicines = $medicineModel->getAll();
}
