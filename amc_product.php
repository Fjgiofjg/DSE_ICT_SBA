<?php
// Database connection parameters
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

// Connect to the database
$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    die("Database connection failed"); // Handle connection error
} else {
    echo "<script>console.log('DB link successful!')</script>"; // Log successful connection
}

// Check if the user is logged in via cookie
if (!isset($_COOKIE["uid"])) {
    echo "<script>window.alert('Please login!'); window.location.href='login.html';</script>";
    exit; // Stop further execution
}

// Retrieve user ID from cookie
$uid = $_COOKIE["uid"];

// Check user role to determine if the user is an admin
$query_u = "SELECT * FROM users WHERE uid = " . intval($uid); // Sanitize uid
$result_u = mysqli_query($link, $query_u);
if ($result_u) {
    $user = mysqli_fetch_assoc($result_u); // Fetch user data
} else {
    echo "Error: " . mysqli_error($link); // Handle query error
}

// Check if the user is an admin
if ($user['Is_Admin'] == 0) {
    echo "<script>window.alert('You do not have access to this page!\nReturning to Home Page'); window.location.href='home.php';</script>";
    exit; // Stop further execution
}

// Handle order completion
if (isset($_POST['complete_order'])) {
    $orderRefNo = mysqli_real_escape_string($link, $_POST['order_ref_no']);
    
    // Move order to done_orders
    $moveOrderQuery = "INSERT INTO done_orders SELECT * FROM orders WHERE RefNo = '$orderRefNo'";
    $deleteOrderQuery = "DELETE FROM orders WHERE RefNo = '$orderRefNo'";
    
    if (mysqli_query($link, $moveOrderQuery) && mysqli_query($link, $deleteOrderQuery)) {
        echo "<script>window.alert('Order marked as done!');</script>";
    } else {
        echo "<script>window.alert('Error completing order: " . mysqli_error($link) . "');</script>";
    }
}
?>
<body>
</body>
