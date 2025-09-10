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
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$appointments = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments | Medicare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --primary-light: #4895ef;
            --success: #38b000;
            --warning: #ff9e00;
            --danger: #ef233c;
            --light: #f8f9fa;
            --lighter: #ffffff;
            --dark: #14213d;
            --text: #2b2d42;
            --text-light: #8d99ae;
            --border: #e9ecef;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-header h1 {
            font-size: 2.2rem;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .appointments-list {
            display: grid;
            gap: 1.5rem;
        }

        .appointment-card {
            background: var(--lighter);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }

        .appointment-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }

        .appointment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .appointment-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark);
        }

        .appointment-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: rgba(255, 158, 0, 0.1);
            color: var(--warning);
        }

        .status-confirmed {
            background-color: rgba(56, 176, 0, 0.1);
            color: var(--success);
        }

        .status-cancelled {
            background-color: rgba(239, 35, 60, 0.1);
            color: var(--danger);
        }

        .appointment-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .detail-icon {
            color: var(--primary);
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        .detail-label {
            font-weight: 500;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .detail-value {
            color: var(--dark);
            font-size: 0.95rem;
        }

        .no-appointments {
            text-align: center;
            padding: 3rem;
            color: var(--text-light);
        }

        .no-appointments i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--text-light);
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }
            
            .page-header h1 {
                font-size: 1.8rem;
            }
        }
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
                    <div class="appointment-card">
                        <div class="appointment-header">
                            <h3 class="appointment-title">
                                Dr. <?= htmlspecialchars($appointment['doctor_name']) ?> - <?= htmlspecialchars($appointment['specialization']) ?>
                            </h3>
                            <span class="appointment-status status-<?= strtolower($appointment['status'] ?? 'pending') ?>">
                                <?= ucfirst($appointment['status'] ?? 'Pending') ?>
                            </span>
                        </div>
                        
                        <div class="appointment-details">
                            <div class="detail-item">
                                <span class="detail-icon"><i class="fas fa-calendar-day"></i></span>
                                <div>
                                    <div class="detail-label">Date</div>
                                    <div class="detail-value"><?= date('F j, Y', strtotime($appointment['appointment_date'])) ?></div>
                                </div>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-icon"><i class="fas fa-clock"></i></span>
                                <div>
                                    <div class="detail-label">Time</div>
                                    <div class="detail-value"><?= date('g:i A', strtotime($appointment['appointment_time'])) ?></div>
                                </div>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-icon"><i class="fas fa-stethoscope"></i></span>
                                <div>
                                    <div class="detail-label">Purpose</div>
                                    <div class="detail-value"><?= htmlspecialchars($appointment['purpose'] ?? 'General Checkup') ?></div>
                                </div>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-icon"><i class="fas fa-info-circle"></i></span>
                                <div>
                                    <div class="detail-label">Notes</div>
                                    <div class="detail-value"><?= !empty($appointment['notes']) ? htmlspecialchars($appointment['notes']) : 'None' ?></div>
                                </div>
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