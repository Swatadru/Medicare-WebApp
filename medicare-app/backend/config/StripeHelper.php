<?php

/**
 * A lightweight Stripe API Helper using cURL
 */
class StripeHelper {
    private $secretKey;
    private $apiUrl = "https://api.stripe.com/v1";

    public function __construct($secretKey) {
        $this->secretKey = $secretKey;
    }

    private function request($endpoint, $params = [], $method = 'POST') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_USERPWD, $this->secretKey . ':');

        if ($method === 'POST' && !empty($params)) {
             curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('Stripe Request Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($result, true);
    }

    /**
     * Create a Checkout Session
     */
    public function createCheckoutSession($planName, $amountCents, $successUrl, $cancelUrl, $metadata = [], $method = 'card') {
        $currency = ($method === 'upi') ? 'inr' : 'usd';
        
        $params = [
            'payment_method_types[]' => $method,
            'line_items[0][price_data][currency]' => $currency,
            'line_items[0][price_data][product_data][name]' => $planName,
            'line_items[0][price_data][unit_amount]' => $amountCents,
            'line_items[0][quantity]' => 1,
            'mode' => 'payment',
            'success_url' => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $cancelUrl,
        ];

        foreach ($metadata as $key => $value) {
            $params["metadata[$key]"] = $value;
        }

        return $this->request('/checkout/sessions', $params);
    }

    /**
     * Retrieve a Session to verify payment
     */
    public function getSession($sessionId) {
        return $this->request('/checkout/sessions/' . $sessionId, [], 'GET');
    }
}
