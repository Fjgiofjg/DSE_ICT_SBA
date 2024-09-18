<?php
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

// Connect to the database
$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    die("Something went wrong");
}

// Check cookie, redirect to login if not set
if (!isset($_COOKIE["uid"])) {
    echo "<script>window.alert('Please login!');window.location.href='login.html';</script>";
}
?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stellar - Search Results</title>
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
                <li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs/Search.png" alt="Search"></button></li>
                <li><button onclick="loading.in('./wish.php')"><img class="buttons" src="imgs/Wish.png" alt="Wish"></button></li>
                <li><button onclick="loading.in('./confirm.php')"><img class="buttons" src="imgs/Order.png" alt="Order History"></button></li>
            </ul>
        </div>
    </section>

    <div class="main">
    <h2>Search Products</h2>
    <!-- Search Box -->
    <form method="GET" action="search.php" style="display: flex; justify-content: center; margin: 20px;">
        <input type="text" name="search" placeholder="Search by Product Name..." style="padding: 10px; width: 300px; border: 1px solid #ccc; border-radius: 4px;"/>
        <button type="submit" style="padding: 10px; border: none; background-color: #007BFF; color: white; border-radius: 4px; margin-left: 10px; cursor: pointer;">Search</button>
    </form>
    <div class="product-container">
            <?php
            // Fetch data based on search input
            $search = isset($_GET['search']) ? mysqli_real_escape_string($link, $_GET['search']) : '';
            $query = "SELECT * FROM products" . ($search ? " WHERE Product_name LIKE '%$search%'" : "");
            $result = mysqli_query($link, $query);
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='product-card'>";
                    echo '<a onclick="loading.in(\'./product.php?product=' . $row['Product_id'] . '\')">';
                    echo "<img src='Prod_img/".$row['Product_id'].".png' alt='".htmlspecialchars($row['Product_name'])."'>";
                    echo '<h3>'.htmlspecialchars($row['Product_name']).'</h3>';
                    echo '<p class="price">$'.round($row['Price'] * (1 - $row['Discount'] / 100), 1).'</p>';
                    echo "</a>";
                    echo '</div>';
                }
            } else {
                echo "<p>No results found for: " . htmlspecialchars($search) . "</p>";
            }
            ?>
        </div>
    </div>

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