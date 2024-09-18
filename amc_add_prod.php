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

// Handle product addition
if (isset($_POST['add_product'])) {
    $productId = floatval(mysqli_real_escape_string($link, $_POST['product_id'])); // Get custom product ID
    $productName = mysqli_real_escape_string($link, $_POST['product_name']);
    $productPrice = mysqli_real_escape_string($link, $_POST['product_price']);
    $productDiscount = mysqli_real_escape_string($link, $_POST['product_discount']);
    $productDescription = strip_tags($_POST['product_description'], '<b><i><a><ul><ol><h1><h2><li>');
    $remainNo = intval(mysqli_real_escape_string($link, $_POST['remain_no']));

    // Insert new product
    $insertQuery = "INSERT INTO products (Product_id, Product_name, Price, Discount, Product_desc, Remain_no) VALUES ('$productId', '$productName', '$productPrice', '$productDiscount', '$productDescription', '$remainNo')";
    
    if (mysqli_query($link, $insertQuery)) {
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
            $imageCount = 0; // Reset image count

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

        // Update tags
        if (isset($_POST['tags']) && !empty($_POST['tags'][0])) {
            $tags = array_filter(array_map('trim', explode(',', $_POST['tags'][0]))); // Split by comma and trim
            mysqli_query($link, "DELETE FROM tags WHERE Product_id='$productId'");

            foreach ($tags as $index => $tag) {
                if (!empty($tag)) {
                    $tag = mysqli_real_escape_string($link, $tag);
                    mysqli_query($link, "INSERT INTO tags (Product_id, Tag, tag_id) VALUES ('$productId', '$tag', $index)");
                }
            }
        }

        // Update variations
        if (isset($_POST['variations']) && !empty($_POST['variations'][0])) {
            $variations = array_filter(array_map('trim', explode(',', $_POST['variations'][0]))); // Split by comma and trim
            mysqli_query($link, "DELETE FROM variations WHERE Product_ID='$productId'");

            foreach ($variations as $index => $variation) {
                if (!empty($variation)) {
                    $variation = mysqli_real_escape_string($link, $variation);
                    mysqli_query($link, "INSERT INTO variations (Product_ID, variation, var_id) VALUES ('$productId', '$variation', $index)");
                }
            }
        }

        echo "<script>window.alert('Product added successfully!'); window.location.href='amc_products.php';</script>";
    } else {
        echo "<script>window.alert('Error adding product: " . mysqli_error($link) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link rel="stylesheet" href="./header.css">
    <link rel="stylesheet" href="./home.css">
    <link rel="stylesheet" href="./edit_prod.css">
</head>
<body>
    <div class="update-form">
        <h2>Add New Product</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="product_id">Product ID (7 digit):</label>
            <input type="number" name="product_id" required>
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" required>
            <label for="product_price">Price:</label>
            <input type="number" step="0.01" name="product_price" required>
            <label for="product_discount">Discount (%):</label>
            <input type="number" name="product_discount" min="0" max="100" required>
            <label for="remain_no">Remaining Number (0 - 999):</label>
            <input type="number" name="remain_no" min="0" required>
            <label for="product_description">Description:</label>
            <textarea name="product_description" rows="4" required></textarea>
            <label for="tags">Tags (comma separated) (At least 1 Tag, Max 10):</label>
            <input type="text" name="tags[]" placeholder="Tag1, Tag2, Tag3">
            <label for="variations">Variations (comma separated) (At least 1 Variation, Max 10):</label>
            <input type="text" name="variations[]" placeholder="Variation1, Variation2, Variation3">
            <label for="portfolio_image">Portfolio Image:</label>
            <input type="file" name="portfolio_image" accept="image/*">
            <label for="detail_images">Detail Images:</label>
            <input type="file" name="detail_images[]" accept="image/*" multiple>
            <button type="submit" name="add_product" class="update_product">Add Product</button>
            <button name="back" class="back" onclick="loading.in('./amc_products.php')">Back to Product Manager</button>
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