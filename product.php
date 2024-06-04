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

if(!isset($_COOKIE["uid"])) {
    echo "<script>";
    echo "window.alert('Please login!');";
    echo "window.location.href='login.html';";
    echo "</script>";
}


// Fetch data from the database
$query = "SELECT * FROM products WHERE Product_id = " . $_GET['product'];
$result = mysqli_query($link, $query);
$product = mysqli_fetch_assoc($result);

// Display the product information
?>

<html>
    <head>
        <title><?php echo $product["Product_name"]; ?> | Stellar</title>
        <link rel="stylesheet" href="./header.css">
        <link rel="stylesheet" href="./product.css">
    </head>
    <body>
        <section class="header">
        <a onclick="loading.in('./home.php')"><img id="logo" src="imgs\Stella_Logo_Small.png" alt="Stella Logo"></a>
            <div><ul id="navbar">
                    <li><button onclick="loading.in('./acc.php')"><img class="buttons" src="imgs\Account.png" alt="Account"></img></button></li>
					<li><button onclick="loading.in('./cart.php')"><img class="buttons" src="imgs\Cart.png" alt="Cart"></img></button> </li>
					<li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs\Search.png" alt="Search"></img></button></li>
					<li><button onclick="loading.in('./wish.php')"><img class="buttons" src="imgs\Wish.png" alt="Wish"></img></button></li>
                    <li><button onclick="loading.in('./confirm.php')" style="color: blue; font-size: 20px;"><!--<img class="buttons" src="imgs\Wish.png" alt="Wish"></img>--><p>OH</p></button></li>
				</ul></div>
		</section>
        <section class="main">
            <div class="product-container">
                <div class="product-info">
                    <h1><?php echo $product['Product_name']; ?></h1>
                    <p><?php echo $product['Product_desc']; ?></p>
                    <?php if ($product["Discount"] > 0): ?>
                        <p>Discount: <?php echo $product["Discount"]; ?>%</p>
                    <?php endif; ?>
                    <p>Final Price: $<?php echo round($product["Price"] * (1 - $product["Discount"] / 100),1); ?></p>
                    <p>Remaining in stock: <?php echo $product["Remain_no"]; ?></p>
                    <button onclick="loading.in('./AddToCart.php?product_id=<?php echo $product['Product_id']; ?>')" class="cartbtn">Add to Cart</button>
                    <button onclick="loading.in('./AddToWish.php?product_id=<?php echo $product['Product_id']; ?>')" class="wishbtn">Add to Wish List</button>
                </div>
                <div class="product-image">
                    <div><?php echo "<img src='Prod_img/".$product['Product_id'].".png' width='600px'>" ?></div>
                </div>
        </section>
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