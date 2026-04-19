<?php
include 'components/header.php';
require_once __DIR__ . '/../backend/config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Fetch user info
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Fetch appointments based on role
if ($role === 'doctor') {
    $stmt = $conn->prepare("SELECT a.*, u.fullname as patient_name 
                           FROM appointments a 
                           JOIN users u ON a.user_id = u.id 
                           WHERE a.doctor_id = ? 
                           ORDER BY a.appointment_date DESC, a.appointment_time DESC");
} else {
    $stmt = $conn->prepare("SELECT a.*, d.name as doctor_name, d.specialization 
                           FROM appointments a 
                           JOIN doctors d ON a.doctor_id = d.id 
                           WHERE a.user_id = ? 
                           ORDER BY a.appointment_date DESC, a.appointment_time DESC");
}
$stmt->execute([$userId]);
$appointments = $stmt->fetchAll();
?>

<div class="container py-5">
    <?php if (isset($_GET['payment']) && $_GET['payment'] === 'success'): ?>
        <div class="alert alert-success rounded-4 border-0 shadow-sm p-4 mb-5 d-flex align-items-center animate-fade-in">
            <div class="bg-success rounded-circle p-2 me-3">
                <i class="fas fa-check text-white"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold">Payment Successful!</h5>
                <p class="mb-0 opacity-75 small">Your <strong>Lumina <?php echo ucfirst(htmlspecialchars($_GET['plan'])); ?></strong> activation is complete.</p>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'downgrade_success'): ?>
        <div class="alert alert-info rounded-4 border-0 shadow-sm p-4 mb-5 d-flex align-items-center">
            <i class="fas fa-info-circle me-3 fs-4"></i>
            <div>
                <h5 class="mb-0 fw-bold">Plan Updated</h5>
                <p class="mb-0 opacity-75 small">You have successfully returned to the Basic tier.</p>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Bento Dashboard Header -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="dashboard-header h-100 d-flex flex-column justify-content-center">
                <h1 class="mb-2">Hello, <?php echo htmlspecialchars($user['fullname']); ?></h1>
                <p class="fs-5 opacity-75 mb-0">
                    <?php echo ($role === 'doctor') ? 'Your clinical schedule is synchronized and ready.' : 'Welcome back to your personalized health hub.'; ?>
                </p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="bento-card h-100 d-flex flex-column justify-content-center bg-white">
                <h6 class="text-uppercase small fw-bold text-muted mb-3">Quick Profile</h6>
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary-light rounded-circle p-2 me-3">
                        <i class="fas fa-user text-primary"></i>
                    </div>
                    <span class="fw-bold"><?php echo htmlspecialchars($user['fullname']); ?></span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary-light rounded-circle p-2 me-3">
                        <i class="fas fa-id-badge text-primary"></i>
                    </div>
                    <span class="text-muted small capitalize"><?php echo ucfirst($role); ?></span>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary-light rounded-circle p-2 me-3">
                        <i class="fas fa-crown text-primary"></i>
                    </div>
                    <span class="fw-bold text-primary small"><?php echo ucfirst($user['subscription_plan']); ?> Plan</span>
                </div>
                <div class="d-grid gap-2">
                    <a href="subscription.php" class="btn btn-primary btn-sm rounded-pill">Manage Plan</a>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill">Logout Account</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment Section -->
    <div class="bento-card bg-white p-0 overflow-hidden mb-5">
        <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><?php echo ($role === 'doctor') ? 'Consultation Queue' : 'My Schedule'; ?></h3>
            <?php if ($role === 'patient'): ?>
                <a href="doctors.php" class="btn btn-primary btn-sm">New Appointment</a>
            <?php endif; ?>
        </div>
        
        <div class="appointment-list">
            <?php if (count($appointments) > 0): ?>
                <?php foreach ($appointments as $app): ?>
                    <div class="appointment-item d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-4">
                            <div class="text-center bg-primary-light rounded-4 p-3" style="min-width: 80px;">
                                <div class="fw-bold text-primary small uppercase"><?php echo date('M', strtotime($app['appointment_date'])); ?></div>
                                <div class="fs-3 fw-bold text-primary"><?php echo date('d', strtotime($app['appointment_date'])); ?></div>
                            </div>
                            <div>
                                <h5 class="mb-1">
                                    <?php echo ($role === 'doctor') ? htmlspecialchars($app['patient_name']) : htmlspecialchars($app['doctor_name']); ?>
                                </h5>
                                <div class="text-muted small">
                                    <i class="fas fa-clock me-2"></i> <?php echo $app['appointment_time']; ?>
                                    <?php if ($role === 'patient'): ?>
                                        <span class="mx-2">|</span> <i class="fas fa-stethoscope me-2"></i> <?php echo htmlspecialchars($app['specialization']); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center gap-3">
                            <?php 
                                $statusClass = 'bg-warning text-dark';
                                if ($app['status'] === 'confirmed') $statusClass = 'bg-success text-white';
                                if ($app['status'] === 'cancelled') $statusClass = 'bg-danger text-white';
                            ?>
                            <span class="status-pill <?php echo $statusClass; ?>">
                                <?php echo ucfirst($app['status']); ?>
                            </span>

                            <?php if ($app['status'] !== 'cancelled'): ?>
                                <?php if ($user['subscription_plan'] !== 'basic' || $role === 'doctor'): ?>
                                    <a href="appointment_chat.php?appointment_id=<?php echo $app['id']; ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold">
                                        <i class="fas fa-comment-medical me-1"></i> Chat
                                    </a>
                                <?php else: ?>
                                    <a href="subscription.php" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold opacity-50" title="Upgrade to Professional to unlock Chat">
                                        <i class="fas fa-lock me-1"></i> Chat
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div class="dropdown">
                                <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4">
                                    <li><a class="dropdown-item py-2" href="appointment_details.php?id=<?php echo $app['id']; ?>">Details</a></li>
                                    <?php if ($app['status'] === 'pending'): ?>
                                        <?php if ($role === 'doctor'): ?>
                                            <li><a class="dropdown-item py-2 text-success" href="appointment_actions.php?action=confirm&id=<?php echo $app['id']; ?>&csrf_token=<?php echo generateCsrfToken(); ?>">Confirm</a></li>
                                        <?php endif; ?>
                                        <li><a class="dropdown-item py-2 text-danger" href="appointment_actions.php?action=cancel&id=<?php echo $app['id']; ?>&csrf_token=<?php echo generateCsrfToken(); ?>">Cancel</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="p-5 text-center">
                    <p class="text-muted mb-0">No entries in your queue today.</p>
                </div>
            <?php endif; ?>
        </div>
    <!-- Elite Exclusive: Neural Analytics Hub -->
    <?php if ($user['subscription_plan'] === 'elite'): ?>
        <div class="bento-card elite-analytics-card p-5 mb-5 border-0">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-warning rounded-circle p-2 me-3">
                            <i class="fas fa-brain text-dark"></i>
                        </div>
                        <h2 class="mb-0 fw-bold" style="color: #fbbf24;">Neural Analytics Hub</h2>
                    </div>
                    <p class="opacity-75 mb-5 fs-5">Active biotelemetry monitoring in sync with your clinical profile. Real-time data processing enabled.</p>
                    
                    <div class="row g-4 mb-2">
                        <div class="col-md-6">
                            <div class="small fw-bold text-uppercase opacity-50 mb-1">Neural Sync</div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="fs-4 fw-bold">98.2%</span>
                                <div class="health-bar-container flex-grow-1">
                                    <div class="health-bar-fill" style="width: 98%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="small fw-bold text-uppercase opacity-50 mb-1">Cardiac Precision</div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="fs-4 fw-bold">72 BPM</span>
                                <div class="health-bar-container flex-grow-1">
                                    <div class="health-bar-fill" style="width: 72%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="small fw-bold text-uppercase opacity-50 mb-1">Recovery Index</div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="fs-4 fw-bold">Optimum</span>
                                <div class="health-bar-container flex-grow-1">
                                    <div class="health-bar-fill" style="width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="small fw-bold text-uppercase opacity-50 mb-1">System Integrity</div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="fs-4 fw-bold">99.9%</span>
                                <div class="health-bar-container flex-grow-1">
                                    <div class="health-bar-fill" style="width: 99.9%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center d-none d-lg-block">
                    <i class="fas fa-microchip fa-10x opacity-10 text-warning floating-icon"></i>
                </div>
            </div>
        </div>
        <style>
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
                100% { transform: translateY(0px); }
            }
            .floating-icon {
                animation: float 6s ease-in-out infinite;
            }
        </style>
    <?php endif; ?>
</div>

<?php include 'components/footer.php'; ?>