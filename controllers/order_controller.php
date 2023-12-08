<?php

include '../models/orders_model.php';

class OrderController {
    private $ordersModel;

    public function __construct() {
        $this->ordersModel = new OrdersModel();
    }

    public function placeOrder($user_id, $cartItems) {
        return $this->ordersModel->placeOrder($user_id, $cartItems);
    }

    public function getOrderHistory($user_id, $conn) {
        return $this->ordersModel->getOrderHistory($user_id, $conn); // Pass both user_id and connection
    }

    // Retrieve an order by ID
    public function getOrderById($order_id) {
        return $this->ordersModel->getOrderById($order_id);
    }

    // Cancel an order by ID
    public function cancelOrder($order_id) {
        return $this->ordersModel->cancelOrder($order_id);
    }

    // Other order-related methods...
}


?>
