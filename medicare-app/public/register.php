<?php
include 'components/header.php';
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
$form_values = $_SESSION['form_values'] ?? [];
?>

<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 90vh;">
        <div class="col-md-8 col-lg-7">
            <div class="bento-card">
                <div class="text-center mb-5">
                    <div class="bg-primary-light rounded-circle p-3 d-inline-block mb-3">
                        <i class="fas fa-user-plus text-primary fs-3"></i>
                    </div>
                    <h1>Create Account</h1>
                    <p class="text-muted">Join the elite medical ecosystem</p>
                </div>

                <?php if (isset($_SESSION['register_error'])): ?>
                    <div class="alert alert-danger border-0 rounded-4 py-3 mb-4" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> <?php echo $_SESSION['register_error']; unset($_SESSION['register_error']); ?>
                    </div>
                <?php endif; ?>

                <form action="auth_bridge.php" method="POST" id="registerForm">
                    <?php csrfField(); ?>
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase opacity-50">Full Name</label>
                            <input type="text" name="fullname" class="form-control bg-light border-0 py-3 px-4 rounded-4" placeholder="Saheb Paul" value="<?php echo $form_values['fullname'] ?? ''; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase opacity-50">Username</label>
                            <input type="text" name="username" class="form-control bg-light border-0 py-3 px-4 rounded-4" placeholder="Swatadru Paul" value="<?php echo $form_values['username'] ?? ''; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase opacity-50">Email Address</label>
                            <input type="email" name="email" class="form-control bg-light border-0 py-3 px-4 rounded-4" placeholder="saheb@gmail.com" value="<?php echo $form_values['email'] ?? ''; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase opacity-50">Password</label>
                            <input type="password" name="password" class="form-control bg-light border-0 py-3 px-4 rounded-4" placeholder="••••••••" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase opacity-50">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control bg-light border-0 py-3 px-4 rounded-4" placeholder="••••••••" required>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase opacity-50">Your Profile</label>
                            <div class="d-flex gap-4 p-3 border rounded-4 bg-light shadow-none border-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="rolePatient" value="patient" <?php echo (!isset($form_values['role']) || $form_values['role'] === 'patient') ? 'checked' : ''; ?>>
                                    <label class="form-check-label fw-bold" for="rolePatient">Patient</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="roleDoctor" value="doctor" <?php echo (isset($form_values['role']) && $form_values['role'] === 'doctor') ? 'checked' : ''; ?>>
                                    <label class="form-check-label fw-bold" for="roleDoctor">Doctor</label>
                                </div>
                            </div>
                        </div>

                        <!-- Doctor Specific Fields -->
                        <div id="doctorFields" style="display: <?php echo (isset($form_values['role']) && $form_values['role'] === 'doctor') ? 'block' : 'none'; ?>;" class="col-12 mt-0">
                            <div class="row g-4 mt-1">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-uppercase opacity-50">Specialization</label>
                                    <input type="text" name="specialization" class="form-control bg-light border-0 py-3 px-4 rounded-4" placeholder="Cardiology" value="<?php echo $form_values['specialization'] ?? ''; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-uppercase opacity-50">Experience (Years)</label>
                                    <input type="number" name="experience" class="form-control bg-light border-0 py-3 px-4 rounded-4" placeholder="5" value="<?php echo $form_values['experience'] ?? ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-5">
                            <button type="submit" name="register" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">Create Account</button>
                            <p class="text-center text-muted small mt-4 mb-0">Already a member? <a href="login.php" class="text-primary fw-bold text-decoration-none">Sign In</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('input[name="role"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const doctorFields = document.getElementById('doctorFields');
        if (this.value === 'doctor') {
            doctorFields.style.display = 'block';
        } else {
            doctorFields.style.display = 'none';
        }
    });
});
</script>

<?php 
unset($_SESSION['form_values']);
include 'components/footer.php'; 
?>