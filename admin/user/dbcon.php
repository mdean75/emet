<?php
require_once "functions.php";
$servername = "localhost";

/*$username = "njcadhos_admin";
$password = "njcad2820";

$dbname = "njcadhos_phpbb";
*/

$username = "njcadhosting";
$password = "Njcad2820'";
$dbname = "njcad_portal";

// Create connection
//$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
/*if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else{
	echo "Connection to database <strong>".$dbname."</strong> succeeded";
}
*/

/* ****************************
******************************


	object oriented db connection


**********************************
*********************************/
// connect using mysqli

//@$conn = new mysqli($servername, $username, $password, $dbname);
/*
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
*/
//connect using pdo

//$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
// set the PDO error mode to exception
//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 try{
  
  $conn = new PDO("mysql:host={$servername};dbname={$dbname}",$username,$password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
 }catch(PDOException $e){
  
  die($e->getMessage());
 }
?>