<?php
    $server = "localhost";
    $username = "Stellar_Database";
    $DBpassword = "pwdxvbKL2YKyn6Ca";
    $database = "stellar_database";
//Connect DB
    $link = mysqli_connect($server, $username, $DBpassword, $database);
        if (!$link){die("Something went wrong");}
        else{echo "<script>console.log('DB link successful!')</script>";}
//Check cookie, no = login page
	if(!isset($_COOKIE["uid"])) {echo "<script>window.alert('Please login!');window.location.href='login.html';</script>";}
//Check admin role
    $uid = $_COOKIE["uid"];
    $query_u = "SELECT * FROM users WHERE uid = " . $uid;
    $result_u = mysqli_query($link, $query_u);
	if ($result_u) {
        $user = mysqli_fetch_assoc($result_u);
    } else {
        echo "Error: " . mysqli_error($link);
    }
	if ($user['Is_Admin'] == 0) {echo "<script>window.alert('You do not have access to this page! Retuning to Home Page');window.location.href='home.php';</script>";}
?>

<html>
	<head>
		<title>Stellar - Admin Panel</title>
		<link rel="stylesheet" href="./header.css">
		<link rel="stylesheet" href="./AdminHome.css">
	</head>
	<body>
		<section class="header">
			<a onclick="loading.in('./home.php')"><img id="logo" src="imgs\Stella_AMC_Logo_Small.png" alt="Stella AMC Logo"></a>
			<div><ul id="navbar">
				<li><button onclick="loading.in('./acc.php')"><img class="buttons" src="imgs\Account.png" alt="Account"></img></button></li>
                <li><button onclick="loading.in('./cart.php')"><img class="buttons" src="imgs\Cart.png" alt="Cart"></img></button></li>
                <li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs\Search.png" alt="Search"></img></button></li>
			</ul></div>
		</section>
		<div>
			<div class="product-container">
				<div class='product-card'><a onclick=>
					<img src="imgs\Stella_AMC_Logo_Small.png" height='300px' width='300px' alt="Stella AMC Logo">
					<h3>Product Management</h3></a>
				</div>
				<div class='product-card'><a onclick=>
					<img src="imgs\Stella_AMC_Logo_Small.png" height='300px' width='300px' alt="Stella AMC Logo">
					<h3>Account Management</h3></a>
				</div>
				<div class='product-card'><a onclick="loading.in('./amc_order.php')">
					<img src="imgs\Stella_AMC_Logo_Small.png" height='300px' width='300px' alt="Stella AMC Logo">
					<h3>Order Management</h3>
				</a></div>
				<div></div><!--Dummy div for alinement, DONT DELETE-->
				<div class='product-card'><a onclick="loading.in('./home.php')">
					<img src="imgs\Stella_Logo_Small.png" height='300px' width='300px' alt="Stella Logo">
					<h3>Back to Stellar Shop</h3></a>
				</div>
			</div>
		</div>
		<div class="loading">
			<img id="logo" src="imgs\Stella_AMC_Logo_Small.png" alt="Stella_AMC Logo">
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