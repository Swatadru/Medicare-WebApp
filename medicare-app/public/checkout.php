<?php
include 'components/header.php';
require_once __DIR__ . '/../backend/config/env_loader.php';
require_once __DIR__ . '/../backend/models/Entitlement.php';
require_once __DIR__ . '/../backend/config/StripeHelper.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$planKey = $_GET['plan'] ?? 'pro';
$method = $_GET['method'] ?? 'card';
$details = Entitlement::getPlanDetails($planKey);

// Create Stripe Session if requested
if (isset($_GET['action']) && $_GET['action'] === 'initiate') {
    $stripe = new StripeHelper($_ENV['STRIPE_SECRET_KEY']);
    
    // Convert to cents (or paise if INR)
    $amount = floatval(str_replace('$', '', $details['price']));
    if ($method === 'upi') {
        // Simple conversion for demo: 1 USD = 80 INR
        $amount = $amount * 80;
    }
    $price = (int)($amount * 100);
    
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $path = str_replace('\\', '/', dirname($_SERVER['PHP_SELF']));
    $baseUrl = $protocol . "://" . $host . ($path === '/' ? '' : $path);
    
    $successUrl = $baseUrl . "/process_payment.php";
    $cancelUrl = $protocol . "://" . $host . $_SERVER['REQUEST_URI'];
    
    try {
        $session = $stripe->createCheckoutSession(
            $details['name'],
            $price,
            $successUrl,
            $cancelUrl,
            ['user_id' => $_SESSION['user_id'], 'plan' => $planKey],
            $method
        );
        
        if (isset($session['url'])) {
            header("Location: " . $session['url']);
            exit();
        } else {
            $error = "Stripe Session Error: " . ($session['error']['message'] ?? 'Unknown');
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bento-card p-0 overflow-hidden border-0 shadow-lg">
                <div class="row g-0">
                    <!-- Left: Order Summary -->
                    <div class="col-md-5 bg-light p-5 border-end">
                        <div class="mb-5">
                            <a href="subscription.php" class="text-decoration-none text-muted small fw-bold">
                                <i class="fas fa-arrow-left me-2"></i> BACK TO PLANS
                            </a>
                        </div>
                        
                        <h4 class="fw-bold mb-4">Subscription Summary</h4>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="mb-0 fw-bold text-primary"><?php echo $details['name']; ?></h5>
                                <p class="small text-muted mb-0">Monthly subscription</p>
                            </div>
                            <span class="fs-4 fw-bold"><?php echo $details['price']; ?></span>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="mb-4">
                            <h6 class="small fw-bold text-uppercase opacity-50 mb-3">What's included:</h6>
                            <ul class="list-unstyled small">
                                <?php foreach (array_slice($details['features'], 0, 4) as $feat): ?>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i> <?php echo $feat; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        
                        <div class="mt-auto pt-4 border-top border-white border-opacity-50">
                            <div class="d-flex justify-content-between align-items-center fw-bold">
                                <span>Total to pay today</span>
                                <span class="fs-3"><?php echo $details['price']; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Payment Form -->
                    <div class="col-md-7 p-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold mb-0">Secure Checkout</h3>
                            <div class="text-muted">
                                <i class="fab fa-cc-visa fa-lg me-2"></i>
                                <i class="fab fa-cc-mastercard fa-lg"></i>
                                <i class="fas fa-qrcode fa-lg ms-2"></i>
                            </div>
                        </div>

                        <!-- Payment Method Toggle -->
                        <div class="nav nav-pills mb-4 bg-light p-1 rounded-pill" id="pills-tab" role="tablist">
                            <button class="nav-link active rounded-pill flex-fill fw-bold" id="pills-card-tab" data-bs-toggle="pill" data-bs-target="#pills-card" type="button" role="tab">Credit/Debit Card</button>
                            <button class="nav-link rounded-pill flex-fill fw-bold" id="pills-upi-tab" data-bs-toggle="pill" data-bs-target="#pills-upi" type="button" role="tab">UPI Payment</button>
                        </div>

                        <div class="mt-4">
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger border-0 rounded-4 small mb-4">
                                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo htmlspecialchars($error); ?>
                                </div>
                            <?php endif; ?>

                            <!-- QR Code Section (Hidden by default, shown for UPI) -->
                            <div id="qr-section" class="text-center mb-4 d-none animate-fade-in">
                                <div class="p-4 bg-white rounded-4 border shadow-sm d-inline-block">
                                    <h6 class="fw-bold mb-3">Scan with GPay / Any UPI App</h6>
                                    <img src="assets/img/QR.jpeg" alt="GPay QR Code" class="img-fluid rounded-3 mb-3" style="max-width: 250px; border: 8px solid #f8f9fa;">
                                    <div class="small text-muted">
                                        <i class="fas fa-info-circle me-1"></i> Or click below for automated UPI checkout
                                    </div>
                                </div>
                            </div>

                            <a href="?plan=<?php echo $planKey; ?>&action=initiate&method=card" id="proceed-btn" class="btn btn-primary w-100 rounded-pill py-3 fw-bold fs-5 shadow-sm">
                                <i class="fas fa-lock me-2"></i> <span id="btn-text">Proceed to Secure Stripe Payment</span>
                            </a>

                            <p class="text-center small text-muted mt-4">
                                <i class="fas fa-shield-alt me-2 text-success"></i> You will be redirected to Stripe for encrypted transaction handling.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('[data-bs-toggle="pill"]').forEach(pill => {
    pill.addEventListener('shown.bs.tab', (e) => {
        const method = e.target.id === 'pills-card-tab' ? 'card' : 'upi';
        const proceedBtn = document.getElementById('proceed-btn');
        const qrSection = document.getElementById('qr-section');
        const btnText = document.getElementById('btn-text');
        
        // Update URL
        const currentUrl = new URL(proceedBtn.href, window.location.origin);
        currentUrl.searchParams.set('method', method);
        proceedBtn.href = currentUrl.toString();

        // Toggle QR Section
        if (method === 'upi') {
            qrSection.classList.remove('d-none');
            btnText.innerText = 'Launch UPI Payment Intent';
        } else {
            qrSection.classList.add('d-none');
            btnText.innerText = 'Proceed to Secure Stripe Payment';
        }
    });
});
</script>

<?php include 'components/footer.php'; ?>
