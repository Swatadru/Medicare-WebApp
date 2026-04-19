<?php
include 'components/header.php';
require_once __DIR__ . '/../backend/config/db.php';
require_once __DIR__ . '/../backend/controllers/appointmentController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$appointmentId = $_GET['id'] ?? null;
$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];

$controller = new AppointmentController($conn);
$details = $controller->getDetails($appointmentId, $userId, $role);

if (!$details) {
    echo "<div class='container py-5 text-center'><h3>Appointment not found or unauthorized.</h3><a href='dashboard.php' class='btn btn-primary mt-3'>Back to Dashboard</a></div>";
    include 'components/footer.php';
    exit();
}
?>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Appointment Details</li>
        </ol>
    </nav>

    <div class="row g-4 justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
                    <div>
                        <span class="badge-spec mb-2 d-inline-block">Consultation Details</span>
                        <h1 class="display-5 mb-0">Ref: #<?php echo str_pad($details['id'], 5, '0', STR_PAD_LEFT); ?>
                        </h1>
                    </div>
                    <?php
                    $statusClass = 'bg-warning text-dark';
                    if ($details['status'] === 'confirmed')
                        $statusClass = 'bg-success text-white';
                    if ($details['status'] === 'cancelled')
                        $statusClass = 'bg-danger text-white';
                    ?>
                    <span class="badge <?php echo $statusClass; ?> rounded-pill px-4 py-2 fs-6">
                        <?php echo ucfirst($details['status']); ?>
                    </span>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-sm-6">
                        <h6 class="text-uppercase small fw-bold opacity-50 mb-3">Schedule</h6>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-calendar-alt text-primary me-3 fs-5"></i>
                            <span
                                class="fs-5 fw-bold"><?php echo date('F j, Y', strtotime($details['appointment_date'])); ?></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock text-primary me-3 fs-5"></i>
                            <span class="fs-5"><?php echo $details['appointment_time']; ?></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h6 class="text-uppercase small fw-bold opacity-50 mb-3">
                            <?php echo ($role === 'doctor') ? 'Patient Information' : 'Specialist Information'; ?>
                        </h6>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-user-md text-primary me-3 fs-5"></i>
                            <span
                                class="fs-5 fw-bold"><?php echo htmlspecialchars($role === 'doctor' ? $details['patient_name'] : $details['doctor_name']); ?></span>
                        </div>
                        <?php if ($role === 'patient'): ?>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-stethoscope text-primary me-3 fs-5"></i>
                                <span
                                    class="fs-5 text-muted"><?php echo htmlspecialchars($details['specialization']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="p-4 bg-light rounded-4 mb-5">
                    <h6 class="text-uppercase small fw-bold opacity-50 mb-3">Consultation Purpose</h6>
                    <p class="fs-5 mb-0">
                        <?php echo nl2br(htmlspecialchars($details['purpose'] ?: 'No purpose provided.')); ?></p>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <?php if ($details['status'] === 'pending'): ?>
                        <?php if ($role === 'doctor'): ?>
                            <a href="appointment_actions.php?action=confirm&id=<?php echo $details['id']; ?>"
                                class="btn btn-primary px-5">Confirm Appointment</a>
                        <?php endif; ?>
                        <a href="appointment_actions.php?action=cancel&id=<?php echo $details['id']; ?>"
                            class="btn btn-outline-danger px-5"
                            onclick="return confirm('Cancel this appointment?')">Cancel</a>
                    <?php endif; ?>
                    <a href="dashboard.php" class="btn btn-outline-secondary px-4">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>