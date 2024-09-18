<?php
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

// Connect DB
$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    die("Something went wrong");
} else {
    echo "<script>console.log('DB link successful!')</script>";
}

// Check cookie, no = login page
if (!isset($_COOKIE["uid"])) {
    echo "<script>window.alert('Please login!');window.location.href='login.html';</script>";
}
?>
<html>
<head>
    <title>Stellar - Shopping Cart</title>
    <link rel="stylesheet" href="./header.css">
    <link rel="stylesheet" href="./cart.css">
</head>
<body>
<section class="header">
    <a onclick="loading.in('./home.php')"><img id="logo" src="imgs/Stella_Logo_Small.png" alt="Stella Logo"></a>
    <div>
        <ul id="navbar">
            <li><button onclick="loading.in('./acc.php')"><img class="buttons" src="imgs/Account.png" alt="Account"></button></li>
            <li><button class="active" onclick="loading.in('./cart.php')"><img class="buttons" src="imgs/Cart.png" alt="Cart"></button></li>
            <li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs/Search.png" alt="Search"></button></li>
            <li><button onclick="loading.in('./wish.php')"><img class="buttons" src="imgs/Wish.png" alt="Wish"></button></li>
            <li><button onclick="loading.in('./confirm.php')"><img class="buttons" src="imgs/Order.png" alt="Order History"></button></li>
        </ul>
    </div>
</section>

<section class="cart-container">
    <h1>Shopping Cart</h1>
    <div class="product-container">
        <?php
        // Fetch data & Show user's cart items
        $query_c = "SELECT * FROM cart WHERE uid='" . $_COOKIE["uid"] . "'";
        $result_c = mysqli_query($link, $query_c);
        $total = 0;

		while ($cart_t = mysqli_fetch_assoc($result_c)) {
			$query_p = "SELECT * FROM products WHERE Product_id = " . $cart_t['Product_id'];
			$result_p = mysqli_query($link, $query_p);
			$product = mysqli_fetch_assoc($result_p);
			$final_price = round($product["Price"] * (1 - $product["Discount"] / 100) * $cart_t["Quantity"] , 1);
			$total += $final_price;
			
			echo "<div class='product-card'>";
			echo '<a onclick="loading.in(\'./product.php?product=' . $product['Product_id'] . '\')">';
			echo "<img src='Prod_img/" . $product['Product_id'] . ".png' alt='" . htmlspecialchars($product['Product_name']) . "'>";
			echo '<h3>' . htmlspecialchars($product['Product_name']) . '</h3>';
		
			// Fetch only variations that match the var_id in the cart
			$query_var = "SELECT variation FROM variations WHERE Product_ID = " . $product['Product_id'] . " AND var_id = " . $cart_t['var_id'];
			$result_var = mysqli_query($link, $query_var);
			
			if (mysqli_num_rows($result_var) > 0) {
				echo '<div class="variation-list">';
				while ($variation = mysqli_fetch_assoc($result_var)) {
					echo '<p class="variation">' . htmlspecialchars($variation['variation']) . '</p>';
				}
				echo '</div>';
			} else {
				echo '<p class="variation">No variations available</p>'; // Message when no variations are found
			}
		
			echo '<p class="price">$' . $final_price . '</p>';
			echo '</a>';
			echo '<div class="quantity-control">';
			echo '<button onclick="loading.in(\'./updateQuantity.php?product=' . $cart_t['Product_id'] . '&var_id=' . $cart_t['var_id'] . '&action=decrease\')">-</button>';
			echo '<span>' . $cart_t['Quantity'] . '</span>';
			echo '<button onclick="loading.in(\'./updateQuantity.php?product=' . $cart_t['Product_id'] . '&var_id=' . $cart_t['var_id'] . '&action=increase\')">+</button>';
			echo '</div>';
			echo '<button onclick="loading.in(\'./deleteCart.php?product=' . $cart_t['Product_id'] . '&var_id=' . $cart_t['var_id'] . '\')" id="delbtn" class="button">Delete</button>';
			echo '</div>';
		}
	?>
    </div>
    
    <div class="total-container">
        <h2>Total: $<?php echo $total; ?></h2>
        <button onclick="loading.in('./AddToOrd.php')" id="cartbtn" class="button">Order All Items Above</button>
    </div>
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