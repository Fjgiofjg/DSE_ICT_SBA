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

// Check if user ID is provided
if (!isset($_GET['id'])) {
    die("User ID not specified.");
}

// Retrieve user ID from query parameter
$uid = intval($_GET['id']);

// Fetch user data
$query = "SELECT * FROM users WHERE uid = $uid";
$result = mysqli_query($link, $query);
$user = mysqli_fetch_assoc($result);

// Check if user exists
if (!$user) {
    die("User not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    // Update user data
    $update_query = "UPDATE users SET Username = '$username', Is_Admin = $is_admin WHERE uid = $uid";
    mysqli_query($link, $update_query);

    // Redirect back to account management
    header("Location: acc.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="./header.css">
    <link rel="stylesheet" href="./home.css">
    <link rel="stylesheet" href="./edit_user.css">
</head>
<body>
    <h2>Edit User</h2>
    <form class="update-form" method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['Username']); ?>" required>

        <label style="display: flex; align-items: center;">
            <span style="margin-Right: -20%">Admin?</span>
            <input type="checkbox" name="is_admin" <?php echo $user['Is_Admin'] ? 'checked' : ''; ?>>
        </label>

        <button class="update_product" type="submit">Update User</button>
        <button class="back" type="button" onclick="window.location.href='ams_account.php'">Cancel</button>
    </form>
</body>
</html>