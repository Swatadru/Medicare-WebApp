<?php
require_once __DIR__ . '/../config/db.php';

class AppointmentController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Update the status of an appointment
     */
    public function updateStatus($appointmentId, $newStatus, $userId, $role) {
        // Security Check: Verify that the user has permission to update this appointment
        $stmt = $this->conn->prepare("SELECT user_id, doctor_id FROM appointments WHERE id = ?");
        $stmt->execute([$appointmentId]);
        $appointment = $stmt->fetch();

        if (!$appointment) {
            return ['success' => false, 'message' => 'Appointment not found.'];
        }

        // Only the assigned doctor can confirm/cancel
        // Patients can only cancel their own appointments
        $isDoctor = ($role === 'doctor' && $appointment['doctor_id'] == $userId);
        $isPatient = ($role === 'patient' && $appointment['user_id'] == $userId);

        if (!$isDoctor && !$isPatient) {
            return ['success' => false, 'message' => 'Unauthorized action.'];
        }

        // Status Transition Logic
        if ($newStatus === 'confirmed' && !$isDoctor) {
            return ['success' => false, 'message' => 'Only doctors can confirm appointments.'];
        }

        $stmt = $this->conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
        if ($stmt->execute([$newStatus, $appointmentId])) {
            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Status updated successfully.'];
            }
            return ['success' => false, 'message' => 'No changes made. Status may already be ' . $newStatus];
        }

        return ['success' => false, 'message' => 'Database error: Failed to update status.'];
    }

    /**
     * Get single appointment details with doctor/patient info
     */
    public function getDetails($appointmentId, $userId, $role) {
        if ($role === 'doctor') {
            $stmt = $this->conn->prepare("
                SELECT a.*, u.fullname as patient_name, u.email as patient_email
                FROM appointments a
                JOIN users u ON a.user_id = u.id
                WHERE a.id = ? AND a.doctor_id = ?
            ");
            $stmt->execute([$appointmentId, $userId]);
        } else {
            $stmt = $this->conn->prepare("
                SELECT a.*, d.name as doctor_name, d.specialization, d.contact as doctor_contact
                FROM appointments a
                JOIN doctors d ON a.doctor_id = d.id
                WHERE a.id = ? AND a.user_id = ?
            ");
            $stmt->execute([$appointmentId, $userId]);
        }
        
        return $stmt->fetch();
    }
}
