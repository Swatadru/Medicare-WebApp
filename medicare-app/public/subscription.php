<?php
include 'components/header.php';
require_once __DIR__ . '/../backend/config/db.php';
require_once __DIR__ . '/../backend/models/Entitlement.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$successMsg = '';

// Handle Plan Selection (Redirect to Checkout)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upgrade_plan'])) {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        header("Location: subscription.php?error=csrf_expired");
        exit();
    }
    $targetPlan = $_POST['upgrade_plan'];
    // For 'basic' plan (downgrade/reset), we might just allow it directly or send to a confirm page.
    // For paid plans, redirect to checkout.
    if ($targetPlan === 'basic') {
        $stmt = $conn->prepare("UPDATE users SET subscription_plan = 'basic' WHERE id = ?");
        if ($stmt->execute([$userId])) {
            $_SESSION['subscription_plan'] = 'basic';
            header("Location: dashboard.php?msg=downgrade_success");
            exit();
        }
    } else {
        header("Location: checkout.php?plan=" . urlencode($targetPlan));
        exit();
    }
}

// Fetch current user data
$stmt = $conn->prepare("SELECT subscription_plan FROM users WHERE id = ?");
$stmt->execute([$userId]);
$userData = $stmt->fetch();
$currentPlan = $userData['subscription_plan'] ?? 'basic';

$allPlans = ['basic', 'pro', 'elite'];
?>

<div class="container py-5">
    <!-- Header -->
    <div class="mb-5 text-center">
        <span class="badge bg-primary-light text-primary rounded-pill px-3 py-2 mb-3">Medicare Premium Hub</span>
        <h1 class="display-4 fw-bold mb-3">Elevate Your Care Experience</h1>
        <p class="fs-5 text-muted">Choose the orchestration level that matches your health journey.</p>
    </div>

    <?php if ($successMsg): ?>
        <div class="alert alert-success rounded-4 border-0 shadow-sm p-4 mb-5 d-flex align-items-center">
            <i class="fas fa-check-circle me-3 fs-3"></i>
            <div>
                <h5 class="mb-0 fw-bold"><?php echo $successMsg; ?></h5>
                <p class="mb-0 opacity-75 small">Your new entitlements are now active across the platform.</p>
            </div>
            <a href="dashboard.php" class="btn btn-dark btn-sm ms-auto rounded-pill px-4">Back to Dashboard</a>
        </div>
    <?php endif; ?>

    <!-- Pricing Grid -->
    <div class="row g-4 align-items-stretch">
        <?php foreach ($allPlans as $planKey): 
            $details = Entitlement::getPlanDetails($planKey);
            $isCurrent = ($currentPlan === $planKey);
            $isPopular = ($planKey === 'pro');
        ?>
            <div class="col-lg-4">
                <div class="bento-card h-100 p-5 d-flex flex-column <?php echo $isPopular ? 'border-primary shadow-lg' : ''; ?>" 
                     style="<?php echo $isPopular ? 'border-width: 2px;' : ''; ?>">
                    
                    <?php if ($isPopular): ?>
                        <div class="mb-3"><span class="badge bg-primary rounded-pill">MOST VALUABLE</span></div>
                    <?php endif; ?>

                    <h4 class="fw-bold mb-1"><?php echo $details['name']; ?></h4>
                    <p class="small text-muted mb-4"><?php echo $details['description']; ?></p>
                    
                    <div class="d-flex align-items-baseline mb-4">
                        <span class="fs-1 fw-bold"><?php echo $details['price']; ?></span>
                        <?php if ($planKey !== 'basic'): ?>
                            <span class="text-muted ms-2">/ month</span>
                        <?php endif; ?>
                    </div>

                    <hr class="mb-4 opacity-50">

                    <ul class="list-unstyled flex-grow-1 mb-5">
                        <?php foreach ($details['features'] as $feat): ?>
                            <li class="mb-3 d-flex align-items-center">
                                <i class="fas fa-check-circle text-primary me-3"></i>
                                <span><?php echo $feat; ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <?php if ($isCurrent): ?>
                        <button class="btn btn-outline-secondary w-100 rounded-pill py-3 fw-bold no-hover" disabled>
                            <i class="fas fa-check me-2"></i> Current Plan
                        </button>
                    <?php else: ?>
                        <form method="POST">
                            <?php csrfField(); ?>
                            <input type="hidden" name="upgrade_plan" value="<?php echo $planKey; ?>">
                            <button type="submit" class="btn <?php echo $isPopular ? 'btn-primary' : 'btn-outline-primary'; ?> w-100 rounded-pill py-3 fw-bold">
                                <?php echo ($planKey === 'basic') ? 'Downgrade' : (($currentPlan === 'basic') ? 'Upgrade Now' : 'Change Plan'); ?>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.bento-card.border-primary {
    transform: scale(1.03);
    z-index: 1;
}
.no-hover:hover {
    transform: none !important;
    background-color: transparent !important;
}
</style>

<?php include 'components/footer.php'; ?>