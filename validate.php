<?php
  $uid =$_POST['uid'];
  $password =$_POST['pw'];
  $checked=0;
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

  //Fetch data
	$query = "SELECT * FROM users WHERE uid='".$uid."' AND Password='".$password."'";
	$result = mysqli_query($link, $query);

  while ($row = mysqli_fetch_assoc($result)){
    //echo "Username:".$row["Username"].",uid:".$row["uid"].",Password:".$row["Password"].",Is_Admin:".$row["Is_Admin"].",Class:".$row["Class"].",Class_No:".$row["Class_No"]."<br>";
    $checked = 1;
  }

  //Compair user input and DB data
  if ($checked==1){
    //success
    setcookie("uid",$uid,time()+3600);
    echo "<script>";
    echo "window.location.href='home.php'";
    echo "</script>";
  }
  else{
    echo "<script>";
    echo "alert('Invalid User ID / Password!');";
    echo "window.location.href='login.html'";
    echo "</script>";
  }
?>