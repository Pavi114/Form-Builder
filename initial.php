<?php

$servername = 'localhost';
$username = 'root';
$password = 'idc1234';
$database = 'delta';

$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

// Create database

$sql = "CREATE DATABASE delta";
$connect = $conn->query($sql);



//verify connection to database
$con = mysqli_connect($servername,$username,$password,$database);



?>