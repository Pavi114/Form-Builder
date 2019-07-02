<?php 
session_start();
  if(isset($_POST['signOut']) || isset($_GET['signOut']) == true){
     session_destroy();
     header("Location:register.php");
  }
  ?>