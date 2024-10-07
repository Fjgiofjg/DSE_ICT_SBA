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
    exit; // Stop further execution
}

// Retrieve user ID from cookie
$uid = $_COOKIE["uid"];

// Check user role to determine if the user is an admin
$query_u = "SELECT * FROM users WHERE uid = " . intval($uid);
$result_u = mysqli_query($link, $query_u);
$user = mysqli_fetch_assoc($result_u);
if ($user['Is_Admin'] == 0) {
    echo "<script>window.alert('You do not have access to this page!'); window.location.href='home.php';</script>";
    exit; // Stop further execution
}

// Get the user ID to delete
if (isset($_GET['id'])) {
    $userId = intval($_GET['id']); // Sanitize user ID

    // Delete the user from the database
    $deleteQuery = "DELETE FROM users WHERE uid = $userId";
    if (mysqli_query($link, $deleteQuery)) {
        echo "<script>window.alert('User deleted successfully!'); window.location.href='amc_account.php';</script>";
    } else {
        echo "<script>window.alert('Error deleting user: " . mysqli_error($link) . "'); window.location.href='amc_account.php';</script>";
    }
} else {
    echo "<script>window.alert('No user ID provided.'); window.location.href='amc_account.php';</script>";
}
?>