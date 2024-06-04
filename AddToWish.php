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
	$product_id_g=$_GET['product_id'];

	//Retrive data
    $query_r = "SELECT * FROM wish WHERE uid = " . $uid;
    $result_r = mysqli_query($link, $query_r);

    //Check data conflic with exsit data
    while ($row = mysqli_fetch_assoc($result_r)){
        if ($row['Product_id']==$product_id_g){
            header('location:694-01.html');
        }
    }
    //Insert to table if no conflic
    $query = "INSERT INTO wish (uid, Product_id) VALUES ('".$uid."','".$product_id_g."')";
    mysqli_query($link, $query);
    header('location:wish.php');
?>