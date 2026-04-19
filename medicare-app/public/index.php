<?php
include 'components/header.php';
?>

<main class="container py-5">
    <!-- Bento Hero Section -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="bento-card bg-primary-light h-100 d-flex flex-column justify-content-center p-5">
                <span class="badge bg-primary text-white rounded-pill px-3 py-2 mb-4 d-inline-block w-auto" style="width: fit-content;">Innovation in Care</span>
                <h1 class="display-3 mb-4">Your Health, <br><span class="text-primary">Evolved.</span></h1>
                <p class="lead text-body mb-5">Experience a new era of healthcare management. Effortless bookings, elite specialists, and secure records in one vibrant workspace.</p>
                <div class="d-flex gap-3">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="dashboard.php" class="btn btn-primary px-5">Go to Dashboard</a>
                    <?php else: ?>
                        <a href="register.php" class="btn btn-primary px-5">Start Journey</a>
                        <a href="doctors.php" class="btn btn-outline-primary px-5">Meet Specialists</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="row g-4 h-100">
                <div class="col-12">
                    <div class="bento-card h-100 d-flex flex-column justify-content-center text-center">
                        <h2 class="text-primary mb-1">500+</h2>
                        <p class="text-muted mb-0 fw-bold uppercase small tracking-widest">Medical Experts</p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="bento-card h-100 d-flex flex-column justify-content-center text-center bg-dark text-white border-0">
                        <i class="fas fa-bolt text-warning fs-3 mb-3"></i>
                        <h4 class="mb-0">Instant<br>Consulations</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="bento-card h-100">
                <div class="bg-primary-light rounded-circle p-3 d-inline-block mb-4">
                    <i class="fas fa-calendar-check text-primary fs-4"></i>
                </div>
                <h3>Smart Scheduling</h3>
                <p class="text-body mt-3">Book appointments with zero friction. Our AI-driven system finds the perfect slot for your busy life.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bento-card h-100">
                <div class="bg-primary-light rounded-circle p-3 d-inline-block mb-4">
                    <i class="fas fa-shield-alt text-primary fs-4"></i>
                </div>
                <h3>Secure Records</h3>
                <p class="text-body mt-3">Your medical history, protected by military-grade encryption. Accessible only to you and your doctors.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bento-card h-100">
                <div class="bg-primary-light rounded-circle p-3 d-inline-block mb-4">
                    <i class="fas fa-user-md text-primary fs-4"></i>
                </div>
                <h3>Expert Network</h3>
                <p class="text-body mt-3">Curated access to the region's top specialists across all medical disciplines.</p>
            </div>
        </div>
    </div>
</main>

<?php include 'components/footer.php'; ?>