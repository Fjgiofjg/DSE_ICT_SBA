<?php
// Database connection parameters
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

// Connect to the database
$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    die("Database connection failed: " . mysqli_connect_error());
} else {
    echo "<script>console.log('DB link successful!')</script>";
}

// Check if user cookie is set; if not, redirect to login page
if (!isset($_COOKIE["uid"])) {
    echo "<script>alert('Please login!'); window.location.href='login.html';</script>";
    exit;
}

// Sanitize the user input from the cookie
$uid = mysqli_real_escape_string($link, $_COOKIE["uid"]); 
$query_r = "SELECT * FROM orders WHERE uid = '$uid' ORDER BY RefNo DESC;";
$result_r = mysqli_query($link, $query_r);
?>

<html>
<head>
    <title>Stellar - Order History</title>
    <link rel="stylesheet" href="./header.css">
    <link rel="stylesheet" href="./home.css">
</head>
<body>
    <section class="header">
        <a onclick="loading.in('./home.php')">
            <img id="logo" src="imgs/Stella_Logo_Small.png" alt="Stella Logo">
        </a>
        <div>
            <ul id="navbar">
                <li><button onclick="loading.in('./acc.php')"><img class="buttons" src="imgs/Account.png" alt="Account"></button></li>
                <li><button onclick="loading.in('./cart.php')"><img class="buttons" src="imgs/Cart.png" alt="Cart"></button></li>
                <li><button onclick="loading.in('./search.php')"><img class="buttons" src="imgs/Search.png" alt="Search"></button></li>
                <li><button onclick="loading.in('./wish.php')"><img class="buttons" src="imgs/Wish.png" alt="Wish"></button></li>
                <li><button onclick="loading.in('./confirm.php')"><img class="buttons" src="imgs/Order.png" alt="Order History"></button></li>
            </ul>
        </div>
    </section>
    <section class="main">
        <h1>Your Order Has Been Accepted!</h1>
        <p>The details of your orders are shown below:<br>Pressing or clicking on the order number can print your order's receipt.</p>
        <?php
        $previousRefNo = null;
        $ord_price = 0;
        echo '<div class="product-container">';

        while ($row = mysqli_fetch_assoc($result_r)) {
            $query_p = "SELECT * FROM products WHERE Product_id = " . $row['Product_id']; 
            $result_p = mysqli_query($link, $query_p);
            $product = mysqli_fetch_assoc($result_p);

            $query_v = "SELECT * FROM variations WHERE Product_ID = " .$row['Product_id']. " AND var_id = " . $row['var_id'];
            $result_v = mysqli_query($link, $query_v);
            $vari = mysqli_fetch_assoc($result_v);

            $final_price = round($product["Price"] * (1 - $product["Discount"] / 100) * $row["Quantity"], 1);
            $currentRefNo = $row['RefNo'];
            echo "<script>console.log('".$currentRefNo."')</script>";

            if ($currentRefNo !== $previousRefNo) {
                
                if ($previousRefNo !== null) {
                    echo '<h3>The Final Price of this order: $' . $ord_price . '</h3>';
                    echo '</div>'; // Close the product-container for the previous order
                }
                echo "<div class='product-card'><a onclick='loading.in(\"./receipt_pdf.php?ref_no=" . $row['RefNo'] . "\")'>";
                echo '<h2>Order ' . htmlspecialchars($currentRefNo) . '</h2>';
                $previousRefNo = $currentRefNo;
                $ord_price = 0; // Reset order price
            }

            if ($vari == null) {
                echo '<p>' . htmlspecialchars($product['Product_name']) .' x ' . intval($row['Quantity']) . '</p>';
                $ord_price += $final_price;
            }else{
                echo '<p>' . htmlspecialchars($product['Product_name']) . ' - ' . $vari['variation'] . ' x ' . intval($row['Quantity']) . '</p>';
                $ord_price += $final_price;
            }
        }

        if ($previousRefNo !== null) {
            echo "<script>console.log('previousRefNo !== null')</script>";
            echo '<h3>The Final Price of this order: $' . $ord_price . '</h3>';
            echo '</div>'; // Close the last product-container
        }
        ?>
        </div>
        <br><b>Please print or save the receipt to show to our members when you come to the Student Union Room to take your order.<br>The Fees will be collected in cash when you visit our room.</b>
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