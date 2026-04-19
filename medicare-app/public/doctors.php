<?php
include 'components/header.php';
require_once '../backend/controllers/doctorController.php'; // This populates $doctors
?>

<div class="container py-5">
    <div class="dashboard-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-7">
                <span class="badge bg-primary text-white rounded-pill px-3 py-1 mb-3">Professional Directory</span>
                <h1 class="display-5 mb-0">Our Medical Experts</h1>
                <p class="fs-5 text-muted mt-2">Find the best specialist for your health needs</p>
            </div>
            <div class="col-md-5">
                <form action="doctors.php" method="GET" class="d-flex gap-2 bg-white p-2 rounded-pill border shadow-sm">
                    <input type="text" name="specialization" class="form-control border-0 bg-transparent px-4" placeholder="Search specialization..." value="<?php echo htmlspecialchars($specialization); ?>">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Search</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <?php if (count($doctors) > 0): ?>
            <?php foreach ($doctors as $doctor): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 doctor-card <?php echo ($doctor['is_elite']) ? 'border-elite' : ''; ?>">
                        <?php if ($doctor['is_elite']): ?>
                            <div class="elite-badge-overlay">
                                <i class="fas fa-crown me-1"></i> VERIFIED EXPERT
                            </div>
                        <?php endif; ?>
                        
                        <img src="<?php echo $doctor['image'] ?: 'https://images.unsplash.com/photo-1559839734-2b71f153673f?auto=format&fit=crop&q=80&w=400'; ?>" alt="<?php echo htmlspecialchars($doctor['name']); ?>">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title fw-bold mb-0"><?php echo htmlspecialchars($doctor['name']); ?></h5>
                                <span class="badge-spec"><?php echo htmlspecialchars($doctor['specialization']); ?></span>
                            </div>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-briefcase me-2"></i> <?php echo $doctor['experience']; ?> Years Experience
                            </p>
                            <p class="text-muted small mb-4">
                                <i class="fas fa-envelope me-2"></i> <?php echo htmlspecialchars($doctor['contact']); ?>
                            </p>
                            <div class="d-grid gap-2">
                                <a href="doctor_profile.php?id=<?php echo $doctor['id']; ?>" class="btn btn-outline-primary w-100 rounded-pill fw-bold">View Profile</a>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'doctor'): ?>
                                    <button class="btn btn-light w-100 rounded-pill fw-bold" disabled>Private Access</button>
                                <?php elseif ($doctor['is_elite'] && ($_SESSION['subscription_plan'] ?? 'basic') !== 'elite'): ?>
                                    <a href="subscription.php" class="btn btn-elite w-100 rounded-pill fw-bold">
                                        <i class="fas fa-lock me-2"></i> Elite Perk
                                    </a>
                                <?php else: ?>
                                    <a href="book.php?doctor_id=<?php echo $doctor['id']; ?>" class="btn btn-primary w-100 rounded-pill fw-bold">Book Now</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-user-md text-muted fs-1 mb-3 opacity-25"></i>
                <h4 class="text-muted">No doctors found matching your search.</h4>
                <a href="doctors.php" class="text-primary fw-bold">View All Doctors</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'components/footer.php'; ?>