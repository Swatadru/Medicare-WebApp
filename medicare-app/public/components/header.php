<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../backend/config/csrf.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicare - Your Health, Our Priority</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container border-bottom-0">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <i class="fas fa-heartbeat me-2"></i>
            <span>Medicare</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="doctors.php"><?php echo (isset($_SESSION['role']) && $_SESSION['role'] === 'doctor') ? 'Colleagues' : 'Specialists'; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="medicines.php">Medicine Hub</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="subscription.php">Plans</a>
                </li>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'doctor'): ?>
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">My Patients</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="support.php">Support</a></li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="nav-link fw-semibold">Dashboard</a>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link fw-semibold">Login</a>
                    <a href="register.php" class="btn btn-primary">Join Now</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
