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

// Check if the product ID is set
if (!isset($_GET['product'])) {
    echo "<script>window.alert('No product specified.'); window.location.href='product_list.php';</script>";
    exit;
}

$productId = intval($_GET['product']);

// Fetch product details
$query = "SELECT * FROM products WHERE Product_id = $productId";
$result = mysqli_query($link, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "<script>window.alert('Product not found.'); window.location.href='product_list.php';</script>";
    exit;
}

// Handle product update
if (isset($_POST['update_product'])) {
    $productName = mysqli_real_escape_string($link, $_POST['product_name']);
    $productPrice = mysqli_real_escape_string($link, $_POST['product_price']);
    $productDiscount = mysqli_real_escape_string($link, $_POST['product_discount']);

    // Update product details
    $updateQuery = "UPDATE products SET Product_name='$productName', Price='$productPrice', Discount='$productDiscount' WHERE Product_id='$productId'";

    if (mysqli_query($link, $updateQuery)) {
        // Handle portfolio image upload
        if (isset($_FILES['portfolio_image']) && $_FILES['portfolio_image']['error'] === UPLOAD_ERR_OK) {
            $portfolioImageName = "$productId.png"; // Portfolio image name
            $portfolioTargetPath = "Prod_img/" . $portfolioImageName;

            if (!move_uploaded_file($_FILES['portfolio_image']['tmp_name'], $portfolioTargetPath)) {
                echo "<script>window.alert('Error uploading portfolio image.');</script>";
            }
        }

        // Handle multiple detail image uploads
        if (isset($_FILES['detail_images'])) {
            $imageCount = count(glob("Prod_img/$productId-*")); // Count existing detail images

            foreach ($_FILES['detail_images']['tmp_name'] as $key => $tmpName) {
                if ($_FILES['detail_images']['error'][$key] === UPLOAD_ERR_OK) {
                    $newImageName = "$productId-" . ($imageCount + 1) . ".png"; // New detail image name
                    $detailTargetPath = "Prod_img/" . $newImageName;

                    if (move_uploaded_file($tmpName, $detailTargetPath)) {
                        $imageCount++; // Increment the image count
                    } else {
                        echo "<script>window.alert('Error uploading detail image $key.');</script>";
                    }
                }
            }
        }
        echo "<script>window.alert('Product updated successfully!'); window.location.href='amc_products.php';</script>";
    } else {
        echo "<script>window.alert('Error updating product: " . mysqli_error($link) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="./header.css">
    <link rel="stylesheet" href="./home.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .update-form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .update-form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .update-form button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .update-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="update-form">
        <h2>Edit Product</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" required value="<?php echo htmlspecialchars($product['Product_name']); ?>">
            <label for="product_price">Price:</label>
            <input type="number" step="0.01" name="product_price" required value="<?php echo htmlspecialchars($product['Price']); ?>">
            <label for="product_discount">Discount (%):</label>
            <input type="number" name="product_discount" min="0" max="100" required value="<?php echo htmlspecialchars($product['Discount']); ?>">
            <label for="portfolio_image">Portfolio Image:</label>
            <input type="file" name="portfolio_image" accept="image/*" required>
            <label for="detail_images">Detail Images:</label>
            <input type="file" name="detail_images[]" accept="image/*" multiple>
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