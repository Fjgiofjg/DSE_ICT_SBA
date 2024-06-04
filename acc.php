<?php
    $server = "localhost";
    $username = "Stellar_Database";
    $DBpassword = "pwdxvbKL2YKyn6Ca";
    $database = "stellar_database";

    // Connect to DB
    $link = mysqli_connect($server, $username, $DBpassword, $database);
    if (!$link) {
        die("Something went wrong");
    } else {
        echo "<script>console.log('DB link successful!')</script>";
    }

    // Check cookie, no = login page
    if (!isset($_COOKIE["uid"])) {
        echo "<script>window.alert('Please login!');window.location.href='login.html';</script>";
        exit;
    }

    $uid = $_COOKIE["uid"];
    $query_u = "SELECT * FROM users WHERE uid = " . $uid;
    $result_u = mysqli_query($link, $query_u);

    if ($result_u) {
        $user = mysqli_fetch_assoc($result_u);
    } else {
        echo "Error: " . mysqli_error($link);
    }
?>

<html>
    <head>
        <title>Stellar - Home</title>
        <link rel="stylesheet" href="./header.css">
        <link rel="stylesheet" href="./home.css">
        <link rel="stylesheet" href="./acc.css">
    </head>
    <body>
        <section class="header">
            <a onclick="loading.in('./home.php')"><img id="logo" src="imgs\Stella_Logo_Small.png" alt="Stella Logo"></a>
            <div>
                <ul id="navbar">
                    <li><button class="active" onclick="loading.in('./acc.php')"><img class="buttons" src="imgs\Account.png" alt="Account"></img></button></li>
                    <li><button onclick="loading.in('./cart.php')"><img class="buttons" src="imgs\Cart.png" alt="Cart"></img></button></li>
                    <li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs\Search.png" alt="Search"></img></button></li>
                    <li><button onclick="loading.in('./wish.php')"><img class="buttons" src="imgs\Wish.png" alt="Wish"></img></button></li>
                    <li><button onclick="loading.in('./confirm.php')" style="color: blue; font-size: 20px;"><!--<img class="buttons" src="imgs\Conf.png" alt="Order History"></img>--><p>OH</p></button></li>
                </ul>
            </div>
        </section>
        <section class="main">
            <div>
                <h1>Welcome To Stellar, <?php echo htmlspecialchars($user['Username']); ?> !</h1>
                <p>Your user id is: <?php echo htmlspecialchars($user['uid']); ?>
                <br>Your Class: <?php echo htmlspecialchars($user['Class']); ?>
                <br>Your Class Number: <?php echo htmlspecialchars($user['Class_No']); ?>
                <br>Your Role:<?php 
                        if ($user['Is_Admin'] == 1) {
                            echo ' Admin';
                        } else {
                            echo ' Student';
                        }
                    ?></p>
            </div>
            <div>
                <h2>Change Password</h2>
                <form name="regis" action="ChPW.php" method="post">
                    <div class="screen-1">
                        <div class="userid"><div class="sec-2">
                            <label for="CPW">Currnet Password:</label> 
                            <input id="CPW" name="CPW" required="" type="password" />
                        </div></div>
                        <div class="password"><div class="sec-2">
                            <label for="NPW">New Password:</label>
                            <input id="NPW" name="NPW" required="" type="password" />
                        </div></div>
                        <button class="login" id="cartbtn" type="submit" value="Register">Change Password</button>
                    </form>
                    <br><button id="LogOutBtn" onclick="loading.in('./logout.php')">Log Out</button>
                    </div>
                    </div>
			<div class="loading">
			<img id="logo" src="imgs\Stella_Logo_Small.png" alt="Stella Logo">
		</div>
	</body>
	<script>
		const loading = {
			container: document.querySelector(".loading"),
			in(target){
				this.container.classList.remove("loading_out");
				console.log(this.container.classList);
				setTimeout(() => {
					window.location.href = target;
				}, 500);
			},
			out(){
				this.container.classList.add("loading_out")
			}
		};
		window,addEventListener("load", () => {
			loading.out()
		})
	</script>
</html>
