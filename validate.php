<?php
$input = $_POST['input'];
$password = $_POST['pw'];
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    die("Something went wrong");
}

// Fetch data from users table using either uid or username
$query = "SELECT * FROM users WHERE uid = '$input' OR username = '$input'";
$result = mysqli_query($link, $query);

if ($row = mysqli_fetch_assoc($result)) {
    // Check if the user has a password reset request
    $requestQuery = "SELECT * FROM password_requests WHERE uid='{$row['uid']}'";
    $requestResult = mysqli_query($link, $requestQuery);

    // Check if the query was successful
    if ($requestResult) {
        // Check if there are any requests
        if (mysqli_num_rows($requestResult) > 0) {
            $requestData = mysqli_fetch_assoc($requestResult);
            $requestTime = $requestData['request_time'];

            echo "<script>";
            echo "alert('A password reset has been requested for this account.\\nPlease complete the process before logging in.\\nTime of password reset request: " . htmlspecialchars($requestTime) . "');";
            echo "window.location.href='login.html';";
            echo "</script>";
            exit();
        }
    } else {
        // Handle query error
        error_log("Database query failed: " . mysqli_error($link));
        echo "<script>alert('An error occurred while checking the password reset request.');</script>";
    }

    // Verify password
    if (password_verify($password, $row['Password'])) { // Use password_verify for hashed passwords
        // Success
        setcookie("uid", $row['uid'], time() + 3600); // Use the uid from the row
        echo "<script>window.location.href='home.php';</script>";
    } else {
        echo "<script>alert('Invalid User ID / Password!'); window.location.href='login.html';</script>";
    }
} else {
    echo "<script>alert('Invalid User ID / Password!'); window.location.href='login.html';</script>";
}
?>