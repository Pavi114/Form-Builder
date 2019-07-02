<?php
  if(isset($_POST['loginButton'])){
  	if($user->signIn()){
  		$_SESSION['userLoggedIn'] = $name;
  		$_SESSION['loggedIn'] = true;
  		if($_SESSION['logInToFillForm']){
  			header("Location: ".$_SESSION['url']);
  		}
  		else {
  		  header("Location:index.php");	
  		}
  		
  	}
 }

 ?>