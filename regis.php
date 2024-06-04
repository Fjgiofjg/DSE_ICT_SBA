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

// Get the form data 
$username = $_POST['username']; 
$uid = $_POST['uid']; 
$password = $_POST['password']; 
$class = $_POST['class']; 
$class_no = $_POST['class_no']; 

	//Retrive data
    $query_r = "SELECT uid FROM users";
    $result_r = mysqli_query($link, $query_r);

    while ($row = mysqli_fetch_assoc($result_r)){
        if ($row['uid'] == $uid ){
            header('location:404.html');
        }
    }
    //Insert to table if no conflic
    $query = "INSERT INTO users (Username, uid, Class, Class_No, Password) VALUES ('$username', '$uid', '$class', '$class_no', '$password')";    mysqli_query($link, $query);
    header('location:login.html');
?>