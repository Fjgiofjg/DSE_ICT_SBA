<?php
// Database connection parameters
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

// Connect to the database
$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    die("Database connection failed"); // Handle connection error
} else {
    echo "<script>console.log('DB link successful!')</script>"; // Log successful connection
}

// Check if the user is logged in via cookie
if (!isset($_COOKIE["uid"])) {
    echo "<script>window.alert('Please login!'); window.location.href='login.html';</script>";
    exit; // Stop further execution
}

// Retrieve user ID from cookie
$uid = $_COOKIE["uid"];

// Check user role to determine if the user is an admin
$query_u = "SELECT * FROM users WHERE uid = " . intval($uid); // Sanitize uid
$result_u = mysqli_query($link, $query_u);
if ($result_u) {
    $user = mysqli_fetch_assoc($result_u); // Fetch user data
} else {
    echo "Error: " . mysqli_error($link); // Handle query error
}

// Check if the user is an admin
if ($user['Is_Admin'] == 0) {
    echo "<script>window.alert('You do not have access to this page!\nReturning to Home Page'); window.location.href='home.php';</script>";
    exit; // Stop further execution
}

// Handle order completion
if (isset($_POST['complete_order'])) {
    $orderRefNo = mysqli_real_escape_string($link, $_POST['order_ref_no']);
    
    // Move order to done_orders
    $moveOrderQuery = "INSERT INTO done_orders SELECT * FROM orders WHERE RefNo = '$orderRefNo'";
    $deleteOrderQuery = "DELETE FROM orders WHERE RefNo = '$orderRefNo'";
    
    if (mysqli_query($link, $moveOrderQuery) && mysqli_query($link, $deleteOrderQuery)) {
        echo "<script>window.alert('Order marked as done!');</script>";
    } else {
        echo "<script>window.alert('Error completing order: " . mysqli_error($link) . "');</script>";
    }
}
?>

<html>
<head>
    <title>Stellar AMC - Accepted Orders</title>
    <link rel="stylesheet" href="./header.css">
    <link rel="stylesheet" href="./home.css">
</head>
<body>
    <section class="header">
    <a onclick="loading.in('./AdminHome.php')"><img id="logo" src="imgs/Stella_AMC_Logo_Small.png" alt="Stella AMC Logo"></a>
        <div>
            <ul id="navbar">
                <li><button onclick="loading.in('./acc.php')"><img class="buttons" src="imgs/Account.png" alt="Account"></button></li>
                <li><button onclick="loading.in('./cart.php')"><img class="buttons" src="imgs/Cart.png" alt="Cart"></button></li>
                <li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs/Search.png" alt="Search"></button></li>
            </ul>
        </div>
    </section>
    <section class="main">
        <h1>Accepted Orders</h1>
        
        <!-- Search Box -->
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by Order Ref No..." />
            <button type="submit">Search</button>
        </form>

        <?php
        // Initialize search variable
        $search = isset($_GET['search']) ? mysqli_real_escape_string($link, $_GET['search']) : '';

        // Corrected query to get all orders, apply search if provided
        $query = "SELECT * FROM orders WHERE uid = '$uid'" . ($search ? " AND RefNo LIKE '%$search%'" : "") . " ORDER BY RefNo DESC";
        $result = mysqli_query($link, $query);
        
        // Initialize variables for processing orders
        $previousRefNo = null;
        $ord_price = 0;
        echo '<div class="product-container">';
        
        // Loop through each order
        while ($row = mysqli_fetch_assoc($result)) {
            // Get product details for the current order
            $query_p = "SELECT * FROM products WHERE Product_id = " . intval($row['Product_id']); // Sanitize Product_id
            $result_p = mysqli_query($link, $query_p);
            $product = mysqli_fetch_assoc($result_p);

            $query_v = "SELECT * FROM variations WHERE Product_ID = " .$row['Product_id']. " AND var_id = " . $row['var_id'];
            $result_v = mysqli_query($link, $query_v);
            $vari = mysqli_fetch_assoc($result_v);

            // Calculate the final price after discount
            $final_price = round($product["Price"] * (1 - $product["Discount"] / 100) * $row["Quantity"], 1);
            $currentRefNo = $row['RefNo']; // Current order reference number
            
            // Check if we need to start a new order section
            if ($currentRefNo !== $previousRefNo) {
                // If not the first order, display the total price of the previous order
                if ($previousRefNo !== null) {
                    echo '<h3>Total Price: $' . $ord_price . '</h3>';
                    // Add "Mark as Done" button
                    echo '<form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="order_ref_no" value="' . htmlspecialchars($currentRefNo) . '" />
                        <button type="submit" name="complete_order">Mark as Done</button>
                    </form>';
                    echo '</div>'; // Close the previous order section
                }
                // Start a new order section
                echo "<div class='product-card'>";
                echo '<h2>Order ' . htmlspecialchars($currentRefNo) . '</h2>'; // Display order reference
                $previousRefNo = $currentRefNo; // Update previous reference number
                $ord_price = 0; // Reset order price
            }
            if ($vari == null) {
                echo '<p>' . htmlspecialchars($product['Product_name']) .' x ' . intval($row['Quantity']) . '</p>';
                $ord_price += $final_price;
            } else {
                echo '<p>' . htmlspecialchars($product['Product_name']) . ' - ' . $vari['variation'] . ' x ' . intval($row['Quantity']) . '</p>';
                $ord_price += $final_price;
            }
        }
        // Display the total price for the last order
        if ($previousRefNo !== null) {
            echo '<h3>Total Price: $' . $ord_price . '</h3>';
            // Add "Mark as Done" button
            echo '<form method="POST" action="" style="display:inline;">
                <input type="hidden" name="order_ref_no" value="' . htmlspecialchars($currentRefNo) . '" />
                <button type="submit" name="complete_order">Mark as Done</button>
            </form>';
            echo '</div>'; // Close the final order section
        }
        ?>
        </div>
    </section>

    <div class="loading">
        <img id="logo" src="imgs/Stella_AMC_Logo_Small.png" alt="Stella AMC Logo">
    </div>
    
    <script>
        // Loading animation functionality
        const loading = {
            container: document.querySelector(".loading"), // Get the loading element
            in(target) {
                this.container.classList.remove("loading_out"); // Show loading
                setTimeout(() => {
                    window.location.href = target; // Redirect after 500ms
                }, 500);
            },
            out() {
                this.container.classList.add("loading_out"); // Hide loading
            }
        };
        
        // Hide loading animation on page load
        window.addEventListener("load", () => {
            loading.out();
        });
    </script>
</body>
</html>