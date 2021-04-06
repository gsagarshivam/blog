<?php
$servername = "127.0.0.1:8111";
$username = "root";
$password = "";
$Db="arogyamblog";
$base_url = "http://localhost/blog/";



// Create connection
$connect = mysqli_connect($servername, $username, $password,$Db);

//echo "<pre>"; echo print_r($connect); echo "</pre>"; 

// Check connection
if (!$connect) {
  die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
?>

