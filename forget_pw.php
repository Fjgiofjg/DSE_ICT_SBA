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
        // Prepare to send request to Student Union (simulate this)
               
        // Simulating sending the request
        $message = "Password reset request for UID: $uid has been sent to the Student Union.";
        // log the request
        $logQuery = "INSERT INTO password_requests (uid, request_time) VALUES ('$uid', NOW())";
        mysqli_query($link, $logQuery);
        
        echo "Your request has been sent to the Student Union! Please visit the Student Union room to continue the password reset.";
    } else {
        echo "No account found with that MOSSS ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <form method="POST" action="">
        <label for="uid">Please enter your MOSSS ID:</label>
        <input type="text" name="uid" required>
        <button type="submit">Send Reset Request</button>
    </form>
</body>
</html>
