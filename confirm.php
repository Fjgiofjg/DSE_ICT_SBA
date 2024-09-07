<?php
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

// Check cookie; redirect to login page if not set
if (!isset($_COOKIE["uid"])) {
    echo "<script>alert('Please login!'); window.location.href='login.html';</script>";
    exit;
}

$uid = mysqli_real_escape_string($link, $_COOKIE["uid"]); // Sanitize user input
$query_r = "SELECT * FROM orders WHERE uid = '$uid'"; // Use single quotes for string literals
$result_r = mysqli_query($link, $query_r);
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
        $previousRefNo = null;
        $ord_price = 0;
        echo '<div class="product-container">';
        while ($row = mysqli_fetch_assoc($result_r)) {
            $query_p = "SELECT * FROM products WHERE Product_id = " . intval($row['Product_id']); // Use intval for safety
            $result_p = mysqli_query($link, $query_p);
            $product = mysqli_fetch_assoc($result_p);
            $final_price = round($product["Price"] * (1 - $product["Discount"] / 100), 1);
            $currentRefNo = $row['RefNo'];
            if ($currentRefNo !== $previousRefNo) {
                if ($previousRefNo !== null) {
                    echo '<h3>The Final Price of this order: $' . $ord_price . '</h3>';
                    echo '</div>';
                }
                echo "<div class='product-card'>";
                echo '<h2>Order ' . htmlspecialchars($currentRefNo) . '</h2>'; // Use htmlspecialchars for output
                $previousRefNo = $currentRefNo;
                $ord_price = 0;
            }
            echo '<p>' . htmlspecialchars($product['Product_name']) . ' x ' . intval($row['Quantity']) . '</p>';
            $ord_price += $final_price;
        }
        if ($previousRefNo !== null) {
            echo '<h3>The Final Price of this order: $' . $ord_price . '</h3>';
            echo '</div>';
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