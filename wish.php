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
?>
<html>
    <head>
		<title>Stellar - Home</title>
		<link rel="stylesheet" href="./header.css">
		<link rel="stylesheet" href="./wish.css">
	</head>
    <body>
        <section class="header">
			<a onclick="loading.in('./home.php')"><img id="logo" src="imgs\Stella_Logo_Small.png" alt="Stella Logo"></a>
			<div><ul id="navbar">
				<li><button onclick="loading.in('./acc.php')"><img class="buttons" src="imgs\Account.png" alt="Account"></img></button></li>
				<li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs\Account.png" alt="Account"></img></button></li>
				<li><button onclick="loading.in('./cart.php')"><img class="buttons" src="imgs\Cart.png" alt="Cart"></img></button> </li>
				<li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs\Search.png" alt="Search"></img></button></li>
				<li><button onclick="loading.in('./wish.php')"><img class="buttons" src="imgs\Wish.png" alt="Wish"></img></button></li>
				                <li><button onclick="loading.in('./confirm.php')"><img class="buttons" src="imgs/Order.png" alt="Order History"></button></li>

			</ul></div>
        </section>
        <section class="main">
            <h1>Your Wishlist</h1>
        <table>
            <tr>
                <th>Product Name</th>
            </tr>
            <?php
				$query_w = "SELECT * FROM wish WHERE uid='".$_COOKIE["uid"]."'";
				$result_w = mysqli_query($link, $query_w);
				$total=0;
				while ($wish_t = mysqli_fetch_assoc($result_w)){
					$query_p = "SELECT * FROM products WHERE Product_id = " . $wish_t['Product_id'];
					$result_p = mysqli_query($link, $query_p);
					$product = mysqli_fetch_assoc($result_p);
					$final_price = round($product["Price"] * (1 - $product["Discount"] / 100),1);
                    echo "<tr>";
                    echo "<td>";
                    echo "<a href='product.php?product=".$wish_t['Product_id']."'>";
                    echo $product['Product_name'];
                    echo "</a></td>";
                    echo "<td class='btn_td'>";
                    echo "<button onclick=\"loading.in('./AddToCart.php?product_id=".$product['Product_id']."')\" class=\"cartbtn\">Add to Cart</button>";
                    echo "</td>";
                    echo "<td class='btn_td'>";
                    echo "<button onclick=\"loading.in('./deleteWish.php?product_id=".$product['Product_id']."')\" class=\"wishbtn\">Remove From Wish List</button>";
                    echo "</td>";
                }
                echo "</table>";
            ?>
        </table>
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