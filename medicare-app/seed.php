<?php
require_once __DIR__ . '/backend/config/db.php';

/**
 * Portable Database Seeder - Restoring User-Customized Doctors
 */

try {
    // Disable foreign key checks for clean wipe (SQLite syntax)
    $conn->exec("PRAGMA foreign_keys = OFF");
    
    $conn->exec("DELETE FROM users");
    $conn->exec("DELETE FROM doctors");
    $conn->exec("DELETE FROM appointments");
    $conn->exec("DELETE FROM medicines");

    // Seed Users
    $pass = password_hash('password123', PASSWORD_DEFAULT);
    
    // User IDs: 1 (Admin), 2 (Patient), 3-11 (Doctors)
    $conn->exec("INSERT INTO users (id, fullname, username, email, password, role, subscription_plan) VALUES 
        (1, 'System Admin', 'admin', 'admin@medicare.com', '$pass', 'admin', 'elite'),
        (2, 'Saheb', 'saheb', 'saheb@gmail.com', '$pass', 'patient', 'pro'),
        (3, 'Ananya Saha', 'ananya', 'ananya@medicare.com', '$pass', 'doctor', 'elite'),
        (4, 'Subhajit Das', 'subhajit_d', 'subhajit@medicare.com', '$pass', 'doctor', 'pro'),
        (5, 'Subhojit Das', 'subhojit_d', 'subhojit@medicare.com', '$pass', 'doctor', 'pro'),
        (6, 'Subham Roy', 'subham', 'subham@medicare.com', '$pass', 'doctor', 'elite'),
        (7, 'Subhodeep Basu', 'subhodeep', 'subhodeep@medicare.com', '$pass', 'doctor', 'pro'),
        (8, 'Subhoprasad Bhattacharyya', 'subhoprasad', 'subhoprasad@medicare.com', '$pass', 'doctor', 'elite'),
        (9, 'Subrata Karmakar', 'subrata', 'subrata@medicare.com', '$pass', 'doctor', 'pro'),
        (10, 'Sudipa Deb', 'sudipa', 'sudipa@medicare.com', '$pass', 'doctor', 'pro'),
        (11, 'Supriyo Bhattacharyya', 'supriyo', 'supriyo@medicare.com', '$pass', 'doctor', 'elite')");

    // Seed Doctors with local image assets
    $conn->exec("INSERT INTO doctors (id, name, contact, specialization, experience, bio, is_elite, image) VALUES 
        (3, 'Ananya Saha', 'ananya@medicare.com', 'Neurology', 12, 'Leading specialist in neural sciences and mental wellbeing.', 1, 'assets/images/Ananya.jpg'),
        (4, 'Subhajit Das', 'subhajit@medicare.com', 'Cardiology', 15, 'Expert in cardiovascular surgery and preventive heart care.', 0, 'assets/images/Subhajit.jpeg'),
        (5, 'Subhojit Das', 'subhojit@medicare.com', 'Pediatrics', 10, 'Compassionate care for infants, children, and adolescents.', 0, 'assets/images/Subhojit.jpeg'),
        (6, 'Subham Roy', 'subham@medicare.com', 'Orthopedics', 8, 'Specializing in sports injuries and bone reconstruction.', 1, 'assets/images/Subham.jpeg'),
        (7, 'Subhodeep Basu', 'subhodeep@medicare.com', 'Dermatology', 7, 'Advanced skin care and dermatological surgery specialist.', 0, 'assets/images/SubhodeepBasu.jpeg'),
        (8, 'Subhoprasad Bhattacharyya', 'subhoprasad@medicare.com', 'Oncology', 20, 'Distinguished expert in cancer research and clinical oncology.', 1, 'assets/images/Subhoprasad.png'),
        (9, 'Subrata Karmakar', 'subrata@medicare.com', 'Gastroenterology', 14, 'Professional in digestive diseases and liver care.', 0, 'assets/images/Subrata.jpeg'),
        (10, 'Sudipa Deb', 'sudipa@medicare.com', 'Gynecology', 12, 'Comprehensive maternal and reproductive health specialist.', 0, 'assets/images/Sudipa.jpg'),
        (11, 'Supriyo Bhattacharyya', 'supriyo@medicare.com', 'Psychiatry', 18, 'Expert in clinical psychology and behavioral health therapy.', 1, 'assets/images/Supriyo.jpeg')");

    // Re-enable foreign key checks
    $conn->exec("PRAGMA foreign_keys = ON");

    echo "Local database restored with your custom doctor list and images successfully.\n";
} catch (Exception $e) {
    echo "Restoration failed: " . $e->getMessage() . "\n";
}
