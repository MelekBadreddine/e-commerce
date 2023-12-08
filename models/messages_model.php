<?php

class MessagesModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getAllMessages() {
        $select_messages = $this->conn->query("SELECT * FROM `messages`");
        return $select_messages->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveMessage($user_id, $name, $email, $number, $msg) {
        $insert_message = $this->conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
        return $insert_message->execute([$user_id, $name, $email, $number, $msg]);
    }
}
?>
