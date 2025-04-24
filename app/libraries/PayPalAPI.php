<?php
class PayPalAPI {
    private $clientId;
    private $clientSecret;
    private $apiUrl;
    
    public function __construct() {
        // Updated PayPal Sandbox credentials provided by the client
        $this->clientId = 'AWo0djZj6kXDEOdmIeUJGuoVH_CUMfgf5fB35JgQbOk-EP2OTyLbX2y8Cc1fNxaTqdXVAUVeoeS0yLQr';
        $this->clientSecret = 'EMakyaPUrYHxjrPkXFW71m2JI64nCjoILn88fi4mHLC8mija9QElHIe9Gm2OiJQaAvpJNlb6DyOSQwbj';
        $this->apiUrl = 'https://api-m.sandbox.paypal.com'; // Sandbox API URL
    }
    
    private function getAccessToken() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '/v1/oauth2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_USERPWD, $this->clientId . ":" . $this->clientSecret);
        
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Accept-Language: en_US';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            error_log('PayPal API Error: ' . curl_error($ch));
            curl_close($ch);
            return false;
        }
        curl_close($ch);
        
        error_log("PayPal Token Response: " . $result);
        $response = json_decode($result);
        if (!isset($response->access_token)) {
            error_log("Failed to get access token: " . print_r($response, true));
            return false;
        }
        return $response->access_token;
    }
    
    public function createOrder($amount, $currency = 'USD', $returnUrl, $cancelUrl) {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return ['success' => false, 'message' => 'Failed to get PayPal access token'];
        }
        
        $payload = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => $currency,
                        'value' => number_format($amount, 2, '.', '')
                    ]
                ]
            ],
            'application_context' => [
                'return_url' => $returnUrl,
                'cancel_url' => $cancelUrl,
                'brand_name' => 'Bakery Shop',
                'user_action' => 'PAY_NOW',
                'shipping_preference' => 'NO_SHIPPING'
            ]
        ];
        
        error_log("PayPal Create Order Payload: " . json_encode($payload));
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '/v2/checkout/orders');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $accessToken;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            error_log('PayPal Create Order Error: ' . curl_error($ch));
            curl_close($ch);
            return ['success' => false, 'message' => 'Failed to create PayPal order'];
        }
        curl_close($ch);
        
        error_log("PayPal Create Order Response: " . $result);
        $response = json_decode($result, true);
        
        if (isset($response['id'])) {
            // Find the approve link
            $approvalUrl = null;
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    $approvalUrl = $link['href'];
                    break;
                }
            }
            
            return [
                'success' => true, 
                'orderId' => $response['id'],
                'approvalUrl' => $approvalUrl
            ];
        }
        
        return ['success' => false, 'message' => 'Failed to create PayPal order', 'details' => $response];
    }
    
    public function capturePayment($orderId) {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return ['success' => false, 'message' => 'Failed to get PayPal access token'];
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '/v2/checkout/orders/' . $orderId . '/capture');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{}');
        
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $accessToken;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        error_log("PayPal Capture Payment Response for Order $orderId: " . $result);
        
        if (curl_errno($ch)) {
            error_log('PayPal Capture Error: ' . curl_error($ch));
            curl_close($ch);
            return ['success' => false, 'message' => 'Failed to capture PayPal payment'];
        }
        curl_close($ch);
        
        $response = json_decode($result, true);
        
        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            return [
                'success' => true,
                'transactionId' => $response['purchase_units'][0]['payments']['captures'][0]['id'] ?? $orderId,
                'status' => $response['status']
            ];
        }
        
        return ['success' => false, 'message' => 'Payment was not completed', 'details' => $response];
    }
    
    // Helper method to verify a successful payment - can be used to double-check
    public function verifyPayment($orderId) {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return ['success' => false, 'message' => 'Failed to get PayPal access token'];
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '/v2/checkout/orders/' . $orderId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $accessToken;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            error_log('PayPal Verify Error: ' . curl_error($ch));
            curl_close($ch);
            return ['success' => false, 'message' => 'Failed to verify PayPal payment'];
        }
        curl_close($ch);
        
        $response = json_decode($result, true);
        
        if (isset($response['status'])) {
            return [
                'success' => true,
                'status' => $response['status'],
                'details' => $response
            ];
        }
        
        return ['success' => false, 'message' => 'Could not verify payment status', 'details' => $response];
    }
}
