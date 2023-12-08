<?php
include '../models/messages_model.php';

class MessagesController {
    private $messagesModel;

    public function __construct() {
        $this->messagesModel = new MessagesModel();
    }

    public function getAllMessages() {
        return $this->messagesModel->getAllMessages();
    }

    public function saveMessage($user_id, $name, $email, $number, $msg) {
        return $this->messagesModel->saveMessage($user_id, $name, $email, $number, $msg);
    }
}
?>
