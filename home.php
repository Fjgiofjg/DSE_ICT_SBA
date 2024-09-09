<?php
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

// Connect to the database
$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    die("Something went wrong");
} else {
    echo "<script>console.log('DB link successful!')</script>";
}

// Check cookie, redirect to login if not set
if (!isset($_COOKIE["uid"])) {
    echo "<script>window.alert('Please login!');window.location.href='login.html';</script>";
}
?>

<html>
<head>
    <title>Stellar - Home</title>
    <link rel="stylesheet" href="./header.css">
    <link rel="stylesheet" href="./home.css">
    <link rel="stylesheet" href="./owlcarousel/owl.theme.default.css">
    <link rel="stylesheet" href="./owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="./owlcarousel/owl.carousel.css">
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
                <li><button onclick="loading.in('./confirm.php')" style="color: blue; font-size: 20px;"><p>OH</p></button></li>
            </ul>
        </div>
    </section>

    <section class="owl-carousel owl-theme">
        <div> Your Content </div>
        <div> Your Content </div>
        <div> Your Content </div>
        <div> Your Content </div>
        <div> Your Content </div>
        <div> Your Content </div>
        <div> Your Content </div>
    </section>

    <!-- Search Box -->
    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search products..." />
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="product-container">
        <?php
        // Fetch data based on search input
        $search = isset($_GET['search']) ? mysqli_real_escape_string($link, $_GET['search']) : '';
        $query = "SELECT * FROM products" . ($search ? " WHERE Product_name LIKE '%$search%'" : "");
        $result = mysqli_query($link, $query);
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='product-card'>";
                echo '<a onclick="loading.in(\'./product.php?product=' . $row['Product_id'] . '\')">';
                    echo "<img src='Prod_img/".$row['Product_id'].".png' height='300px' width='300px' alt='".htmlspecialchars($row['Product_name'])."'>";
                    echo '<h3>'.htmlspecialchars($row['Product_name']).'</h3>';
                    echo '<p class="price">$'.round($row['Price'] * (1 - $row['Discount'] / 100), 1).'</p>';
                echo "</a>";
            echo '</div>';
        }
        ?>
    </div>

    <div class="loading">
        <img id="logo" src="imgs/Stella_Logo_Small.png" alt="Stella Logo">
    </div>
</body>
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
</html>