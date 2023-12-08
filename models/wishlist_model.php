<?php

class WishlistModel {

    public function createWishlist($user_id, $name) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO `wishlist` (`user_id`, `name`) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $name);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function getWishlistByUser($user_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM `wishlist` WHERE `user_id` = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $wishlist = array();
        while ($row = $result->fetch_assoc()) {
            $wishlist[] = $row;
        }
        return $wishlist;
    }

    public function addToWishlist($wishlist_id, $product_id) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO `wishlist_items` (`wishlist_id`, `product_id`) VALUES (?, ?)");
        $stmt->bind_param("ii", $wishlist_id, $product_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function removeFromWishlist($wishlist_item_id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM `wishlist_items` WHERE `id` = ?");
        $stmt->bind_param("i", $wishlist_item_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Add other methods related to wishlist here...

}

?>
