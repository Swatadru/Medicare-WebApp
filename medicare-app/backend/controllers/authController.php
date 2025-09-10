<?php
// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/db.php'; // This must define $conn (MySQLi)

// REGISTER HANDLER
if (isset($_POST['register'])) {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'] ?? 'patient'; // Default to patient if not set
    $specialization = isset($_POST['specialization']) ? trim($_POST['specialization']) : null;
    $experience = isset($_POST['experience']) ? (int)$_POST['experience'] : null;

    // Store form values for repopulation
    $_SESSION['form_values'] = [
        'fullname' => $fullname,
        'username' => $username,
        'email' => $email,
        'role' => $role,
        'specialization' => $specialization,
        'experience' => $experience
    ];

    // Validation
    if (empty($fullname) || empty($username) || empty($email) || empty($password)) {
        $_SESSION['register_error'] = "All fields are required.";
        header('Location: ../../public/register.php');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = "Invalid email address.";
        header('Location: ../../public/register.php');
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = "Passwords do not match.";
        header('Location: ../../public/register.php');
        exit();
    }

    // Additional validation for doctors
    if ($role === 'doctor' && (empty($specialization) || empty($experience))) {
        $_SESSION['register_error'] = "Specialization and experience are required for doctors.";
        header('Location: ../../public/register.php');
        exit();
    }

    // Check for existing user
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['register_error'] = "Username or email already exists.";
        $stmt->close();
        header('Location: ../../public/register.php');
        exit();
    }
    $stmt->close();

    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert into users table
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fullname, $username, $email, $hashedPassword, $role);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to create user account.");
        }
        
        $user_id = $stmt->insert_id;
        $stmt->close();

        // If doctor, insert into doctors table with email in contact column
        if ($role === 'doctor') {
            // Default availability
            $availability = json_encode([
                'monday' => ['09:00-17:00'],
                'tuesday' => ['09:00-17:00'],
                'wednesday' => ['09:00-17:00'],
                'thursday' => ['09:00-17:00'],
                'friday' => ['09:00-17:00'],
                'saturday' => [],
                'sunday' => []
            ]);
            
            $stmt = $conn->prepare("INSERT INTO doctors (id, name, contact, specialization, experience, availability) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssis", $user_id, $fullname, $email, $specialization, $experience, $availability);
            
            if (!$stmt->execute()) {
                throw new Exception("Failed to create doctor profile.");
            }
            $stmt->close();
        }

        // Commit transaction
        $conn->commit();

        // Clear form values and set success message
        unset($_SESSION['form_values']);
        $_SESSION['register_success'] = "Registration successful! Please log in.";
        header('Location: ../../public/login.php');
        exit();

    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $_SESSION['register_error'] = "Registration failed: " . $e->getMessage();
        header('Location: ../../public/register.php');
        exit();
    }
}

// LOGIN HANDLER
if (isset($_POST['login'])) {
    $usernameOrEmail = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($usernameOrEmail) || empty($password)) {
        $_SESSION['login_error'] = "All fields are required.";
        header("Location: ../../public/login.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT id, fullname, username, password, role FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];
        
        header("Location: ../../public/dashboard.php");
        exit();
    } else {
        $_SESSION['login_error'] = "Invalid username or password.";
        header("Location: ../../public/login.php");
        exit();
    }
}