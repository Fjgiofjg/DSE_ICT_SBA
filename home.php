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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stellar - Home</title>
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

    <!-- Carousel -->
    <div class="carousel">
        <div class="carousel-images">
            <?php
            // Fetch carousel images dynamically
            $carouselImages = glob("imgs/caro*.{jpg,png,gif}", GLOB_BRACE);
            foreach ($carouselImages as $image) {
                echo '<div class="carousel-image"><img src="' . htmlspecialchars($image) . '" alt="Carousel Image"></div>';
            }
            ?>
        </div>
        <button class="carousel-button left" onclick="moveSlide(-1)">&#10094;</button>
        <button class="carousel-button right" onclick="moveSlide(1)">&#10095;</button>
    </div>

    <script>
        let currentSlide = 0;

        function moveSlide(direction) {
            const slides = document.querySelectorAll('.carousel-image');
            currentSlide = (currentSlide + direction + slides.length) % slides.length;
            const offset = -currentSlide * 100;
            document.querySelector('.carousel-images').style.transform = `translateX(${offset}%)`;
        }

        setInterval(() => moveSlide(1), 5000); // Change slide every 5 seconds
    </script>

<!-- Product Display -->
<h2 style='text-align: center;'>Featured Products</h2>
<div class="product-container">
    
    <?php
    // Fetch only featured products
    $query_t = "SELECT Product_id FROM tags WHERE tag LIKE '%Featured%'";
    $result_t = mysqli_query($link, $query_t);

    // Collect Product IDs from the tags query
    $product_ids = [];
    while ($row_t = mysqli_fetch_assoc($result_t)) {
        $product_ids[] = $row_t['Product_id'];
    }

    // Check if there are any featured products
    if (!empty($product_ids)) {
        $ids = implode(',', array_map('intval', $product_ids)); // Sanitize and create a comma-separated list
        $query = "SELECT * FROM products WHERE Product_id IN ($ids)";
        $result = mysqli_query($link, $query);

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
        echo "<p>No featured products available at this time.</p>";
    }
    ?>
</div>
    <!-- Search Box -->
    <form method="GET" action="search.php" style="display: flex; justify-content: center; margin: 20px;">
        <input type="text" name="search" placeholder="Search by Product Name..." style="padding: 10px; width: 300px; border: 1px solid #ccc; border-radius: 4px;"/>
        <button type="submit" style="padding: 10px; border: none; background-color: #007BFF; color: white; border-radius: 4px; margin-left: 10px; cursor: pointer;">Search</button>
    </form>

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