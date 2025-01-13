<?php 
session_start();

/*$server = "server621.iseencloud.com";
$user   = "jomjomco";
$pass   = "W7#02YJpcAz1#v";
$data   = "jomjomco_ecommerce";

$conn = mysqli_connect($server,$user,$pass,$data);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/

$server = "localhost";
$user   = "root";
$pass   = "";
$data   = "ecommerce";

$conn = mysqli_connect($server,$user,$pass,$data);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>