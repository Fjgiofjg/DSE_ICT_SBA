<?php
// Database connection details
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    die("Database connection failed: " . mysqli_connect_error());
} else {
    echo "<script>console.log('DB link successful!')</script>";
}

if (!isset($_COOKIE["uid"])) {
    echo "<script>
            window.alert('Please login!');
            window.location.href='login.html';
          </script>";
    exit; // Terminate execution after redirection
}

// Fetch product data from the database
$productId = intval($_GET['product']); // Sanitize input
$query = "SELECT * FROM products WHERE Product_id = $productId";
$result = mysqli_query($link, $query);
if (!$result) {
    die("Product query failed: " . mysqli_error($link));
}
$product = mysqli_fetch_assoc($result);

// Fetch image count dynamically
$productImages = glob("Prod_img/" . $productId . "-*.png");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product["Product_name"]); ?> | Stellar</title>
    <link rel="stylesheet" href="./header.css">
    <link rel="stylesheet" href="./product.css">
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
        <div class="product-image-carousel">
            <div class="carousel">
                <?php foreach ($productImages as $index => $imagePath): ?>
                    <div class="carousel-item">
                        <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($product['Product_name']); ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="prev" onclick="moveCarousel(-1)">&#10094;</button>
            <button class="next" onclick="moveCarousel(1)">&#10095;</button>
            <div class="preview">
                <?php foreach ($productImages as $index => $imagePath): ?>
                    <div class="preview-item" onclick="currentSlide = <?php echo $index; ?>; showSlide(currentSlide);">
                        <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Preview">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="product-info">
            <h1><?php echo htmlspecialchars($product['Product_name']); ?></h1>
            <?php
            // SQL query to fetch tags
            $sql = "SELECT tag FROM tags WHERE product_id = $productId";
            $result_t = mysqli_query($link, $sql);
            if (!$result_t) {
                die("Tags query failed: " . mysqli_error($link));
            }

            if (mysqli_num_rows($result_t) > 0) {
                echo '<div class="tags">';
                while ($row = mysqli_fetch_assoc($result_t)) {
                    echo '<span class="tag">' . htmlspecialchars($row['tag']) . '</span>';
                }
                echo '</div>';
            } else {
                echo '<div class="tags">No tags available</div>';
            }
            ?>
            <div class="desc"><?php echo nl2br(htmlspecialchars($product['Product_desc'])); ?></div>
            <div class="price-buttons">
                <?php
                $query_v = "SELECT var_id, variation FROM variations WHERE Product_ID = $productId";
                $result_v = mysqli_query($link, $query_v);
                if (!$result_v) {
                    die("Variations query failed: " . mysqli_error($link));
                }

                $variations = [];
                while ($row = mysqli_fetch_assoc($result_v)) {
                    $variations[] = $row;
                }
                ?>

                <div class="variations" id="variations-container">
                    <?php foreach ($variations as $variation): ?>
                        <div class="variation" 
                            onclick="selectVariation(this, <?php echo intval($variation['var_id']); ?>)">
                            <?php echo htmlspecialchars($variation['variation']); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p>Number of stock: <?php echo htmlspecialchars($product["Remain_no"]); ?></p>
                <p>Discount: <?php echo htmlspecialchars($product["Discount"]); ?>%</p>
                <p>Final Price: $<?php echo round($product["Price"] * (1 - $product["Discount"] / 100), 2); ?></p>
                <div class="button-container">
                    <button id="add-to-cart-btn" class="cartbtn" onclick="loading.in('./AddToCart.php?product_id=<?php echo intval($product['Product_id']); ?>&variation_id=' + selectedVariationId)">Add to Cart</button>
                    <button onclick="loading.in('./AddToWish.php?product_id=<?php echo intval($product['Product_id']); ?>&variation_id=' + selectedVariationId)" class="wishbtn">Add to Wish List</button>
                </div>
            </div>
        </div>
        <div class="loading">
            <img id="logo" src="imgs/Stella_Logo_Small.png" alt="Stella Logo">
        </div>
        <script>
            let currentSlide = 0;
            let selectedVariationId = null;

            function showSlide(index) {
                const slides = document.querySelectorAll('.carousel-item');
                if (index >= slides.length) currentSlide = 0;
                if (index < 0) currentSlide = slides.length - 1;

                slides.forEach((slide, i) => {
                    slide.style.display = (i === currentSlide) ? 'block' : 'none';
                });
            }

            function moveCarousel(step) {
                currentSlide += step;
                showSlide(currentSlide);
            }

            function selectVariation(element, varId) {
                document.querySelectorAll('.variation').forEach(item => item.classList.remove('selected'));
                element.classList.add('selected');
                selectedVariationId = varId;
            }

            function addToCart(productId) {
                if (selectedVariationId === null) {
                    alert("Please select a variation before adding to the cart.");
                    return;
                }
                const targetUrl = `./AddToCart.php?product_id=${encodeURIComponent(productId)}&variation_id=${encodeURIComponent(selectedVariationId)}`;
                loading.in(targetUrl);
            }

            function addToWishList(productId) {
                if (selectedVariationId === null) {
                    alert("Please select a variation before adding to the wish list.");
                    return;
                }
                const targetUrl = `./AddToWish.php?product_id=${encodeURIComponent(productId)}&variation_id=${encodeURIComponent(selectedVariationId)}`;
                loading.in(targetUrl);
            }

            window.onload = function() {
                showSlide(currentSlide);
                loading.out();
            };

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
        </script>
    </section>
</body>
</html>