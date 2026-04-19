<?php
include 'components/header.php';
require_once __DIR__ . '/../backend/config/db.php';
require_once __DIR__ . '/../backend/models/Doctor.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$doctorId = $_GET['doctor_id'] ?? null;
if (!$doctorId) {
    header("Location: doctors.php");
    exit();
}

$doctorModel = new Doctor($conn);
$doctor = $doctorModel->findById($doctorId);

if (!$doctor) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Doctor not found.</div></div>";
    include 'components/footer.php';
    exit();
}

// Elite Gating Logic
if ($doctor['is_elite'] && ($_SESSION['subscription_plan'] ?? 'basic') !== 'elite') {
    header("Location: subscription.php?msg=elite_required");
    exit();
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?php echo $doctor['image'] ?: 'https://imgs.search.brave.com/5lVpSj5m1fQJ9y9_a8_H_7lX_2F0t_a6F4g/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzAyLzQ4LzkyLzE1/LzM2MF9GXzI0ODky/MTU1N18zSm1rN08y/VFF0dklzUXJ4OHE0/NlJqTFRmUnlsWTRM/OS5qcGc'; ?>" 
                             class="img-fluid rounded-start h-100 object-fit-cover" 
                             alt="<?php echo htmlspecialchars($doctor['name']); ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body p-4">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-4">
                                    <li class="breadcrumb-item"><a href="doctors.php" class="text-decoration-none">Doctors</a></li>
                                    <li class="breadcrumb-item active">Book Appointment</li>
                                </ol>
                            </nav>

                            <h3 class="fw-bold mb-1"><?php echo htmlspecialchars($doctor['name']); ?></h3>
                            <p class="badge-spec d-inline-block mb-3"><?php echo htmlspecialchars($doctor['specialization']); ?></p>
                            
                            <hr class="my-4">

                            <?php if (isset($_GET['error'])): ?>
                                <div class="alert alert-danger small py-2 mb-4">
                                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo htmlspecialchars($_GET['error']); ?>
                                </div>
                            <?php endif; ?>

                            <form action="booking_bridge.php" method="POST">
                                <?php csrfField(); ?>
                                <input type="hidden" name="doctor_id" value="<?php echo $doctor['id']; ?>">
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Select Date</label>
                                        <input type="date" name="date" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Select Time Slot</label>
                                        <select name="time" class="form-select" required>
                                            <option value="">Choose...</option>
                                            <option value="09:00">09:00 AM</option>
                                            <option value="10:00">10:00 AM</option>
                                            <option value="11:00">11:00 AM</option>
                                            <option value="12:00">12:00 PM</option>
                                            <option value="14:00">02:00 PM</option>
                                            <option value="15:00">03:00 PM</option>
                                            <option value="16:00">04:00 PM</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Purpose of Visit (Optional)</label>
                                        <textarea name="purpose" class="form-control" rows="3" placeholder="Briefly describe your health concern..."></textarea>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" name="book_appointment" class="btn btn-primary btn-lg w-100 fw-bold">Confirm Booking</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>