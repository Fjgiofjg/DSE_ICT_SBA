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

// Check if the request ID and action are set
if (isset($_GET['id']) && isset($_GET['action'])) {
    $requestId = intval($_GET['id']);
    $action = $_GET['action'];

    // Check user role (admin)
    $query_u = "SELECT * FROM users WHERE uid = " . intval($uid);
    $result_u = mysqli_query($link, $query_u);
    $user = mysqli_fetch_assoc($result_u);
    if ($user['Is_Admin'] == 0) {
        echo "<script>window.alert('You do not have access to this action!'); window.location.href='home.php';</script>";
        exit; // Stop further execution
    }

    // Process the request based on the action
    if ($action === 'approve') {
        // Fetch the request details
        $request_query = "SELECT uid FROM password_requests WHERE uid = $requestId";
        $request_result = mysqli_query($link, $request_query);
        $request = mysqli_fetch_assoc($request_result);

        if ($request) {
            // Generate a random password
            $newPassword = bin2hex(random_bytes(8)); // Generate a random 16-character string

            // Update the user's password (assuming password hashing is used)
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $update_user_query = "UPDATE users SET password = '$hashedPassword' WHERE uid = " . intval($request['uid']);
            mysqli_query($link, $update_user_query);

            // Delete the password request
            $delete_request_query = "DELETE FROM password_requests WHERE uid = $requestId";
            mysqli_query($link, $delete_request_query);

            // Inform the user of the new password (consider sending it via email instead)
            echo "<script>window.alert('Request approved. New password: $newPassword'); window.location.href='amc_rpq.php';</script>";
        } else {
            echo "<script>window.alert('Request not found!'); window.location.href='amc_rpq.php';</script>";
        }
    } elseif ($action === 'deny') {
        // Delete the password request
        $delete_request_query = "DELETE FROM password_requests WHERE uid = $requestId";
        mysqli_query($link, $delete_request_query);
        echo "<script>window.alert('Request denied.'); window.location.href='amc_rpq.php';</script>";
    } else {
        echo "<script>window.alert('Invalid action!'); window.location.href='amc_rpq.php';</script>";
    }
} else {
    echo "<script>window.alert('Invalid request!'); window.location.href='amc_rpq.php';</script>";
}

// Close database connection
mysqli_close($link);
?>