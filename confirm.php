<?php
// Database connection parameters
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

// Connect to the database
$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    // If connection fails, output an error message
    die("Database connection failed: " . mysqli_connect_error());
} else {
    // Log successful connection in the console
    echo "<script>console.log('DB link successful!')</script>";
}

// Check if user cookie is set; if not, redirect to login page
if (!isset($_COOKIE["uid"])) {
    echo "<script>alert('Please login!'); window.location.href='login.html';</script>";
    exit; // Stop further execution
}

// Sanitize the user input from the cookie
$uid = mysqli_real_escape_string($link, $_COOKIE["uid"]); 
$query_r = "SELECT * FROM orders WHERE uid = '$uid'"; // Query to get orders for the user
$result_r = mysqli_query($link, $query_r); // Execute the query
?>

<html>
<head>
    <title>Stellar - Order History</title>
    <link rel="stylesheet" href="./header.css">
    <link rel="stylesheet" href="./home.css">
    <script src="./owlcarousel/owl.carousel.min.js"></script>
</head>
<body>
    <section class="header">
        <a onclick="loading.in('./home.php')"><img id="logo" src="imgs/Stella_Logo_Small.png" alt="Stella Logo"></a>
        <div>
            <ul id="navbar">
                <!-- Navigation buttons for different sections -->
                <li><button onclick="loading.in('./acc.php')"><img class="buttons" src="imgs/Account.png" alt="Account"></button></li>
                <li><button onclick="loading.in('./cart.php')"><img class="buttons" src="imgs/Cart.png" alt="Cart"></button></li>
                <li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs/Search.png" alt="Search"></button></li>
                <li><button onclick="loading.in('./wish.php')"><img class="buttons" src="imgs/Wish.png" alt="Wish"></button></li>
                <li><button class='active' onclick="loading.in('./confirm.php')" style="color: blue; font-size: 20px;"><p>OH</p></button></li>
            </ul>
        </div>
    </section>
    <section class="main">
        <h1>Your Order Has Been Accepted!</h1>
        <p>The details of your orders are shown below:<br>
        <?php
        // Initialize variables to track orders and prices
        $previousRefNo = null;
        $ord_price = 0;
        echo '<div class="product-container">'; // Start the product container
        while ($row = mysqli_fetch_assoc($result_r)) { // Loop through each order
            // Get product details for the ordered product
            $query_p = "SELECT * FROM products WHERE Product_id = " . intval($row['Product_id']); 
            $result_p = mysqli_query($link, $query_p);
            $product = mysqli_fetch_assoc($result_p); // Fetch product details
            // Calculate the final price after discount
            $final_price = round($product["Price"] * (1 - $product["Discount"] / 100), 1);
            $currentRefNo = $row['RefNo']; // Get the current order reference number
            if ($currentRefNo !== $previousRefNo) { // Check if it's a new order
                if ($previousRefNo !== null) {
                    // Display the total price of the previous order
                    echo '<h3>The Final Price of this order: $' . $ord_price . '</h3>';
                    echo '</a></div>'; // Close the previous product card
                }
                // Start a new product card for the new order
                echo "<div class='product-card'><a onclick='loading.in(\"./receipt_pdf.php?ref_no=" . $row['RefNo'] . "\")'>";
                echo '<h2>Order ' . htmlspecialchars($currentRefNo) . '</h2>'; // Display the order reference
                $previousRefNo = $currentRefNo; // Update previous reference number
                $ord_price = 0; // Reset order price
            }
            // Display each product in the order
            echo '<p>' . htmlspecialchars($product['Product_name']) . ' x ' . intval($row['Quantity']) . '</p>';
            // Accumulate the total price for the current order
            $ord_price += $final_price;
        }
        if ($previousRefNo !== null) {
            // Display the total price for the last order
            echo '<h3>The Final Price of this order: $' . $ord_price . '</h3>';
            echo '</div>'; // Close the product card
        }
        ?>
        </div>
        <br><b>Please pay in cash when you come to the Student Union Room to take your order.</b>
    </section>

    <div class="loading">
        <img id="logo" src="imgs/Stella_Logo_Small.png" alt="Stella Logo">
    </div>
    <script>
        const loading = {
            container: document.querySelector(".loading"), // Select the loading element
            in(target) {
                this.container.classList.remove("loading_out"); // Remove loading-out class to show loading
                setTimeout(() => {
                    window.location.href = target; // Redirect after 500ms
                }, 500);
            },
            out() {
                this.container.classList.add("loading_out"); // Add loading-out class for animation
            }
        };
        window.addEventListener("load", () => {
            loading.out(); // Hide loading when the page loads
        });
    </script>
</body>
</html>