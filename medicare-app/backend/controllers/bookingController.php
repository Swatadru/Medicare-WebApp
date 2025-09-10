<?php
session_start();
require_once dirname(__DIR__) . '/config/db.php'; // <-- updated path

if (isset($_POST['book_appointment'])) {
    $userId = $_SESSION['user_id'];
    $doctorId = $_POST['doctor_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $stmt = $conn->prepare("INSERT INTO appointments (user_id, doctor_id, appointment_date, appointment_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $userId, $doctorId, $date, $time);

    if ($stmt->execute()) {
        header("Location: ../../public/dashboard.php?success=1");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../../public/book.php");
    exit();
}
