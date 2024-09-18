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

// Fetch all password reset requests
$query = "SELECT * FROM password_requests";
$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Requests</title>
    <link rel="stylesheet" href="./header.css">
    <link rel="stylesheet" href="./home.css">
    <link rel="stylesheet" href="./amc_account.css">
    <link rel="stylesheet" href="./amc_rpq.css">
</head>
<body>
    <section class="header">
        <a onclick="loading.in('./AdminHome.php')"><img id="logo" src="imgs/Stella_AMC_Logo_Small.png" alt="Stella AMC Logo"></a>
        <div>
            <ul id="navbar">
                <li><button onclick="loading.in('./acc.php')"><img class="buttons" src="imgs/Account.png" alt="Account"></button></li>
                <li><button onclick="loading.in('./cart.php')"><img class="buttons" src="imgs/Cart.png" alt="Cart"></button></li>
                <li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs/Search.png" alt="Search"></button></li>
            </ul>
        </div>
    </section>
    <div class="main">
    <h2>Password Reset Requests</h2>
        <div class="request-container">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="account-card">
                        <h3>User ID: <?php echo htmlspecialchars($row['uid']); ?></h3>
                        <p>Request Date: <?php echo htmlspecialchars($row['request_time']); ?></p>
                        <button class="cartbtn" onclick="handleRequest(<?php echo $row['uid']; ?>, 'approve')">Approve</button>
                        <button class="delbtn" onclick="handleRequest(<?php echo $row['uid']; ?>, 'deny')">Deny</button>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>There's No Requests!</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="loading">
        <img id="logo" src="imgs/Stella_AMC_Logo_Small.png" alt="Stella AMC Logo">
    </div>

    <script>
        function handleRequest(requestId, action) {
            if (action === 'approve' && confirm('Are you sure you want to approve this request?')) {
                window.location.href = 'process_request.php?id=' + requestId + '&action=approve';
            } else if (action === 'deny' && confirm('Are you sure you want to deny this request?')) {
                window.location.href = 'process_request.php?id=' + requestId + '&action=deny';
            }
        }

        // Loading animation functionality
        const loading = {
            container: document.querySelector(".loading"), // Get the loading element
            in(target) {
                this.container.classList.remove("loading_out"); // Show loading
                setTimeout(() => {
                    window.location.href = target; // Redirect after 500ms
                }, 500);
            },
            out() {
                this.container.classList.add("loading_out"); // Hide loading
            }
        };
        
        // Hide loading animation on page load
        window.addEventListener("load", () => {
            loading.out();
        });
    </script>
</body>
</html>