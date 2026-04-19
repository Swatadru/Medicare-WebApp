<?php
include 'components/header.php';
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6 col-lg-5">
            <div class="bento-card">
                <div class="text-center mb-5">
                    <div class="bg-primary-light rounded-circle p-3 d-inline-block mb-3">
                        <i class="fas fa-heartbeat text-primary fs-3"></i>
                    </div>
                    <h1>Welcome Back</h1>
                    <p class="text-muted">Secure access to your medical hub</p>
                </div>

                <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="alert alert-danger border-0 rounded-4 py-3 mb-4" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> <?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['register_success'])): ?>
                    <div class="alert alert-success border-0 rounded-4 py-3 mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i> <?php echo $_SESSION['register_success']; unset($_SESSION['register_success']); ?>
                    </div>
                <?php endif; ?>

                <form action="auth_bridge.php" method="POST">
                    <?php csrfField(); ?>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase opacity-50">Username or Email</label>
                        <input type="text" name="username" class="form-control bg-light border-0 py-3 px-4 rounded-4" placeholder="e.g. Saheb" required>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <label class="form-label fw-bold small text-uppercase opacity-50">Password</label>
                            <a href="#" class="text-primary small text-decoration-none fw-bold">Forgot?</a>
                        </div>
                        <input type="password" name="password" class="form-control bg-light border-0 py-3 px-4 rounded-4" placeholder="••••••••" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100 py-3 rounded-pill mb-4 mt-2">Sign In</button>
                    <div class="text-center">
                        <p class="text-muted small mb-0">New to Medicare? <a href="register.php" class="text-primary fw-bold text-decoration-none">Create Account</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>