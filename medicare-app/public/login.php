<?php
require_once '../backend/config/db.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Display error message if exists
$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);

// Check for remember me cookie
$remembered_email = '';
if (isset($_COOKIE['remember_email'])) {
    $remembered_email = htmlspecialchars($_COOKIE['remember_email']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Medicare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --primary-light: #3b82f6;
            --secondary: #10b981;
            --dark: #1e293b;
            --light: #f8fafc;
            --lighter: #ffffff;
            --text: #334155;
            --text-light: #64748b;
            --error: #ef4444;
            --border: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --rounded-sm: 0.25rem;
            --rounded: 0.5rem;
            --rounded-md: 0.75rem;
            --transition: all 0.3s ease;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f7ff 0%, #e6f0ff 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            color: var(--text);
            line-height: 1.6;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            box-shadow: var(--shadow-md);
            border-radius: var(--rounded-md);
            overflow: hidden;
            background: var(--lighter);
            position: relative;
        }

        .login-illustration {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-illustration::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .login-illustration::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .illustration-content {
            position: relative;
            z-index: 1;
            max-width: 400px;
        }

        .illustration-content img {
            width: 100%;
            max-width: 300px;
            margin-bottom: 30px;
        }

        .illustration-content h2 {
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .illustration-content p {
            opacity: 0.9;
            font-size: 15px;
        }

        .login-form {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 30px;
        }

        .form-header h1 {
            font-size: 32px;
            color: var(--dark);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .form-header p {
            color: var(--text-light);
            font-size: 15px;
        }

        .form-header .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            color: var(--primary);
            font-size: 24px;
            font-weight: 700;
        }

        .logo i {
            font-size: 28px;
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: var(--rounded-sm);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--error);
            border-left: 4px solid var(--error);
        }

        .alert i {
            font-size: 18px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
            color: var(--dark);
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 14px 14px 14px 45px;
            font-size: 15px;
            border: 1px solid var(--border);
            border-radius: var(--rounded);
            transition: var(--transition);
            background-color: var(--light);
        }

        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-light);
            font-size: 16px;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input {
            width: auto;
        }

        .forgot-password a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background-color: var(--primary);
            color: white;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: var(--rounded);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: var(--text-light);
            font-size: 14px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
            margin: 0 10px;
        }

        .social-login {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .social-btn {
            flex: 1;
            padding: 12px;
            border-radius: var(--rounded);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            border: 1px solid var(--border);
            background: white;
        }

        .social-btn:hover {
            background-color: var(--light);
        }

        .social-btn i {
            font-size: 18px;
        }

        .google-btn {
            color: #db4437;
        }

        .facebook-btn {
            color: #4267b2;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .login-illustration {
                padding: 30px;
                display: none; /* Hide illustration on mobile */
            }

            .login-form {
                padding: 40px 30px;
            }

            .social-login {
                flex-direction: column;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-form {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-illustration">
        <div class="illustration-content">
            <img src="https://cdn3d.iconscout.com/3d/premium/thumb/doctor-holding-medical-report-4107010-3400017.png" alt="Doctor illustration">
            <h2>Welcome to Medicare</h2>
            <p>Your trusted healthcare partner. Book appointments, consult doctors online, and manage your health records.</p>
        </div>
    </div>

    <div class="login-form">
        <div class="form-header">
            <div class="logo">
                <i class="fas fa-heartbeat"></i>
                <span>Medicare</span>
            </div>
            <h1>Sign In</h1>
            <p>Please enter your credentials to access your account.</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="../backend/controllers/authController.php" method="POST" autocomplete="off">
            <div class="form-group">
                <label for="username">Email Address</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="username" name="username" class="form-control" placeholder="Enter your email" required value="<?php echo $remembered_email; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                    <span class="password-toggle" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    <i class="fas fa-eye-slash" style="display: none;"></i>
                    </span>
                </div>
            </div>

            <div class="form-options">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember" <?php echo !empty($remembered_email) ? 'checked' : ''; ?>>
                    <label for="remember">Remember me</label>
                </div>
                <div class="forgot-password">
                    <a href="forgot-password.php">Forgot password?</a>
                </div>
            </div>

            <button type="submit" name="login" class="btn">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>

        <div class="divider">or continue with</div>

        <div class="social-login">
            <button type="button" class="social-btn google-btn">
                <i class="fab fa-google"></i> Google
            </button>
            <button type="button" class="social-btn facebook-btn">
                <i class="fab fa-facebook-f"></i> Facebook
            </button>
        </div>

        <div class="register-link">
            Don't have an account? <a href="register.php">Create one</a>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = togglePassword.querySelector('.fa-eye');
    const eyeSlashIcon = togglePassword.querySelector('.fa-eye-slash');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        if (type === 'password') {
            eyeIcon.style.display = 'inline';
            eyeSlashIcon.style.display = 'none';
        } else {
            eyeIcon.style.display = 'none';
            eyeSlashIcon.style.display = 'inline';
        }
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const email = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        
        if (!email || !password) {
            e.preventDefault();
            alert('Please fill in all fields');
        }
    });

    // Animation for error message
    <?php if (!empty($error)): ?>
        document.querySelector('.alert').style.animation = 'shake 0.5s';
    <?php endif; ?>
</script>

</body>
</html>