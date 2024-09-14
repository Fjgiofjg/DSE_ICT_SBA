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

// Fetch all user accounts
$query = "SELECT * FROM users";
$result = mysqli_query($link, $query);
?>

<html>
<head>
    <title>Admin - Manage Accounts</title>
    <link rel="stylesheet" href="./header.css">
    <link rel="stylesheet" href="./home.css">
    <style>
        .account-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .account-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            width: 200px; /* Adjust as necessary */
            text-align: center;
        }
        .account-card button {
            margin-top: 10px;
        }
    </style>
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

    <div class="account-management">
        <h2>Manage User Accounts</h2>
        <div class="account-container">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="account-card">
                <h3><?php echo htmlspecialchars($row['username']); ?></h3>
                <p>User ID: <?php echo htmlspecialchars($row['uid']); ?></p>
                <p>Email: <?php echo htmlspecialchars($row['email']); ?></p>
                <p>Admin: <?php echo $row['Is_Admin'] ? 'Yes' : 'No'; ?></p>
                <button onclick="editUser(<?php echo $row['uid']; ?>)">Edit</button>
                <button onclick="deleteUser(<?php echo $row['uid']; ?>)">Delete</button>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        function editUser(userId) {
            window.location.href = 'edit_user.php?id=' + userId; // Redirect to edit page
        }

        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = 'delete_user.php?id=' + userId; // Redirect to delete page
            }
        }

        // Loading animation functionality
        const loading = {
            container: document.querySelector(".loading"),
            in(target) {
                this.container.classList.remove("loading_out");
                setTimeout(() => {
                    window.location.href = target;
                }, 500);
            },
            out() {
                this.container.classList.add("loading_out");
            }
        };

        window.addEventListener("load", () => {
            loading.out();
        });
    </script>
</body>
</html>
