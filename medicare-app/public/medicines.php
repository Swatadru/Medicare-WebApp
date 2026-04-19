<?php
include 'components/header.php';
require_once '../backend/controllers/medicineController.php'; 
?>

<div class="container py-5">
    <!-- Header Section -->
    <div class="dashboard-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-7">
                <span class="badge bg-primary text-white rounded-pill px-3 py-1 mb-3">Pharmacopeia Knowledge</span>
                <h1 class="display-5 mb-0">Medicine Hub</h1>
                <p class="fs-5 text-muted mt-2">Professional resource for drug interactions and guidance</p>
            </div>
            <div class="col-md-5">
                <form action="medicines.php" method="GET" class="d-flex align-items-center gap-2 bg-white p-2 rounded-pill border shadow-sm">
                    <input type="text" name="search" class="form-control border-0 bg-transparent px-4" placeholder="Search medicines..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Search</button>
                    <?php if (!empty($searchQuery)): ?>
                        <a href="medicines.php" class="btn btn-outline-secondary rounded-pill px-3 border-0"><i class="fas fa-times"></i></a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <!-- Medicine Grid -->
    <div class="row g-4" id="medicineContainer">
        <?php if (count($medicines) > 0): ?>
            <?php foreach ($medicines as $index => $med): ?>
                <div class="col-md-6 col-lg-3 medicine-card-item" style="<?php echo ($index >= 8) ? 'display: none;' : ''; ?>">
                    <div class="bento-card h-100 p-0 overflow-hidden d-flex flex-column">
                        <div class="ratio ratio-16x9">
                            <img src="<?php echo $med['image'] ?: 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&q=80&w=400'; ?>" 
                                 class="object-fit-cover" 
                                 alt="<?php echo htmlspecialchars($med['name']); ?>">
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column">
                            <span class="text-uppercase small fw-bold text-primary mb-2 opacity-75"><?php echo htmlspecialchars($med['category']); ?></span>
                            <h4 class="fw-bold mb-3"><?php echo htmlspecialchars($med['name']); ?></h4>
                            <p class="text-muted small leading-snug mb-4 line-clamp-2">
                                <?php echo htmlspecialchars($med['description']); ?>
                            </p>
                            <div class="mt-auto">
                                <?php 
                                $userPlan = $_SESSION['subscription_plan'] ?? 'basic';
                                if ($userPlan !== 'basic' || ($_SESSION['role'] ?? '') === 'doctor'): ?>
                                    <a href="medicine_details.php?id=<?php echo $med['id']; ?>" class="btn btn-outline-primary w-100 rounded-pill fw-bold">View Guidelines</a>
                                <?php else: ?>
                                    <a href="subscription.php" class="btn btn-outline-secondary w-100 rounded-pill fw-bold opacity-75" title="Professional Feature">
                                        <i class="fas fa-lock me-2"></i> Pro Feature
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="bg-primary-light rounded-circle p-4 d-inline-block mb-3">
                    <i class="fas fa-pills text-primary fs-1"></i>
                </div>
                <h4 class="text-muted">No medication matches your search.</h4>
                <a href="medicines.php" class="text-primary fw-bold">Reset Filters</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- View More Button -->
    <?php if (count($medicines) > 8): ?>
        <div class="text-center mt-5" id="loadMoreSection">
            <button id="loadMoreBtn" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-sm">
                View More Medicines <i class="fas fa-chevron-down ms-2"></i>
            </button>
        </div>
    <?php endif; ?>
</div>

<script>
document.getElementById('loadMoreBtn')?.addEventListener('click', function() {
    const hiddenCards = document.querySelectorAll('.medicine-card-item[style*="display: none"]');
    const itemsToShow = 8;
    
    for (let i = 0; i < itemsToShow && i < hiddenCards.length; i++) {
        hiddenCards[i].style.display = 'block';
    }
    
    // Hide button if no more hidden cards
    if (document.querySelectorAll('.medicine-card-item[style*="display: none"]').length === 0) {
        document.getElementById('loadMoreSection').style.display = 'none';
    }
});
</script>

<?php include 'components/footer.php'; ?>
