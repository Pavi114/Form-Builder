<?php
  if(isset($_POST['registerButton'])){
    //sanitizing data
  	$fn = stripTagName($_POST['firstname']);
  	$ln = stripTagName($_POST['lastname']);
  	$username = stripTag($_POST['username']);
  	$email = stripTag($_POST['email']);
  	$password = stripTag($_POST['passwordCreate']);
  	$confirmPassword = stripTag($_POST['passwordConfirm']);
    
    
  	$registerSuccess = $user->signup($fn,$ln,$username,$password,$confirmPassword,$email);

}

function stripTagName($string){
	$string = strip_tags($string);
	$string = strtoupper($string);
	return $string;
}

function stripTag($string){
	$string = strip_tags($string);
	return $string;
}

?>