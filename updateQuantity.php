<?php
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

// Connect to the database
$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check cookie for user ID
if (!isset($_COOKIE["uid"])) {
    echo "<script>window.alert('Please login!');window.location.href='login.html';</script>";
    exit;
}

// Get parameters from the URL
$product_id = isset($_GET['product']) ? intval($_GET['product']) : 0;
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Ensure valid action
if ($action !== 'increase' && $action !== 'decrease') {
    echo "<script>window.alert('Invalid action!');window.history.back();</script>";
    exit;
}

// Fetch current quantity
$query = "SELECT Quantity FROM cart WHERE uid='" . $_COOKIE["uid"] . "' AND Product_id=$product_id";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $current_quantity = $row['Quantity'];

    if ($action === 'increase') {
        $new_quantity = $current_quantity + 1;
    } elseif ($action === 'decrease') {
        $new_quantity = max(0, $current_quantity - 1); // Prevent negative quantity
    }

    // Update quantity in the database
    $update_query = "UPDATE cart SET Quantity=$new_quantity WHERE uid='" . $_COOKIE["uid"] . "' AND Product_id=$product_id";
    mysqli_query($link, $update_query);
}

// Redirect back to the cart page
header("Location: cart.php");
exit;
?>