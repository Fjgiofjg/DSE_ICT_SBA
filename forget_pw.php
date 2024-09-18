<?php
// Database connection details
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    die("Something went wrong");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = mysqli_real_escape_string($link, $_POST['uid']);
    
    // Check if the user exists in the database
    $query = "SELECT * FROM users WHERE uid='$uid'";
    $result = mysqli_query($link, $query);
    
    if (mysqli_num_rows($result) > 0) {
        // Check for duplicate password reset requests
        $checkDuplicateQuery = "SELECT * FROM password_requests WHERE uid = '$uid'";
        $duplicateResult = mysqli_query($link, $checkDuplicateQuery);

        if (mysqli_num_rows($duplicateResult) == 0) {
            // Log the request
            $logQuery = "INSERT INTO password_requests (uid, request_time) VALUES ('$uid', NOW())";
            mysqli_query($link, $logQuery);
            echo "<script>window.alert('Your request has been sent to the Student Union! Please visit the Student Union room to continue the password reset.')</script>";
        } else {
            echo "<script>window.alert('You have a unsettled password reset request. Please visit the Student Union room to continue the password reset.')</script>";
        }
    } else {
        echo "<script>window.alert('No account found with that MOSSS ID.')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="./login.css">
</head>
<body>
    <form method="POST" action="">
    <div class="screen-11">
        <img class="logo" src="imgs/Stella_Logo_Small.png" alt="Stella Logo">
        <div class="userid"><div class="sec-2">
            <input type="text" name="uid" placeholder='Please enter your MOSSS ID:' required><br>
        </div></div>
        <button class="login" type="submit">Send Reset Request</button>
    </div>
    </form>
</body>
</html>
