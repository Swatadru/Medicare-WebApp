<?php
include 'components/header.php';
require_once __DIR__ . '/../backend/config/db.php';
require_once __DIR__ . '/../backend/models/Doctor.php';

$doctorId = $_GET['id'] ?? null;
$doctorModel = new Doctor($conn);
$doctor = $doctorModel->findById($doctorId);

if (!$doctor) {
    echo "<div class='container py-5 text-center'><h1>Specialist not found.</h1><a href='doctors.php' class='btn btn-primary mt-4'>Back to Directory</a></div>";
    include 'components/footer.php';
    exit();
}
?>

<div class="container py-5">
    <!-- Breadcrumb -->
    <nav class="mb-5">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="doctors.php">Specialists</a></li>
            <li class="breadcrumb-item active"><?php echo htmlspecialchars($doctor['name']); ?></li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Hero Section - Bento Style -->
        <div class="col-lg-5">
            <div class="bento-card p-0 overflow-hidden h-100">
                <img src="<?php echo $doctor['image'] ?: 'https://images.unsplash.com/photo-1559839734-2b71f153673f?auto=format&fit=crop&q=80&w=600'; ?>" 
                     class="img-fluid w-100 h-100 object-fit-cover" 
                     style="min-height: 500px;" 
                     alt="<?php echo htmlspecialchars($doctor['name']); ?>">
            </div>
        </div>

        <div class="col-lg-7">
            <div class="d-flex flex-column h-100 gap-4">
                <!-- Name & Spec Card -->
                <div class="bento-card bg-primary-light">
                    <span class="badge bg-primary text-white rounded-pill px-3 py-1 mb-3">Verified Specialist</span>
                    <h1 class="display-4 text-primary mb-2"><?php echo htmlspecialchars($doctor['name']); ?></h1>
                    <h4 class="text-body opacity-75"><?php echo htmlspecialchars($doctor['specialization']); ?> | <?php echo $doctor['experience']; ?> Years Excellence</h4>
                </div>

                <!-- Bio Card -->
                <div class="bento-card flex-grow-1">
                    <h5 class="text-uppercase small fw-bold text-muted mb-4 tracking-widest">Professional Biography</h5>
                    <p class="fs-5 text-body leading-relaxed mb-0">
                        <?php echo nl2br(htmlspecialchars($doctor['bio'] ?: 'A dedicated professional committed to providing the highest quality of clinical care to every patient.')); ?>
                    </p>
                </div>

                <!-- Contact & Booking -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="bento-card h-100 p-4">
                            <h6 class="text-muted small uppercase mb-3">Availability</h6>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt text-primary me-3 fs-4"></i>
                                <span class="fw-bold"><?php echo htmlspecialchars($doctor['availability'] ?: 'Mon - Fri'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bento-card h-100 p-4">
                            <h6 class="text-muted small uppercase mb-3">Contact Support</h6>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-envelope text-primary me-3 fs-4"></i>
                                <span class="small"><?php echo htmlspecialchars($doctor['contact_email']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-2">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'doctor'): ?>
                        <button class="btn btn-outline-secondary w-100 py-3 rounded-pill fw-bold" disabled>Doctor View Only</button>
                    <?php else: ?>
                        <a href="book.php?doctor_id=<?php echo $doctor['id']; ?>" class="btn btn-primary w-100 py-3 rounded-pill fw-bold fs-5 shadow-sm">
                            <i class="fas fa-calendar-plus me-2"></i> Instant Booking
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>
