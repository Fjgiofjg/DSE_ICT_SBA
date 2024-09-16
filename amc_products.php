<?php
// Database connection parameters
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

// Connect to the database
$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    die("Database connection failed");
}

// Check if the user is logged in via cookie
if (!isset($_COOKIE["uid"])) {
    echo "<script>window.alert('Please login!'); window.location.href='login.html';</script>";
    exit;
}

// Retrieve user ID from cookie
$uid = $_COOKIE["uid"];

// Check user role to determine if the user is an admin
$query_u = "SELECT * FROM users WHERE uid = " . intval($uid);
$result_u = mysqli_query($link, $query_u);
$user = mysqli_fetch_assoc($result_u);
if ($user['Is_Admin'] == 0) {
    echo "<script>window.alert('You do not have access to this page!'); window.location.href='home.php';</script>";
    exit;
}

// Handle product update
if (isset($_POST['update_product'])) {
    $productId = mysqli_real_escape_string($link, $_POST['product_id']);
    $productName = mysqli_real_escape_string($link, $_POST['product_name']);
    $productPrice = mysqli_real_escape_string($link, $_POST['product_price']);
    $productDiscount = mysqli_real_escape_string($link, $_POST['product_discount']);

    // Update product query
    $updateQuery = "UPDATE products SET Product_name='$productName', Price='$productPrice', Discount='$productDiscount' WHERE Product_id='$productId'";

    if (mysqli_query($link, $updateQuery)) {
        echo "<script>window.alert('Product updated successfully!'); window.location.href='product_list.php';</script>";
    } else {
        echo "<script>window.alert('Error updating product: " . mysqli_error($link) . "');</script>";
    }
}
?>

<html>
<head>
    <title>Update Product</title>
    <link rel="stylesheet" href="./header.css">
    <link rel="stylesheet" href="./home.css">
    <style>
        .product-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 items per row */
            gap: 10px; /* Space between items */
            overflow-y: auto; /* Enable vertical scroll */
            max-height: 400px; /* Limit height for scrolling */
            padding: 10px;
        }

        .product-card {
            border: 3px solid #FFB53F;
            border-radius: 23px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .search-bar {
            margin: 20px;
            display: flex;
            justify-content: center;
        }

        .search-bar input {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        .search-bar button {
            padding: 10px;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #0056b3;
        }
    </style>
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

    <!-- Search Bar -->
    <div class="search-bar">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Product Display -->
    <div class="product-container">
        <?php
        // Fetch data based on search input
        $search = isset($_GET['search']) ? mysqli_real_escape_string($link, $_GET['search']) : '';
        $query = "SELECT * FROM products" . ($search ? " WHERE Product_name LIKE '%$search%'" : "");
        $result = mysqli_query($link, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='product-card'>";
            echo '<a onclick="loading.in(\'./amc_edit_prod.php?product=' . $row['Product_id'] . '\')">';
            echo "<img src='Prod_img/".$row['Product_id'].".png' alt='".htmlspecialchars($row['Product_name'])."'>";
            echo '<h3>'.htmlspecialchars($row['Product_name']).'</h3>';
            echo '<p class="price">$'.round($row['Price'] * (1 - $row['Discount'] / 100), 1).'</p>';
            echo "</a>";
            echo '</div>';
        }
        ?>
    </div>

    <div class="update-form">
        <h2>Update Product</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo isset($_GET['id']) ? intval($_GET['id']) : ''; ?>">
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" required>
            <label for="product_price">Price:</label>
            <input type="number" step="0.01" name="product_price" required>
            <label for="product_discount">Discount (%):</label>
            <input type="number" name="product_discount" min="0" max="100" required>
            <label for="product_image">Product Image:</label>
            <input type="file" name="product_image" accept="image/*" required>
            <button type="submit" name="update_product">Update Product</button>
        </form>
    </div>

    <div class="loading">
        <img id="logo" src="imgs/Stella_AMC_Logo_Small.png" alt="Stella Logo">
    </div>

    <script>
        // Loading animation functionality
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