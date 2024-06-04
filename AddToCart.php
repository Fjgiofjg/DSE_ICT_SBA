<?php
    //Connect DB
    $server = "localhost";
    $username = "Stellar_Database";
    $DBpassword = "pwdxvbKL2YKyn6Ca";
    $database = "stellar_database";

    $link = mysqli_connect($server, $username, $DBpassword, $database);
        if (!$link){
            die("Something went wrong");
        }
        else{
            echo "<script>console.log('DB link successful!')</script>";
        }

        if(!isset($_COOKIE["uid"])) {
            echo "<script>";
            echo "window.alert('Please login!');";
            echo "window.location.href='login.html';";
            echo "</script>";
        }

    //Prepare data
	$uid=$_COOKIE["uid"];
	$product_id=$_GET['product_id'];

    //Retrive data
    $query_r = "SELECT * FROM cart WHERE uid = " . $uid;
    $result_r = mysqli_query($link, $query_r);

    //Check data conflic with exsit data
    while ($row = mysqli_fetch_assoc($result_r)){
        if ($row['Product_id']==$product_id){
            header('location:694-01.html');            
        }
    }

	//Insert data
	$query = "INSERT INTO cart (uid, Product_id, Quantity) VALUES ('".$uid."','".$product_id."','1')";
	mysqli_query($link, $query);
    header('location:cart.php');
?>