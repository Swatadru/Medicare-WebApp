<?php

/**
 * A simple helper to send email notifications.
 */
class EmailHelper {
    /**
     * Send a plain text email
     */
    public static function send($to, $subject, $message) {
        $headers = "From: Medicare Hub <noreply@medicare-hub.com>\r\n";
        $headers .= "Reply-To: support@medicare-hub.com\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        // NOTE: Standard PHP mail() often fails or goes to spam.
        // For production, you should use PHPMailer with an SMTP service (SendGrid, Mailgun, etc.)
        return mail($to, $subject, $message, $headers);
    }

    /**
     * Send an appointment confirmation email
     */
    public static function sendAppointmentConfirmation($to, $doctorName, $date, $time) {
        $subject = "Appointment Confirmation - Medicare Hub";
        $msg = "Hello,\n\nYour appointment with Dr. {$doctorName} has been confirmed.\n";
        $msg .= "Date: {$date}\nTime: {$time}\n\n";
        $msg .= "Thank you for choosing Medicare Hub.";
        
        return self::send($to, $subject, $msg);
    }
}
