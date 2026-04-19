<?php
session_start();
require_once __DIR__ . '/../backend/config/db.php';
require_once __DIR__ . '/../backend/config/StripeHelper.php';

$sessionId = $_GET['session_id'] ?? null;

if (!$sessionId) {
    header("Location: subscription.php?error=no_session");
    exit();
}

try {
    $stripe = new StripeHelper($_ENV['STRIPE_SECRET_KEY']);
    $session = $stripe->getSession($sessionId);

    if ($session && $session['payment_status'] === 'paid') {
        $userId = $session['metadata']['user_id'] ?? null;
        $plan = $session['metadata']['plan'] ?? null;

        if (!$userId || !$plan) {
            throw new Exception("Missing metadata in Stripe session.");
        }

        // Update user's subscription plan
        $stmt = $conn->prepare("UPDATE users SET subscription_plan = ? WHERE id = ?");
        if ($stmt->execute([$plan, $userId])) {
            // Synchronize the session immediately
            $_SESSION['subscription_plan'] = $plan;
            
            // Redirect to dashboard with success flag
            header("Location: dashboard.php?payment=success&plan=" . urlencode($plan));
            exit();
        } else {
            throw new Exception("Database update failed.");
        }
    } else {
        header("Location: subscription.php?error=unpaid");
        exit();
    }
} catch (Exception $e) {
    header("Location: subscription.php?error=" . urlencode($e->getMessage()));
    exit();
}
?>
