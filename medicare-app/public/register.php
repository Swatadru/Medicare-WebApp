<?php
require_once '../backend/config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = $_SESSION['register_error'] ?? '';
unset($_SESSION['register_error']);

$form_values = $_SESSION['form_values'] ?? [];
unset($_SESSION['form_values']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Medicare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --primary-light: #4895ef;
            --secondary: #4cc9f0;
            --doctor: #7209b7;
            --patient: #38b000;
            --dark: #14213d;
            --light: #f8f9fa;
            --lighter: #ffffff;
            --text: #2b2d42;
            --text-light: #8d99ae;
            --error: #ef233c;
            --success: #38b000;
            --warning: #ff9e00;
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
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7ff;
            background-image: radial-gradient(circle at 10% 20%, rgba(67, 97, 238, 0.05) 0%, rgba(255,255,255,1) 90%);
            color: var(--text);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background: var(--lighter);
            box-shadow: var(--shadow-sm);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
            background-color: rgba(255,255,255,0.9);
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo i {
            font-size: 28px;
            color: var(--primary);
        }

        .logo-text {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        .register-wrapper {
            width: 100%;
            max-width: 1100px;
            display: flex;
            background: var(--lighter);
            border-radius: var(--rounded-md);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            animation: fadeIn 0.5s ease-out;
        }

        .illustration-section {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .illustration-section::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .illustration-section::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .illustration-img {
            width: 100%;
            max-width: 400px;
            margin-bottom: 40px;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));
        }

        .illustration-content h2 {
            font-size: 32px;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .illustration-content p {
            opacity: 0.9;
            font-size: 16px;
            max-width: 400px;
            margin: 0 auto;
        }

        .form-section {
            flex: 1;
            padding: 60px;
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
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-header p {
            color: var(--text-light);
            font-size: 16px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 25px;
            border-radius: var(--rounded-sm);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 4px solid transparent;
        }

        .alert-error {
            background-color: rgba(239, 35, 60, 0.1);
            border-left-color: var(--error);
            color: var(--error);
        }

        .alert-success {
            background-color: rgba(56, 176, 0, 0.1);
            border-left-color: var(--success);
            color: var(--success);
        }

        .alert i {
            font-size: 20px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            font-size: 15px;
            color: var(--dark);
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 18px;
        }

        .form-control {
            width: 100%;
            padding: 16px 16px 16px 50px;
            font-size: 15px;
            border: 1px solid var(--border);
            border-radius: var(--rounded-sm);
            transition: var(--transition);
            background-color: var(--light);
            font-family: 'Poppins', sans-serif;
        }

        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .role-selection {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .role-option {
            flex: 1;
            position: relative;
        }

        .role-option input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .role-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 25px 15px;
            border: 2px solid var(--border);
            border-radius: var(--rounded-sm);
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            height: 100%;
            background: var(--light);
        }

        .role-option input:checked + .role-label {
            border-color: var(--primary);
            background-color: rgba(67, 97, 238, 0.05);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .role-option input:checked + .role-label.doctor-label {
            border-color: var(--doctor);
            background-color: rgba(114, 9, 183, 0.05);
            box-shadow: 0 0 0 3px rgba(114, 9, 183, 0.1);
        }

        .role-option input:checked + .role-label.patient-label {
            border-color: var(--patient);
            background-color: rgba(56, 176, 0, 0.05);
            box-shadow: 0 0 0 3px rgba(56, 176, 0, 0.1);
        }

        .role-icon {
            font-size: 28px;
            margin-bottom: 12px;
            color: var(--text-light);
            transition: var(--transition);
        }

        .role-option input:checked + .role-label .role-icon {
            color: var(--primary);
        }

        .role-option input:checked + .role-label.doctor-label .role-icon {
            color: var(--doctor);
        }

        .role-option input:checked + .role-label.patient-label .role-icon {
            color: var(--patient);
        }

        .role-name {
            font-weight: 600;
            color: var(--text);
            font-size: 16px;
            margin-bottom: 5px;
        }

        .role-description {
            font-size: 13px;
            color: var(--text-light);
        }

        .doctor-fields {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background: rgba(114, 9, 183, 0.05);
            border-radius: var(--rounded-sm);
            border: 1px dashed rgba(114, 9, 183, 0.3);
        }

        .doctor-fields.active {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }

        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-light);
            font-size: 18px;
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        .password-strength-container {
            margin-top: 15px;
        }

        .password-strength-text {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 13px;
            color: var(--text-light);
        }

        .password-strength {
            height: 6px;
            background: var(--border);
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 5px;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            background: var(--error);
            transition: var(--transition);
        }

        .password-hints {
            font-size: 13px;
            color: var(--text-light);
        }

        .password-hints ul {
            list-style: none;
            padding-left: 5px;
        }

        .password-hints li {
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .password-hints i {
            font-size: 12px;
            transition: var(--transition);
        }

        .password-hints .valid {
            color: var(--success);
        }

        .btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: var(--rounded-sm);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
            box-shadow: 0 4px 6px rgba(67, 97, 238, 0.2);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(67, 97, 238, 0.25);
        }

        .btn:active {
            transform: translateY(0);
        }

        .auth-links {
            text-align: center;
            margin-top: 25px;
            font-size: 15px;
        }

        .auth-links a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .auth-links a:hover {
            text-decoration: underline;
            color: var(--primary-dark);
        }

        footer {
            background: var(--dark);
            color: white;
            padding: 25px 0;
            text-align: center;
            font-size: 14px;
        }

        .footer-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 15px;
        }

        .footer-link {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-link:hover {
            color: white;
        }

        .copyright {
            color: rgba(255,255,255,0.6);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-8px); }
            40%, 80% { transform: translateX(8px); }
        }

        @media (max-width: 992px) {
            .register-wrapper {
                flex-direction: column;
                max-width: 600px;
            }
            
            .illustration-section {
                padding: 40px;
            }
            
            .form-section {
                padding: 40px;
            }
        }

        @media (max-width: 768px) {
            .role-selection {
                flex-direction: column;
            }
            
            .form-header h1 {
                font-size: 28px;
            }
            
            .illustration-content h2 {
                font-size: 26px;
            }
        }

        @media (max-width: 576px) {
            .register-wrapper {
                border-radius: 0;
                box-shadow: none;
            }
            
            .illustration-section,
            .form-section {
                padding: 30px 25px;
            }
            
            .container {
                padding: 0;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="container header-container">
        <a href="index.php" class="logo">
            <i class="fas fa-heartbeat"></i>
            <span class="logo-text">Medicare</span>
        </a>
        <a href="login.php" class="btn" style="width: auto; padding: 10px 25px; font-size: 15px;">
            <i class="fas fa-sign-in-alt"></i> Login
        </a>
    </div>
</header>

<main>
    <div class="container">
        <div class="register-wrapper">
            <div class="illustration-section">
                <img src="https://cdn3d.iconscout.com/3d/premium/thumb/doctor-and-patient-4107012-3400019.png" alt="Doctor and patient" class="illustration-img">
                <div class="illustration-content">
                    <h2>Join Our Healthcare Community</h2>
                    <p>Whether you're a healthcare provider or patient, we're here to connect you with the best medical services.</p>
                </div>
            </div>
            
            <div class="form-section">
                <div class="form-header">
                    <h1>Create Your Account</h1>
                    <p>Register to access personalized healthcare services</p>
                </div>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <div><?php echo htmlspecialchars($error); ?></div>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['register_success'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <div><?php echo htmlspecialchars($_SESSION['register_success']); ?></div>
                        <?php unset($_SESSION['register_success']); ?>
                    </div>
                <?php endif; ?>

                <form id="registerForm" action="../backend/controllers/authController.php" method="POST" autocomplete="off">
                    <!-- Role Selection - Fixed to properly track selection -->
                    <div class="form-group">
                        <label>I am registering as:</label>
                        <div class="role-selection">
                            <div class="role-option">
                                <input type="radio" id="role-patient" name="role" value="patient" 
                                       <?php echo (!isset($form_values['role']) || (isset($form_values['role']) && $form_values['role'] === 'patient')) ? 'checked' : ''; ?>>
                                <label for="role-patient" class="role-label patient-label">
                                    <i class="fas fa-user role-icon"></i>
                                    <span class="role-name">Patient</span>
                                    <span class="role-description">Book appointments & manage health</span>
                                </label>
                            </div>
                            <div class="role-option">
                                <input type="radio" id="role-doctor" name="role" value="doctor"
                                       <?php echo (isset($form_values['role']) && $form_values['role'] === 'doctor') ? 'checked' : ''; ?>>
                                <label for="role-doctor" class="role-label doctor-label">
                                    <i class="fas fa-user-md role-icon"></i>
                                    <span class="role-name">Doctor</span>
                                    <span class="role-description">Provide care & manage patients</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Doctor Specific Fields -->
                    <div id="doctorFields" class="doctor-fields <?php echo (isset($form_values['role']) && $form_values['role'] === 'doctor') ? 'active' : ''; ?>">
                        <div class="form-group">
                            <label for="specialization">Specialization</label>
                            <div class="input-with-icon">
                                <i class="fas fa-stethoscope"></i>
                                <input type="text" id="specialization" name="specialization" class="form-control" 
                                       placeholder="Your medical specialization"
                                       value="<?php echo htmlspecialchars($form_values['specialization'] ?? ''); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="experience">Years of Experience</label>
                            <div class="input-with-icon">
                                <i class="fas fa-briefcase"></i>
                                <input type="number" id="experience" name="experience" class="form-control" 
                                       placeholder="Number of years"
                                       value="<?php echo htmlspecialchars($form_values['experience'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Common Fields -->
                    <div class="form-group">
                        <label for="fullname">Full Name</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" id="fullname" name="fullname" class="form-control" 
                                   placeholder="Enter your full name" required
                                   value="<?php echo htmlspecialchars($form_values['fullname'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-with-icon">
                            <i class="fas fa-at"></i>
                            <input type="text" id="username" name="username" class="form-control" 
                                   placeholder="Choose a username" required
                                   value="<?php echo htmlspecialchars($form_values['username'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" class="form-control" 
                                   placeholder="Enter your email" required
                                   value="<?php echo htmlspecialchars($form_values['email'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" name="password" class="form-control" 
                                   placeholder="Create a password" required
                                   minlength="8">
                            <span class="password-toggle" id="togglePassword">
                                <i class="fas fa-eye"></i>
                                <i class="fas fa-eye-slash" style="display: none;"></i>
                            </span>
                        </div>
                        <div class="password-strength-container">
                            <div class="password-strength-text">
                                <span>Password Strength</span>
                                <span id="strengthText">Weak</span>
                            </div>
                            <div class="password-strength">
                                <div class="password-strength-bar" id="passwordStrengthBar"></div>
                            </div>
                        </div>
                        <div class="password-hints">
                            <ul>
                                <li id="lengthHint"><i class="fas fa-circle"></i> At least 8 characters</li>
                                <li id="uppercaseHint"><i class="fas fa-circle"></i> At least 1 uppercase letter</li>
                                <li id="numberHint"><i class="fas fa-circle"></i> At least 1 number</li>
                                <li id="specialHint"><i class="fas fa-circle"></i> At least 1 special character</li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="confirm_password" name="confirm_password" 
                                   class="form-control" placeholder="Confirm your password" required>
                            <span class="password-toggle" id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                                <i class="fas fa-eye-slash" style="display: none;"></i>
                            </span>
                        </div>
                        <div id="passwordMatch" style="font-size: 13px; margin-top: 5px;"></div>
                    </div>

                    <button type="submit" name="register" class="btn">
                        <i class="fas fa-user-plus"></i> Create Account
                    </button>
                </form>

                <div class="auth-links">
                    Already have an account? <a href="login.php">Sign in</a>
                </div>
            </div>
        </div>
    </div>
</main>

<footer>
    <div class="container">
        <div class="footer-container">
            <a href="about.php" class="footer-link">About Us</a>
            <a href="services.php" class="footer-link">Services</a>
            <a href="privacy.php" class="footer-link">Privacy Policy</a>
            <a href="terms.php" class="footer-link">Terms of Service</a>
            <a href="contact.php" class="footer-link">Contact</a>
        </div>
        <p class="copyright">&copy; 2023 Medicare. All rights reserved.</p>
    </div>
</footer>

<script>
    // Toggle password visibility
    function setupPasswordToggle(toggleId, inputId) {
        const toggle = document.querySelector(toggleId);
        const input = document.querySelector(inputId);
        const eyeIcon = toggle.querySelector('.fa-eye');
        const eyeSlashIcon = toggle.querySelector('.fa-eye-slash');

        toggle.addEventListener('click', function() {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            
            if (type === 'password') {
                eyeIcon.style.display = 'inline';
                eyeSlashIcon.style.display = 'none';
            } else {
                eyeIcon.style.display = 'none';
                eyeSlashIcon.style.display = 'inline';
            }
        });
    }

    setupPasswordToggle('#togglePassword', '#password');
    setupPasswordToggle('#toggleConfirmPassword', '#confirm_password');

    // Password strength checker
    const passwordInput = document.getElementById('password');
    const passwordStrengthBar = document.getElementById('passwordStrengthBar');
    const strengthText = document.getElementById('strengthText');
    const lengthHint = document.getElementById('lengthHint');
    const uppercaseHint = document.getElementById('uppercaseHint');
    const numberHint = document.getElementById('numberHint');
    const specialHint = document.getElementById('specialHint');

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        
        // Check length
        if (password.length >= 8) {
            strength++;
            lengthHint.innerHTML = '<i class="fas fa-check valid"></i> At least 8 characters';
            lengthHint.classList.add('valid');
        } else {
            lengthHint.innerHTML = '<i class="fas fa-circle"></i> At least 8 characters';
            lengthHint.classList.remove('valid');
        }
        
        // Check uppercase
        if (/[A-Z]/.test(password)) {
            strength++;
            uppercaseHint.innerHTML = '<i class="fas fa-check valid"></i> At least 1 uppercase letter';
            uppercaseHint.classList.add('valid');
        } else {
            uppercaseHint.innerHTML = '<i class="fas fa-circle"></i> At least 1 uppercase letter';
            uppercaseHint.classList.remove('valid');
        }
        
        // Check number
        if (/[0-9]/.test(password)) {
            strength++;
            numberHint.innerHTML = '<i class="fas fa-check valid"></i> At least 1 number';
            numberHint.classList.add('valid');
        } else {
            numberHint.innerHTML = '<i class="fas fa-circle"></i> At least 1 number';
            numberHint.classList.remove('valid');
        }
        
        // Check special character
        if (/[^A-Za-z0-9]/.test(password)) {
            strength++;
            specialHint.innerHTML = '<i class="fas fa-check valid"></i> At least 1 special character';
            specialHint.classList.add('valid');
        } else {
            specialHint.innerHTML = '<i class="fas fa-circle"></i> At least 1 special character';
            specialHint.classList.remove('valid');
        }
        
        // Update strength meter
        let width = 0;
        let color = '';
        let text = '';
        let textColor = '';
        
        switch(strength) {
            case 1:
                width = 25;
                color = '#ef233c';
                text = 'Weak';
                textColor = '#ef233c';
                break;
            case 2:
                width = 50;
                color = '#ff9e00';
                text = 'Fair';
                textColor = '#ff9e00';
                break;
            case 3:
                width = 75;
                color = '#4895ef';
                text = 'Good';
                textColor = '#4895ef';
                break;
            case 4:
                width = 100;
                color = '#38b000';
                text = 'Strong';
                textColor = '#38b000';
                break;
            default:
                width = 0;
                color = '#ef233c';
                text = 'Weak';
                textColor = '#ef233c';
        }
        
        passwordStrengthBar.style.width = width + '%';
        passwordStrengthBar.style.background = color;
        strengthText.textContent = text;
        strengthText.style.color = textColor;
    });

    // Password confirmation check
    const confirmPasswordInput = document.getElementById('confirm_password');
    const passwordMatch = document.getElementById('passwordMatch');

    confirmPasswordInput.addEventListener('input', function() {
        if (this.value !== passwordInput.value) {
            passwordMatch.textContent = 'Passwords do not match';
            passwordMatch.style.color = '#ef233c';
        } else if (this.value === '') {
            passwordMatch.textContent = '';
        } else {
            passwordMatch.textContent = 'Passwords match';
            passwordMatch.style.color = '#38b000';
        }
    });

    // Show/hide doctor fields based on role selection
    const rolePatient = document.getElementById('role-patient');
    const roleDoctor = document.getElementById('role-doctor');
    const doctorFields = document.getElementById('doctorFields');
    
    function toggleDoctorFields() {
        if (roleDoctor.checked) {
            doctorFields.classList.add('active');
            // Make doctor-specific fields required
            document.getElementById('specialization').required = true;
            document.getElementById('experience').required = true;
        } else {
            doctorFields.classList.remove('active');
            // Remove required attribute for patient registration
            document.getElementById('specialization').required = false;
            document.getElementById('experience').required = false;
        }
    }
    
    rolePatient.addEventListener('change', toggleDoctorFields);
    roleDoctor.addEventListener('change', toggleDoctorFields);
    
    // Initialize on page load
    toggleDoctorFields();

    // Form validation
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        if (passwordInput.value !== confirmPasswordInput.value) {
            e.preventDefault();
            passwordMatch.textContent = 'Passwords do not match';
            passwordMatch.style.color = '#ef233c';
            this.classList.add('shake');
            setTimeout(() => this.classList.remove('shake'), 500);
        }
        
        // Additional validation for doctors
        if (roleDoctor.checked) {
            const specialization = document.getElementById('specialization').value;
            const experience = document.getElementById('experience').value;
            
            if (!specialization || !experience) {
                e.preventDefault();
                alert('Please fill in all doctor-specific fields');
            }
        }
    });

    // Animation for error message
    <?php if (!empty($error)): ?>
        document.querySelector('.alert').style.animation = 'shake 0.5s';
    <?php endif; ?>
</script>

</body>
</html>