<?php
$page_title = "Contact Support - Medicare";
include 'components/header.php';

$success = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        // Here you would typically save to DB or send an email
        $success = "Thank you, $name. Your message has been received! We will get back to you shortly.";
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card p-5 border-0 shadow-soft">
                <div class="text-center mb-5">
                    <div class="fs-1 text-primary mb-3"><i class="fas fa-headset"></i></div>
                    <h1 class="mb-2">Support Hub</h1>
                    <p class="text-body fs-5">How can our professional team assist you today?</p>
                </div>

                <?php if ($success): ?>
                    <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                        <i class="fas fa-check-circle me-2 fs-4"></i>
                        <div><?php echo $success; ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                        <i class="fas fa-exclamation-triangle me-2 fs-4"></i>
                        <div><?php echo $error; ?></div>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Your Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Saheb Paul" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Your Email</label>
                        <input type="email" name="email" class="form-control" placeholder="saheb@gmail.com" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">How can we help you?</label>
                        <textarea name="message" class="form-control" rows="5" placeholder="Describe your issue or question..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">Send Message</button>
                </form>
            </div>
            
            <div class="row g-3 mt-4">
                <div class="col-sm-6">
                    <div class="card p-3 border-0 shadow-sm text-center">
                        <i class="fas fa-phone text-muted mb-2"></i>
                        <h6 class="mb-1">Call Us</h6>
                        <p class="small text-muted mb-0">+91 9330776539</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card p-3 border-0 shadow-sm text-center">
                        <i class="fas fa-envelope text-muted mb-2"></i>
                        <h6 class="mb-1">Email Us</h6>
                        <p class="small text-muted mb-0">info@medicare.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>