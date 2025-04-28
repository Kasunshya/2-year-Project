<?php
class Chat extends Controller {
    private $chatModel;

    public function __construct() {
        $this->chatModel = $this->model('M_Chat');
    }

    public function index() {
        $this->view('chat/index');
    }

    public function sendMessage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userMessage = trim($_POST['message']);
            $response = $this->chatModel->getBotResponse($userMessage);
            
            echo json_encode(['response' => $response]);
        }
    }
}