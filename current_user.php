<?php
session_start();
if(isset($_SESSION['userLoggedIn'])){
	$userLoggedIn = $_SESSION['userLoggedIn'];	
	$currentUser = new User($con,$userLoggedIn);
}
else{
	header("Location:register.php");
}
?>