<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
   $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
   $count_wishlist_items->execute([$user_id]);
   $total_wishlist_counts = $count_wishlist_items->rowCount();
   
   $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $count_cart_items->execute([$user_id]);
   $total_cart_counts = $count_cart_items->rowCount();

   $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_profile->execute([$user_id]);
    if ($select_profile->rowCount() > 0) {
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        $username = $fetch_profile["name"];
        $isRegistered = true;
    } else {
        $username = "Guest";
        $isRegistered = false;
    }
   ?>

<div class="main-navbar shadow-sm sticky-top">
    <div class="top-navbar">
        <div class="container">
            <div class="row">
                <div class="col-md-2 my-auto d-none d-sm-none d-md-block d-lg-block">
                <h5 class="brand-name">Funda Ecom</h5>
                </div>
                <div class="col-md-5 my-auto">
                    
        <form role="search" id="searchForm"  action="components/search.php" method="post">
        <div class="dropdown">
        <input type="text" id="searchInput" name="search" class="form-control"  placeholder="Rechercher par Désignation" style="width: 100%;">
        <div id="productList" class="dropdown-content">
            <!-- Product items will be dynamically added here -->
        </div>
    </div>
        </form>
        <div id="searchResults"></div>
    </div>
                <div class="col-md-5 my-auto">
                    <ul class="nav justify-content-end">
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php">
                                <i class="fa fa-shopping-cart"></i> Cart (<span class="text-warning"><?= $total_cart_counts; ?></span>)</a>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="wishlist.php">
                                <i class="fa fa-heart"></i> Wishlist (<span class="text-warning"><?= $total_wishlist_counts; ?></span>)</a>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user"></i> <?= $username ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php if ($isRegistered) { ?>
                                    <li><a class="dropdown-item" href="update_user.php"><i class="fa fa-user"></i> Profile</a></li>
                                    <li><a class="dropdown-item" href="orders.php"><i class="fa fa-list"></i> My Orders</a></li>
                                    <li><a class="dropdown-item" href="wishlist.php"><i class="fa fa-heart"></i> My Wishlist</a></li>
                                    <li><a class="dropdown-item" href="cart.php"><i class="fa fa-shopping-cart"></i> My Cart</a></li>
                                    <li><a class="dropdown-item" href="components/user_logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
                                <?php } else { ?>
                                    <li><a class="dropdown-item" href="user_register.php"><i class="fa fa-user-plus"></i> Register</a></li>
                                    <li><a class="dropdown-item" href="user_login.php"><i class="fa fa-sign-in"></i> Login</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto"> <!-- Center-align the navbar items -->
                    <li class="nav-item">
                        <a class="nav-link" href="home.php" style="color: white;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php" style="color: white;">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php" style="color: white;">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php" style="color: white;">Cart</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
document.getElementById('searchInput').addEventListener('input', function () {
    var searchTerm = this.value.toLowerCase();
    var container = document.getElementById('productList');

    container.innerHTML = '';

    if (searchTerm.length > 0) {
        $.ajax({
            url: "components/search.php",
            type: "POST",
            data: { search: searchTerm },
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    data.forEach(function (product) {
                        var resultItem = document.createElement('div');
                        resultItem.className = 'search-item';
                        resultItem.textContent = product.name;

                        resultItem.addEventListener('click', function () {
                            window.location.href = 'quick_view.php?pid=' + encodeURIComponent(product.id);
                        });

                        container.appendChild(resultItem);
                    });
                } else {
                    var noResults = document.createElement('div');
                    noResults.className = 'no-results';
                    noResults.textContent = 'No results found';
                    container.appendChild(noResults);
                }
            }
        });

        container.style.display = 'block';
    } else {
        container.style.display = 'none';
    }
});

document.addEventListener('click', function (event) {
    var container = document.getElementById('productList');

    if (!container.contains(event.target)) {
        container.style.display = 'none';
    }
});
</script>