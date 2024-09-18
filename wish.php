<?php
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

// Connect to the database
$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if user is logged in
if (!isset($_COOKIE["uid"])) {
    echo "<script>window.alert('Please login!');window.location.href='login.html';</script>";
    exit; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stellar - Wishlist</title>
    <link rel="stylesheet" href="./header.css">
    <link rel="stylesheet" href="./wish.css">
</head>
<body>
<section class="header">
    <a onclick="loading.in('./home.php')">
        <img id="logo" src="imgs/Stella_Logo_Small.png" alt="Stella Logo">
    </a>
    <div>
        <ul id="navbar">
            <li><button onclick="loading.in('./acc.php')"><img class="buttons" src="imgs/Account.png" alt="Account"></button></li>
            <li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs/Search.png" alt="Search"></button></li>
            <li><button onclick="loading.in('./cart.php')"><img class="buttons" src="imgs/Cart.png" alt="Cart"></button></li>
            <li><button class="active" onclick="loading.in('./wish.php')"><img class="buttons" src="imgs/Wish.png" alt="Wish"></button></li>
            <li><button onclick="loading.in('./confirm.php')"><img class="buttons" src="imgs/Order.png" alt="Order History"></button></li>
        </ul>
    </div>
</section>
<section class="main">
    <h1>Your Wishlist</h1>
    <?php
        // Function to display the product card
        function displayProductCard($link, $product, $variations) {
            echo "<div class='product-card'>";
            echo '<a onclick="loading.in(\'./product.php?product=' . $product['Product_id'] . '\')">';
            echo "<img src='Prod_img/" . htmlspecialchars($product['Product_id']) . ".png' alt='" . htmlspecialchars($product['Product_name']) . "'>";
            echo '<h3>' . htmlspecialchars($product['Product_name']) . '</h3>';
            echo '</a>';

            // Display product variations
            if (!empty($variations)) {
                echo '<div class="variation-list">';
                foreach ($variations as $variation) {
                    echo '<p class="variation">' . htmlspecialchars($variation) . '</p>';
                }
                echo '</div>';
            } else {
                echo '<p class="variation">No variations available</p>';
            }

            echo '<div class="button-container">';
            echo "<button onclick=\"loading.in('./AddToCart.php?product_id=" . $product['Product_id'] . "')\" class=\"cartbtn\">Add to Cart</button>";
            echo "<button onclick=\"loading.in('./deleteWish.php?product_id=" . $product['Product_id'] . "')\" class=\"wishbtn\">Remove From Wish List</button>";
            echo '</div>';
            echo '</div>'; // Close product-card div
        }

        // Fetch the user's wishlist
		$query_w = "SELECT * FROM wish WHERE uid='" . mysqli_real_escape_string($link, $_COOKIE["uid"]) . "'";
		$result_w = mysqli_query($link, $query_w);

		if ($result_w && mysqli_num_rows($result_w) > 0) {
			echo '<div class="product-container">'; // Open product container div
			while ($wish_t = mysqli_fetch_assoc($result_w)) {
				// Check if var_id exists before using it
				if (isset($wish_t['var_id'])) {
					// Fetch the product details
					$query_p = "SELECT * FROM products WHERE Product_id = " . intval($wish_t['Product_id']);
					$result_p = mysqli_query($link, $query_p);

					if ($result_p && $product = mysqli_fetch_assoc($result_p)) {
						// Fetch corresponding variations for the product
						$query_var = "SELECT variation FROM variations WHERE Product_ID = " . intval($product['Product_id']) . " AND var_id = " . intval($wish_t['var_id']);
						$result_var = mysqli_query($link, $query_var);
						$variations = [];

						// Store matching variations
						if ($result_var) {
							while ($variation = mysqli_fetch_assoc($result_var)) {
								$variations[] = $variation['variation'];
							}
						}

						// Display the product card with variations
						displayProductCard($link, $product, $variations);
					}
				} else {
					// Handle case where var_id is missing, if necessary
					echo "<p class='error'>Variation ID missing for product ID: " . htmlspecialchars($wish_t['Product_id']) . "</p>";
				}
			}
			echo '</div>'; // Close product container div
		} else {
			echo "<div class='no-items'>No items in your wishlist.</div>";
		}

		// Clean up results
		mysqli_free_result($result_w);
        ?>
</section>

<div class="loading">
    <img id="logo" src="imgs/Stella_Logo_Small.png" alt="Stella Logo">
</div>

<script>
    const loading = {
        container: document.querySelector(".loading"),
        in(target) {
            this.container.classList.remove("loading_out");
            setTimeout(() => {
                window.location.href = target;
            }, 500);
        },
        out() {
            this.container.classList.add("loading_out");
        }
    };

    window.addEventListener("load", () => {
        loading.out();
    });
</script>
</body>
</html>