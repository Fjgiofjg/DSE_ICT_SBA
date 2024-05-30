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
		<link rel="stylesheet" href="./home.css">
	</head>
	<body>
		<section class="header">
			<a onclick="loading.in('./home.php')"><img id="logo" src="imgs\Stella_Logo_Small.png" alt="Stella Logo"></a>
			<div><ul id="navbar">
					<li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs\Account.png" alt="Account"></img></button></li>
					<li><button onclick="loading.in('./cart.php')"><img class="buttons" src="imgs\Cart.png" alt="Cart"></img></button> </li>
					<li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs\Search.png" alt="Search"></img></button></li>
					<li><button onclick="loading.in('./wish.php')"><img class="buttons" src="imgs\Wish.png" alt="Wish"></img></button></li>
				</ul></div>
		</section>
		<div class="product-container">
			<?php
				//Fetch data
				$query = "SELECT * FROM products";
				$result = mysqli_query($link, $query);
				$count=0;
				while ($row = mysqli_fetch_assoc($result)){
					echo "<div class='product-card'>";
						echo '<a onclick="loading.in(\'./product.php?product=' . $row['Product_id'] . '\')">';
							echo "<img src='Prod_img/".$row['Product_id'].".png' height='300px' width='300px' alt=".$row['Product_name'].">";
							echo '<h3>'.$row['Product_name'].'</h3>';
							echo '<p class="price">$'.round($row['Price'] * (1 - $row['Discount'] / 100),1).'</p>';
						echo "</a>";
					echo '</div>';
				}
			?>
		<a href='logout.php'>Logout</a>
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