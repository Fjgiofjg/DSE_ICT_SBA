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
        <title>Stellar - Shopping Cart</title>
        <link rel="stylesheet" href="./header.css">
        <link rel="stylesheet" href="./cart.css">
    </head>
	<body>
		<section class="header">
			<a  onclick="loading.in('./home.php')"><img id="logo" src="imgs\Stella_Logo_Small.png" alt="Stella Logo"></a>
			<div>
				<ul id="navbar">
					<li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs\Account.png" alt="Account"></img></button></li>
					<li><button onclick="loading.in('./cart.php')"><img class="buttons" src="imgs\Cart.png" alt="Cart"></img></button> </li>
					<li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs\Search.png" alt="Search"></img></button></li>
					<li><button class="active"><img class="buttons" src="imgs\Wish.png" alt="Wish"></img></button></li>
				</ul>
			</div>
		</section>
		<section class="main">
			<h1>Shopping Cart</h1>
			<table class="cart_t" border=1>
				<tr>
					<th>
					Product Name
					</th>
					<th>
					Price
					</th>
					<th>
					Quantity
					</th>
					<th>
					Delete?
					</th>
				</tr>
				<?php
				//Fetch data & Show user's cart items
						$query_c = "SELECT * FROM cart WHERE uid='".$_COOKIE["uid"]."'";
						$result_c = mysqli_query($link, $query_c);
						$total=0;
						while ($cart_t = mysqli_fetch_assoc($result_c)){
							$query_p = "SELECT * FROM products WHERE Product_id = " . $cart_t['Product_id'];
							$result_p = mysqli_query($link, $query_p);
							$product = mysqli_fetch_assoc($result_p);
							$final_price = round($product["Price"] * (1 - $product["Discount"] / 100),1);
							echo "<tr>";
							echo "<td>";
							echo "<a href='product.php?product=".$cart_t['Product_id']."'>";
							echo $product['Product_name'];
							echo "</a>";
							echo "</td>";
							echo "<td>";
							echo $final_price;
							echo "</td>";
							echo "<td>";
							echo $cart_t['Quantity'];
							echo "</a>";
							echo "<td>";
							echo "<a onclick='loading.in(\"./deleteCart.php?product=".$cart_t['Product_id']."\")'>";
							echo "Delete";
							echo "</a>";
							echo "</td>";
							echo "</tr>";
							$total=$total+$final_price;
						}
						echo "</table>";
						echo "Total: $".$total;
				?>
				<br>
				<a href="confirm.php">Confirm</a>
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