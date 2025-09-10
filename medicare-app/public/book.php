<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/../backend/config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - Medicare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --primary-light: #4895ef;
            --secondary: #4cc9f0;
            --success: #38b000;
            --warning: #ff9e00;
            --danger: #ef233c;
            --light: #f8f9fa;
            --lighter: #ffffff;
            --dark: #14213d;
            --text: #2b2d42;
            --text-light: #8d99ae;
            --border: #e9ecef;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
            --shadow: 0 4px 6px rgba(0,0,0,0.1);
            --shadow-md: 0 10px 15px rgba(0,0,0,0.1);
            --rounded-sm: 8px;
            --rounded: 12px;
            --rounded-md: 16px;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7ff;
            background-image: radial-gradient(circle at 10% 20%, rgba(67, 97, 238, 0.05) 0%, rgba(255,255,255,1) 90%);
            color: var(--text);
            line-height: 1.6;
            min-height: 100vh;
        }

        .booking-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--lighter);
            border-radius: var(--rounded-md);
            box-shadow: var(--shadow-md);
            animation: fadeIn 0.5s ease-out;
        }

        .booking-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .booking-header h2 {
            font-size: 2rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .booking-header p {
            color: var(--text-light);
        }

        .appointment-form {
            display: grid;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            position: relative;
        }

        .form-group label {
            font-weight: 500;
            color: var(--dark);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: var(--rounded-sm);
            font-size: 1rem;
            transition: var(--transition);
            background-color: var(--light);
            width: 100%;
        }

        /* Enhanced Select Dropdown Styles */
        .form-group select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%238d99ae' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 12px;
            padding-right: 2.5rem;
            cursor: pointer;
        }

        .form-group select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: var(--rounded-sm);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(67, 97, 238, 0.25);
        }

        .error-message {
            background-color: rgba(239, 35, 60, 0.1);
            color: var(--danger);
            padding: 1rem;
            border-radius: var(--rounded-sm);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-left: 4px solid var(--danger);
        }

        .success-message {
            background-color: rgba(56, 176, 0, 0.1);
            color: var(--success);
            padding: 1rem;
            border-radius: var(--rounded-sm);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-left: 4px solid var(--success);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .booking-container {
                padding: 1.5rem;
                margin: 1.5rem;
            }
            
            .booking-header h2 {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 480px) {
            .booking-container {
                padding: 1.25rem;
                margin: 1rem;
            }
            
            .booking-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

<?php 
// Navbar inclusion with fallback
$navbarPath = __DIR__ . '/components/navbar.php';
if (file_exists($navbarPath)) {
    include $navbarPath;
} else {
    echo "<nav class='fallback-nav'>Medicare Navigation</nav>";
}

// Display success/error messages
if (isset($_SESSION['booking_success'])) {
    echo '<div class="success-message">';
    echo '<i class="fas fa-check-circle"></i> ' . htmlspecialchars($_SESSION['booking_success']);
    echo '</div>';
    unset($_SESSION['booking_success']);
}

if (isset($_SESSION['booking_error'])) {
    echo '<div class="error-message">';
    echo '<i class="fas fa-exclamation-circle"></i> ' . htmlspecialchars($_SESSION['booking_error']);
    echo '</div>';
    unset($_SESSION['booking_error']);
}
?>

<div class="booking-container">
    <div class="booking-header">
        <h2><i class="fas fa-calendar-check"></i> Book an Appointment</h2>
        <p>Schedule your visit with our healthcare professionals</p>
    </div>

    <form action="../backend/controllers/bookingController.php" method="POST" class="appointment-form">
        <div class="form-group">
            <label for="doctor_id">Select Doctor</label>
            <select name="doctor_id" id="doctor_id" required>
                <option value="">-- Select a Doctor --</option>
                <?php 
                $doctors = $conn->query("SELECT d.id, d.name, d.specialization FROM doctors d JOIN users u ON d.id = u.id WHERE u.role = 'doctor' ORDER BY d.name ASC");
                while ($doctor = $doctors->fetch_assoc()):
                ?>
                <option value="<?= htmlspecialchars($doctor['id']) ?>">
                    <?= htmlspecialchars($doctor['name']) ?> (<?= htmlspecialchars($doctor['specialization']) ?>)
                </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="date">Appointment Date</label>
            <input type="date" name="date" id="date" required 
                   min="<?= date('Y-m-d') ?>">
        </div>

        <div class="form-group">
            <label for="time">Preferred Time</label>
            <input type="time" name="time" id="time" required min="09:00" max="17:00" step="900">
        </div>

        <div class="form-group">
            <label for="notes">Additional Notes (Optional)</label>
            <textarea name="notes" id="notes" placeholder="Any special requirements or information"></textarea>
        </div>

        <button type="submit" name="book_appointment" class="btn">
            <i class="fas fa-calendar-plus"></i> Confirm Booking
        </button>
    </form>
</div>

<script>
    // Set minimum date to today
    document.getElementById('date').min = new Date().toISOString().split('T')[0];
    
    // Disable weekends
    document.getElementById('date').addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const day = selectedDate.getDay();
        
        if (day === 0 || day === 6) { // Sunday (0) or Saturday (6)
            alert('Our clinic is closed on weekends. Please select a weekday (Monday to Friday).');
            this.value = '';
        }
    });
</script>

</body>
</html>