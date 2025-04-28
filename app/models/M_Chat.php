<?php
class M_Chat {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getBotResponse($message) {
        $message = strtolower($message);
        
        $responses = [
            'hello' => 'Hi! How can I help you today?',
            'hi' => 'Hello! Welcome to Frostine Bakery!',
            'menu' => 'You can check our menu on the Products page',
            'price' => 'Our prices vary by product. Please check our Products page for details',
            'order' => 'You can place an order through our website after logging in',
            'delivery' => 'Yes, we offer delivery services!',
            'location' => 'We have multiple branches. You can find them on our Contact page',
            'contact' => 'You can reach us at contact@frostinebakery.com or call us at 0763172153'
        ];

        foreach ($responses as $keyword => $response) {
            if (strpos($message, $keyword) !== false) {
                return $response;
            }
        }

        return "I'm sorry, I don't understand. Please try asking something else or contact our customer service.";
    }
}