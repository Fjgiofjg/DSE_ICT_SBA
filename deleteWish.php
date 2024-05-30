<?php 
	//Connect db
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
	
	//Delete data
	$query = "DELETE FROM wish WHERE uid='".$_COOKIE["uid"]."' AND Product_id='".$_GET['product_id']."'";
	mysqli_query($link, $query);
    header('location:wish.php');
?>