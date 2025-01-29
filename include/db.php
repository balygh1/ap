<?php
$dbname="mysql:host=localhost:3306;dbname=travel";
$username="root";
$password="";
try{

$conn = new PDO($dbname,$username,$password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
echo $e->getMessage();
}
?>