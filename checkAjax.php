<?php 
include("initial.php");
if(isset($_POST['username'])){
	$username = strval($_POST['username']);

	$stmt=$con->prepare("SELECT * FROM user WHERE username=?");
	$stmt->bind_param('s',$username);
	$stmt->execute();

	$result = $stmt->get_result();
	if(mysqli_num_rows($result) > 0 ){
		echo "false";
		return false;
	}
	else if(strlen($username) < 5){
		echo "short";
		return false;
	}
	else if(strlen($username) > 20){
		echo "long";
		return false;
	}
	else {
		echo "true";
		return true;
	}
}

?>