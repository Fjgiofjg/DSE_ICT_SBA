<?php
$uid = $_POST['uid'];
$password = $_POST['pw'];
$checked = 0;
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    die("Something went wrong");
}

// Fetch data from users table
$query = "SELECT * FROM users WHERE uid='$uid'";
$result = mysqli_query($link, $query);

if ($row = mysqli_fetch_assoc($result)) {
    // Check if the user has a password reset request
    $requestQuery = "SELECT * FROM password_resets WHERE email='{$row['uid']}'";
    $requestResult = mysqli_query($link, $requestQuery);

    if (mysqli_num_rows($requestResult) > 0) {
        echo "<script>";
        echo "alert('A password reset has been requested for this account. Please complete the process before logging in.');";
        echo "window.location.href='login.html';";
        echo "</script>";
        exit();
    }

    // Verify password
    if (password_verify($password, $row['Password'])) { // Use password_verify for hashed passwords
        // Success
        setcookie("uid", $uid, time() + 3600);
        echo "<script>window.location.href='home.php';</script>";
    } else {
        echo "<script>alert('Invalid User ID / Password!'); window.location.href='login.html';</script>";
    }
} else {
    echo "<script>alert('Invalid User ID / Password!'); window.location.href='login.html';</script>";
}
?>
