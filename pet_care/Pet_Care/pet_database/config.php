<?php
$serverName="localhost";
$userName="root";
$password="";
$dbName="petcare";

$conn = mysqli_connect($serverName,$userName,$password,$dbName);


if(!$conn){
    die("DB connection failed:".mysqli_connect_error());
}
else{
  // echo "<script> alert('Connection with db successful!') </script>";
}
?>