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

$productId = intval($_GET['product']);

// Fetch product details
$query = "SELECT * FROM products WHERE Product_id = $productId";
$result = mysqli_query($link, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "<script>window.alert('Product not found.'); window.location.href='product_list.php';</script>";
    exit;
}

// Fetch current tags
$tagsQuery = "SELECT Tag FROM tags WHERE Product_id = $productId";
$tagsResult = mysqli_query($link, $tagsQuery);
$currentTags = [];
while ($row = mysqli_fetch_assoc($tagsResult)) {
    $currentTags[] = $row['Tag'];
}

// Fetch current variations
$variationsQuery = "SELECT variation FROM variations WHERE Product_ID = $productId";
$variationsResult = mysqli_query($link, $variationsQuery);
$currentVariations = [];
while ($row = mysqli_fetch_assoc($variationsResult)) {
    $currentVariations[] = $row['variation'];
}

// Fetch existing images
$portfolioImage = "Prod_img/$productId.png"; // Portfolio image
$detailImages = glob("Prod_img/$productId-*"); // Detail image

// Handle product update
if (isset($_POST['update_product'])) {
    $productName = mysqli_real_escape_string($link, $_POST['product_name']);
    $productPrice = mysqli_real_escape_string($link, $_POST['product_price']);
    $productDiscount = mysqli_real_escape_string($link, $_POST['product_discount']);
    $productDescription = strip_tags($_POST['product_description'], '<b><i><a><ul><ol><h1><h2><li>');
    $remainNo = intval(mysqli_real_escape_string($link, $_POST['remain_no']));

    // Update product details
    $updateQuery = "UPDATE products SET Product_name='$productName', Price='$productPrice', Discount='$productDiscount', Remain_no='$remainNo' , Product_desc='$productDescription' WHERE Product_id='$productId'";

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
        if (!isset($_FILES['detail_images'])) { // Corrected NOT to !
            exit(); // Added semicolon
        } else {
            $existingImages = glob("Prod_img/$productId-*"); // Get existing detail images

            // Delete existing detail images
            foreach ($existingImages as $image) {
                if (file_exists($image)) {
                    unlink($image); // Delete the image
                }
            }

            $imageCount = 0; // Reset image count after deletion

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
        if (isset($_POST['tags'])) {
            $tags = explode(',', $_POST['tags'][0]); // Split by comma
            mysqli_query($link, "DELETE FROM tags WHERE Product_id='$productId'");

            foreach ($tags as $index => $tag) {
                $tag = mysqli_real_escape_string($link, trim($tag));
                // Use the index as the tag_id
                mysqli_query($link, "INSERT INTO tags (Product_id, Tag, tag_id) VALUES ('$productId', '$tag', $index)");
            }
        }

        // Update variations
        if (isset($_POST['variations'])) {
            $variations = explode(',', $_POST['variations'][0]); // Split by comma
            mysqli_query($link, "DELETE FROM variations WHERE Product_ID='$productId'");

            foreach ($variations as $index => $variation) {
                $variation = mysqli_real_escape_string($link, trim($variation));
                // Use the index as the var_id
                mysqli_query($link, "INSERT INTO variations (Product_ID, variation, var_id) VALUES ('$productId', '$variation', $index)");
            }
        }

        echo "<script>window.alert('Product updated successfully!'); window.location.href='amc_products.php';</script>";
    } else {
        echo "<script>window.alert('Error updating product: " . mysqli_error($link) . "');</script>";
    }
}

// Handle product deletion
if (isset($_POST['delete_product'])) {
    $deleteQuery = "DELETE FROM products WHERE Product_id='$productId'";
    if (mysqli_query($link, $deleteQuery)) {
        // Optionally, delete associated tags and variations
        mysqli_query($link, "DELETE FROM tags WHERE Product_id='$productId'");
        mysqli_query($link, "DELETE FROM variations WHERE Product_ID='$productId'");
        echo "<script>window.alert('Product deleted successfully!'); window.location.href='amc_products.php';</script>";
    } else {
        echo "<script>window.alert('Error deleting product: " . mysqli_error($link) . "');</script>";
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
    <link rel="stylesheet" href="./edit_prod.css">
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
            <label for="remain_no">Remaining Number (0 - 999):</label>
            <input type="number" name="remain_no" min="0" required value="<?php echo htmlspecialchars($product['Remain_no']); ?>">
            <label for="product_description">Description:</label>
            <textarea name="product_description" rows="4" required><?php echo htmlspecialchars($product['Product_desc']); ?></textarea>
            <label for="tags">Tags (comma separated) (At least 1 Tag, Max 10):</label>
            <input type="text" name="tags[]" placeholder="Tag1, Tag2, Tag3" value="<?php echo implode(', ', $currentTags); ?>">
            <label for="variations">Variations (comma separated) (At least 1 Variation, Max 10):</label>
            <input type="text" name="variations[]" placeholder="Variation1, Variation2, Variation3" value="<?php echo implode(', ', $currentVariations); ?>">
            <label for="portfolio_image">Portfolio Image:</label>
            <input type="file" name="portfolio_image" accept="image/*">
            <label for="detail_images">Detail Images:</label>
            <input type="file" name="detail_images[]" accept="image/*" multiple>
            <button type="submit" name="update_product" class="update_product">Update Product</button>
            <button type="submit" name="delete_product" class="delete-button">Delete Product</button>
        </form>
        <button name="back" class="back" onclick="loading.in('./amc_products.php')">Back to Product Manager</button>
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