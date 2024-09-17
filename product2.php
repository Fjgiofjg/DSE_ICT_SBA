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
    <link rel="stylesheet" href="./product2.css">
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
        <div class="product-image">
            <img id="mainImage" src="<?php echo htmlspecialchars($productImages[0]); ?>" alt="Product Image">
        </div>
        <div class="product-details">
            <div class="product-name"><?php echo htmlspecialchars($product['Product_name']); ?></div>
            <?php
            $sql = "SELECT tag FROM tags WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if any tags were found
            if ($result->num_rows > 0) {
                echo '<div class="tags">';
                // Loop through the results and print each tag
                while ($row = $result->fetch_assoc()) {
                    echo '<span class="tag">' . htmlspecialchars($row['tag_name']) . '</span>';
                }
                echo '</div>';
            } else {
                echo '<div class="tags">No tags available</div>';
            }

            $stmt->close();
            ?>
            <div class="product-description"><?php echo htmlspecialchars($product['Product_desc']); ?></div>
            <div class="variations">
                <div class="variation" onclick="selectVariation(this)">Color 1</div>
                <div class="variation" onclick="selectVariation(this)">Color 2</div>
                <div class="variation" onclick="selectVariation(this)">Color 3</div>
            </div>
            <div class="price">$<?php echo round($product["Price"] * (1 - $product["Discount"] / 100), 1); ?></div>
            <div class="buttons">
                <button onclick="loading.in('./AddToCart.php?product_id=<?php echo $product['Product_id']; ?>')" class="button">Add to Cart</button>
                <button onclick="loading.in('./AddToWish.php?product_id=<?php echo $product['Product_id']; ?>')" class="button">Add to Wish List</button>
            </div>
            <div class="preview">
                <?php foreach ($productImages as $index => $imagePath): ?>
                    <div class="preview-item" onclick="updateMainImage('<?php echo htmlspecialchars($imagePath); ?>', this)">
                        <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Preview">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <div class="loading">
        <img id="logo" src="imgs/Stella_Logo_Small.png" alt="Stella Logo">
    </div>
    <script>
        function updateMainImage(imageSrc, element) {
            document.getElementById('mainImage').src = imageSrc;
            document.querySelectorAll('.preview-item').forEach(item => item.classList.remove('selected'));
            element.classList.add('selected');
        }

        function selectVariation(element) {
            document.querySelectorAll('.variation').forEach(item => item.classList.remove('selected'));
            element.classList.add('selected');
        }

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

        window.onload = function() {
            loading.out();
        };
    </script>
</body>
</html>