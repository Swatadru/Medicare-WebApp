<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../backend/config/db.php';

// Fetch user's appointments
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("
    SELECT a.*, d.name as doctor_name, d.specialization 
    FROM appointments a
    JOIN doctors d ON a.doctor_id = d.id
    WHERE a.user_id = ?
    ORDER BY a.appointment_date DESC, a.appointment_time DESC
");
$stmt->execute([$user_id]);
$appointments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments | Medicare</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .appointment-card {
            border-left: 5px solid var(--primary);
            margin-bottom: 1.5rem;
        }
        .detail-icon {
            color: var(--primary);
            width: 25px;
            text-align: center;
        }
        .status-pending { color: var(--warning); background: rgba(245, 158, 11, 0.1); }
        .status-confirmed { color: var(--success); background: rgba(16, 185, 129, 0.1); }
        .status-cancelled { color: var(--danger); background: rgba(239, 68, 68, 0.1); }
    </style>
</head>
<body>
    <?php include 'components/header.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-calendar-alt"></i> My Appointments</h1>
            <p>View and manage your upcoming and past appointments</p>
        </div>

        <div class="appointments-list">
            <?php if (!empty($appointments)): ?>
                <?php foreach ($appointments as $appointment): ?>
                    <div class="bento-card appointment-card animate-fade-in">
                        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                            <h3 class="mb-0 h5 fw-bold">
                                <i class="fas fa-user-md text-primary me-2"></i>
                                Dr. <?= htmlspecialchars($appointment['doctor_name']) ?>
                            </h3>
                            <span class="status-pill status-<?= strtolower($appointment['status'] ?? 'pending') ?>">
                                <?= ucfirst($appointment['status'] ?? 'Pending') ?>
                            </span>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-3 col-sm-6">
                                <div class="small text-muted mb-1"><i class="fas fa-calendar-day me-1"></i> Date</div>
                                <div class="fw-bold"><?= date('F j, Y', strtotime($appointment['appointment_date'])) ?></div>
                            </div>
                            
                            <div class="col-md-3 col-sm-6">
                                <div class="small text-muted mb-1"><i class="fas fa-clock me-1"></i> Time</div>
                                <div class="fw-bold"><?= date('g:i A', strtotime($appointment['appointment_time'])) ?></div>
                            </div>
                            
                            <div class="col-md-3 col-sm-6">
                                <div class="small text-muted mb-1"><i class="fas fa-stethoscope me-1"></i> Specialization</div>
                                <div class="fw-bold text-primary"><?= htmlspecialchars($appointment['specialization']) ?></div>
                            </div>
                            
                            <div class="col-md-3 col-sm-6">
                                <div class="small text-muted mb-1"><i class="fas fa-info-circle me-1"></i> Purpose</div>
                                <div class="fw-bold small"><?= htmlspecialchars($appointment['purpose'] ?? 'General Checkup') ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-appointments">
                    <i class="fas fa-calendar-times"></i>
                    <h3>No appointments found</h3>
                    <p>You haven't booked any appointments yet. <a href="doctors.php">Book your first appointment</a></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>
</body>
</html>