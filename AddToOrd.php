<?php
// Connect DB
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

// Prepare data
$uid=$_COOKIE["uid"];
$date = date_create();
$ref_no= date_timestamp_get($date);

// Retrieve data
$query_r = "SELECT * FROM cart WHERE uid = " . $uid;
$result_r = mysqli_query($link, $query_r);

while ($row = mysqli_fetch_assoc($result_r)) {
    $product_id = $row['Product_id'];
    $quantity = $row['Quantity'];
    $variation_id =$row['var_id'];

    $query_o = "INSERT INTO orders (uid, RefNo, Product_id, Quantity, var_id) VALUES ('".$uid."','".$ref_no."','".$product_id."','".$quantity."','".$variation_id."')";
    mysqli_query($link, $query_o);

    $query_d = "DELETE FROM cart WHERE uid='".$uid."' AND Product_id='".$product_id."' AND var_id='".$variation_id."'";
    mysqli_query($link, $query_d);
}

header('location:confirm.php');
?>