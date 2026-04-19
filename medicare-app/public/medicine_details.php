<?php
include 'components/header.php';
require_once __DIR__ . '/../backend/config/db.php';
require_once __DIR__ . '/../backend/models/Medicine.php';

$medicineId = $_GET['id'] ?? null;
$medicineModel = new Medicine($conn);
$medicine = $medicineModel->findById($medicineId);

if (!$medicine) {
    echo "<div class='container py-5 text-center'><h1>Medicine record not found.</h1><a href='medicines.php' class='btn btn-primary mt-4'>Back to Hub</a></div>";
    include 'components/footer.php';
    exit();
}
?>

<div class="container py-5">
    <!-- Breadcrumb -->
    <nav class="mb-5">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="medicines.php">Medicine Hub</a></li>
            <li class="breadcrumb-item active"><?php echo htmlspecialchars($medicine['name']); ?></li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-lg-5">
            <div class="bento-card p-0 overflow-hidden d-flex align-items-center justify-content-center bg-white" style="height: 400px;">
                <img src="<?php echo $medicine['image'] ?: 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&q=80&w=600'; ?>" 
                     class="img-fluid object-fit-contain p-4" 
                     alt="<?php echo htmlspecialchars($medicine['name']); ?>">
            </div>
            
            <div class="bento-card mt-4 bg-primary-light">
                <h6 class="text-uppercase small fw-bold text-primary mb-3">Pharmacology Summary</h6>
                <p class="mb-0 fs-5 leading-relaxed"><?php echo htmlspecialchars($medicine['description']); ?></p>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="d-flex flex-column gap-4">
                <!-- Header Card -->
                <div class="bento-card border-primary border-start border-5">
                    <span class="badge bg-primary text-white rounded-pill px-3 py-1 mb-2">Detailed Monograph</span>
                    <h1 class="display-4 fw-bold text-dark mb-1"><?php echo htmlspecialchars($medicine['name']); ?></h1>
                    <p class="text-muted fw-bold"><?php echo htmlspecialchars($medicine['category']); ?></p>
                </div>

                <!-- Usefulness Card -->
                <div class="bento-card bg-success-light">
                    <div class="d-flex align-items-center mb-3 text-success">
                        <i class="fas fa-check-circle fs-4 me-2"></i>
                        <h5 class="mb-0 fw-bold">Clinical Usefulness</h5>
                    </div>
                    <p class="fs-5 mb-0"><?php echo nl2br(htmlspecialchars($medicine['usefulness'])); ?></p>
                </div>

                <!-- Indications (Who can use) Card -->
                <div class="bento-card">
                    <div class="d-flex align-items-center mb-3 text-primary">
                        <i class="fas fa-user-check fs-4 me-2"></i>
                        <h5 class="mb-0 fw-bold">Target Indications</h5>
                    </div>
                    <p class="fs-5 mb-0"><?php echo nl2br(htmlspecialchars($medicine['who_can_use'])); ?></p>
                </div>

                <!-- Side Effects Card -->
                <div class="bento-card border-danger border-start border-5">
                    <div class="d-flex align-items-center mb-3 text-danger">
                        <i class="fas fa-exclamation-triangle fs-4 me-2"></i>
                        <h5 class="mb-0 fw-bold">Safety & Side Effects</h5>
                    </div>
                    <p class="fs-5 mb-0"><?php echo nl2br(htmlspecialchars($medicine['side_effects'])); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-success-light { background-color: rgba(40, 167, 69, 0.05); }
</style>

<?php include 'components/footer.php'; ?>
