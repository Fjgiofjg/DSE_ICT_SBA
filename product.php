<?php
// Database connection details
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    die("Something went wrong");
} else {
    echo "<script>console.log('DB link successful!')</script>";
}

if (!isset($_COOKIE["uid"])) {
    echo "<script>";
    echo "window.alert('Please login!');";
    echo "window.location.href='login.html';";
    echo "</script>";
}

// Fetch data from the database
$query = "SELECT * FROM products WHERE Product_id = " . $_GET['product'];
$result = mysqli_query($link, $query);
$product = mysqli_fetch_assoc($result);

// Fetch image count dynamically
$productImages = glob("Prod_img/" . htmlspecialchars($product['Product_id']) . "-*.png");
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
                <li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs/Search.png" alt="Search"></button></li>
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
            $productId = intval($_GET['product']); // Sanitize input

            // SQL query to fetch tags
            $sql = "SELECT tag FROM tags WHERE product_id = $productId";
            $result_t = mysqli_query($link, $sql);

            // Check if any tags were found
            if ($result_t && mysqli_num_rows($result_t) > 0) {
                echo '<div class="tags">';
                // Loop through the results and print each tag
                while ($row = mysqli_fetch_assoc($result_t)) {
                    echo '<span class="tag">' . htmlspecialchars($row['tag']) . '</span>';
                }
                echo '</div>';
            } else {
                echo '<div class="tags">No tags available</div>';
            }
            ?>
            <div class="desc"><?php echo ($product['Product_desc']); ?></div>
            <?php if ($product["Discount"] > 0): ?>
            <?php endif; ?>
            <div class="price-buttons">
                <?php
                // Fetch variations from the database
                $productId = $_GET['product']; // Make sure to validate/sanitize this input
                $query_v = "SELECT variation FROM variations WHERE Product_ID = " . intval($productId);
                $result_v = mysqli_query($link, $query_v);

                $variations = [];
                while ($row = mysqli_fetch_assoc($result_v)) {
                    $variations[] = $row;
                }
            ?>

            <div class="variations">
                <?php foreach ($variations as $variation): ?>
                    <div class="variation" onclick="selectVariation(this)"><?php echo htmlspecialchars($variation['variation']); ?></div>
                <?php endforeach; ?>
                </div>
                <p>Number of stock: <?php echo htmlspecialchars($product["Remain_no"]); ?></p>
                <p>Discount: <?php echo htmlspecialchars($product["Discount"]); ?>%</p>
                <p>Final Price: $<?php echo round($product["Price"] * (1 - $product["Discount"] / 100), 1); ?></p>
                <div class="button-container">
                    <button onclick="loading.in('./AddToCart.php?product_id=<?php echo $product['Product_id']; ?>')" class="cartbtn">Add to Cart</button>
                    <button onclick="loading.in('./AddToWish.php?product_id=<?php echo $product['Product_id']; ?>')" class="wishbtn">Add to Wish List</button>
                </div>
            </div>
        </div>
    </div>
    <div class="loading">
        <img id="logo" src="imgs/Stella_Logo_Small.png" alt="Stella Logo">
    </div>
    <script>
        let currentSlide = 0;

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

        function selectVariation(element) {
            document.querySelectorAll('.variation').forEach(item => item.classList.remove('selected'));
            element.classList.add('selected');
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
</body>
</html>