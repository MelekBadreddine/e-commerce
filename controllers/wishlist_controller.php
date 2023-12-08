<?php

include '../models/wishlist_model.php';

class WishlistController {
    private $wishlistModel;

    public function __construct() {
        $this->wishlistModel = new WishlistModel();
    }

    public function createWishlist($user_id, $name) {
        return $this->wishlistModel->createWishlist($user_id, $name);
    }

    public function getWishlistByUser($user_id) {
        return $this->wishlistModel->getWishlistByUser($user_id);
    }

    public function addToWishlist($wishlist_id, $product_id) {
        return $this->wishlistModel->addToWishlist($wishlist_id, $product_id);
    }

    public function removeFromWishlist($wishlist_item_id) {
        return $this->wishlistModel->removeFromWishlist($wishlist_item_id);
    }

    // Add other wishlist-related methods...

}

?>
