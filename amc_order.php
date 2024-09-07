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

        $uid=$_COOKIE["uid"];
        $query_r = "SELECT * FROM orders";
        $result_r = mysqli_query($link, $query_r);
        $order_d = mysqli_fetch_assoc($result_r);

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
            <title>Stellar - Order History</title>
            <link rel="stylesheet" href="./header.css">
            <link rel="stylesheet" href="./home.css">
        </head>
            <script src="./owlcarousel/owl.carousel.min.css"></script>
        <body>
            <section class="header">
                <a onclick="loading.in('./home.php')"><img id="logo" src="imgs\Stella_Logo_Small.png" alt="Stella Logo"></a>
                <div><ul id="navbar">
                    <li><button onclick="loading.in('./acc.php')"><img class="buttons" src="imgs\Account.png" alt="Account"></img></button></li>
                    <li><button onclick="loading.in('./cart.php')"><img class="buttons" src="imgs\Cart.png" alt="Cart"></img></button></li>
                    <li><button onclick="loading.in('./404.html')"><img class="buttons" src="imgs\Search.png" alt="Search"></img></button></li>
                </ul></div>
            </section>
            <section class="main">
                <h1>Accepted Orders</h1>
                
                <?php $query = "SELECT * FROM orders";
                    $result = mysqli_query($link, $query_r);
                    $previousRefNo = null;
                    $ord_price=0;
                    echo '<div class="product-container">';
                    while ($row = mysqli_fetch_assoc($result)) {
                        $query_p = "SELECT * FROM products WHERE Product_id = " . $row['Product_id'];
                        $result_p = mysqli_query($link, $query_p);
                        $product = mysqli_fetch_assoc($result_p);
                        $final_price = round($product["Price"] * (1 - $product["Discount"] / 100), 1);
                        $currentRefNo = $row['RefNo'];
                        if ($currentRefNo !== $previousRefNo) {
                            // Start a new section for the new RefNo
                            if ($previousRefNo !== null) {
                                // Display the total price of the previous group
                                echo '<h3>The Final Price of this order: $' . $ord_price . '</h3>';
                                echo '</div>';
                            }
                            echo "<div class='product-card'>";
                            echo '<h2>Order ' . $currentRefNo . '</h2>';
                            $previousRefNo = $currentRefNo;
                            $ord_price = 0;
                        }
                        // Display the order details
                        echo '<p>' . $product['Product_name'] . ' x ' . $row['Quantity'] . '</p>';
                        $ord_price += $final_price;
                    }
                    if ($previousRefNo !== null) {
                        // Display the total price of the last group
                        echo '<h3>The Final Price of this order: $' . $ord_price . '</h3>';
                        echo '</div>';
                    }
                    ?>
                    </div>
            </section>
            
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