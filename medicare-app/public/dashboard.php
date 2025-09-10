<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Medicare</title>
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

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .welcome-section {
            text-align: center;
            margin-bottom: 3rem;
            animation: fadeIn 0.8s ease-out;
        }

        .welcome-section h1 {
            font-size: 2.5rem;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .welcome-section p {
            color: var(--text-light);
            font-size: 1.1rem;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            margin: 0 auto 1.5rem;
            box-shadow: var(--shadow-md);
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .dashboard-card {
            background: var(--lighter);
            border-radius: var(--rounded-md);
            padding: 2rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border-left: 4px solid var(--primary);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .dashboard-card i {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
            background: rgba(67, 97, 238, 0.1);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dashboard-card h3 {
            font-size: 1.3rem;
            color: var(--dark);
            margin-bottom: 0.75rem;
        }

        .dashboard-card p {
            color: var(--text-light);
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .dashboard-card .btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: var(--rounded-sm);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dashboard-card .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(67, 97, 238, 0.25);
        }

        .dashboard-card.appointments {
            border-left-color: var(--success);
        }
        .dashboard-card.appointments i {
            color: var(--success);
            background: rgba(56, 176, 0, 0.1);
        }
        .dashboard-card.appointments .btn {
            background: linear-gradient(135deg, var(--success) 0%, #2b9348 100%);
        }

        .dashboard-card.doctors {
            border-left-color: var(--secondary);
        }
        .dashboard-card.doctors i {
            color: var(--secondary);
            background: rgba(76, 201, 240, 0.1);
        }
        .dashboard-card.doctors .btn {
            background: linear-gradient(135deg, var(--secondary) 0%, #00b4d8 100%);
        }

        .dashboard-card.subscription {
            border-left-color: #7209b7;
        }
        .dashboard-card.subscription i {
            color: #7209b7;
            background: rgba(114, 9, 183, 0.1);
        }
        .dashboard-card.subscription .btn {
            background: linear-gradient(135deg, #7209b7 0%, #560bad 100%);
        }

        .dashboard-card.support {
            border-left-color: var(--warning);
        }
        .dashboard-card.support i {
            color: var(--warning);
            background: rgba(255, 158, 0, 0.1);
        }
        .dashboard-card.support .btn {
            background: linear-gradient(135deg, var(--warning) 0%, #f77f00 100%);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin: 2rem auto 0;
            padding: 0.75rem 1.5rem;
            background: var(--light);
            color: var(--danger);
            border: 1px solid var(--border);
            border-radius: var(--rounded-sm);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            max-width: 200px;
        }

        .logout-btn:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(239, 35, 60, 0.2);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1.5rem;
            }
            
            .welcome-section h1 {
                font-size: 2rem;
            }
            
            .dashboard-card {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .welcome-section h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>

<?php include 'components/navbar.php'; ?>

<div class="dashboard-container">
    <div class="welcome-section">
        <div class="user-avatar">
            <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
        </div>
        <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['fullname'] ?? htmlspecialchars($_SESSION['username'])); ?></h1>
        <p>What would you like to do today?</p>
    </div>

    <div class="dashboard-grid">
        <div class="dashboard-card appointments">
            <i class="fas fa-calendar-check"></i>
            <h3>Book Appointment</h3>
            <p>Schedule a visit with your preferred healthcare provider</p>
            <a href="book.php" class="btn">Book Now <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="dashboard-card doctors">
            <i class="fas fa-user-md"></i>
            <h3>Our Doctors</h3>
            <p>Browse our network of qualified healthcare professionals</p>
            <a href="doctors.php" class="btn">View Doctors <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="dashboard-card subscription">
            <i class="fas fa-heartbeat"></i>
            <h3>Health Plans</h3>
            <p>Explore our premium healthcare subscription options</p>
            <a href="subscription.php" class="btn">View Plans <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="dashboard-card support">
            <i class="fas fa-headset"></i>
            <h3>Support Center</h3>
            <p>Get help from our dedicated customer support team</p>
            <a href="support.php" class="btn">Get Help <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <a href="logout.php" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

</body>
</html>