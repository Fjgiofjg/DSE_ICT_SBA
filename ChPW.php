<?php
// Database connection details
$server = "localhost";
$username = "Stellar_Database";
$DBpassword = "pwdxvbKL2YKyn6Ca";
$database = "stellar_database";

$link = mysqli_connect($server, $username, $DBpassword, $database);
if (!$link) {
    die("Something went wrong");
} else {
    echo "<script>console.log('DB link successful!')</script>";
}

// Get the form data 
$uid = $_COOKIE["uid"];
$cpw = $_POST['CPW']; 
$npw = $_POST['NPW'];

$checked = 0;

// Retrieve data
$query_r = "SELECT Password FROM users WHERE uid='$uid'";
$result_r = mysqli_query($link, $query_r);

while ($row = mysqli_fetch_assoc($result_r)) {
    // Check if the current password matches the one in the database
    if (($cpw==$row["Password"])) {
        // Update the password in the database
        $query_u = "UPDATE users SET Password='$npw' WHERE uid='$uid'";
        $result_u = mysqli_query($link, $query_u);
        if ($result_u) {
            echo "<script>alert('Password updated successfully!');";
            echo "window.location.href='acc.php';</script>";
        } else {
            echo "<script>alert('Error updating password!');";
            echo "window.location.href='acc.php';</script>";

        }
        break;
    } else {
        echo "<script>alert('Incorrect current password!')";
        echo "window.location.href='acc.php'";
        echo "</script>";

    }
}

mysqli_close($link);
?>