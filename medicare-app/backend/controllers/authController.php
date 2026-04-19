<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/csrf.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Doctor.php';

$userModel = new User($conn);
$doctorModel = new Doctor($conn);

// Helper to redirect relative to the controller
function redirect($path) {
    header("Location: " . $path);
    exit();
}

// Global CSRF Check for POST requests in this controller
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $_SESSION['login_error'] = "Security session expired. Please try again.";
        $_SESSION['register_error'] = "Security session expired. Please try again.";
        redirect($_SERVER['HTTP_REFERER'] ?? 'index.php');
    }
}

// REGISTER HANDLER
if (isset($_POST['register'])) {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'] ?? 'patient';
    $specialization = isset($_POST['specialization']) ? trim($_POST['specialization']) : null;
    $experience = isset($_POST['experience']) ? (int)$_POST['experience'] : null;

    $_SESSION['form_values'] = $_POST;

    // Validation
    if (empty($fullname) || empty($username) || empty($email) || empty($password)) {
        $_SESSION['register_error'] = "All fields are required.";
        redirect('register.php');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = "Invalid email address.";
        redirect('register.php');
    }

    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = "Passwords do not match.";
        redirect('register.php');
    }

    if ($role === 'doctor' && (empty($specialization) || empty($experience))) {
        $_SESSION['register_error'] = "Specialization and experience are required for doctors.";
        redirect('register.php');
    }

    // Check existing
    if ($userModel->findByUsernameOrEmail($username) || $userModel->findByUsernameOrEmail($email)) {
        $_SESSION['register_error'] = "Username or email already exists.";
        redirect('register.php');
    }

    try {
        $conn->beginTransaction();

        $user_id = $userModel->create($fullname, $username, $email, $password, $role);
        
        if (!$user_id) {
            throw new Exception("Failed to create account.");
        }

        if ($role === 'doctor') {
            $availability = json_encode([
                'monday' => ['09:00-17:00'],
                'tuesday' => ['09:00-17:00'],
                'wednesday' => ['09:00-17:00'],
                'thursday' => ['09:00-17:00'],
                'friday' => ['09:00-17:00'],
                'saturday' => [],
                'sunday' => []
            ]);
            
            if (!$doctorModel->create($user_id, $fullname, $email, $specialization, $experience, $availability)) {
                throw new Exception("Failed to create doctor profile.");
            }
        }

        $conn->commit();
        unset($_SESSION['form_values']);
        $_SESSION['register_success'] = "Registration successful! Please log in.";
        redirect('login.php');

    } catch (Exception $e) {
        $conn->rollBack();
        $_SESSION['register_error'] = "Error: " . $e->getMessage();
        redirect('register.php');
    }
}

// LOGIN HANDLER
if (isset($_POST['login'])) {
    $usernameOrEmail = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($usernameOrEmail) || empty($password)) {
        $_SESSION['login_error'] = "All fields are required.";
        redirect("login.php");
    }

    $user = $userModel->findByUsernameOrEmail($usernameOrEmail);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['subscription_plan'] = $user['subscription_plan'] ?? 'basic';
        
        redirect("dashboard.php");
    } else {
        $_SESSION['login_error'] = "Invalid credentials.";
        redirect("login.php");
    }
}