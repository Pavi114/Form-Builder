<?php
include("initial.php");
include("classes/input.php");
include("classes/buildform.php");
include("classes/User.php");
include("current_user.php");

function updateFormTable(){
	$con = mysqli_connect('localhost','root','idc1234','delta');
	//increase submit count 
  $stmt=$con->prepare("UPDATE form_list SET total_submissions = total_submissions + 1 WHERE id=?");
  $stmt->bind_param('i',$_SESSION['current_form']);
  $stmt->execute();
  $stmt->close(); 
}

function setNotif(){
  $con = mysqli_connect('localhost','root','idc1234','delta');
  //fetching details about the creator of form
  $stmt = $con->prepare("SELECT * FROM form_list WHERE id=?");
  $stmt->bind_param('i',$_SESSION['current_form']);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  //creator
  $creator = $row['username'];
  //current user
  $formFillUser = $_SESSION['userLoggedIn'];
  $message = $formFillUser.' filled your '.$row['form_title'].' form.';
  //insert msg into db
  $stmt = $con->prepare("INSERT INTO notifications(username,message) VALUES(?, ?)");
  $stmt->bind_param('ss',$creator,$message);
  $stmt->execute();
  $stmt->close();
}

//after inserting answers
if(isset($_SESSION['submitSuccess'])){
	updateFormTable();
	setNotif();
    unset($_SESSION['submitSuccess']);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Form Submitted</title>
	<link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/stylesheets/afterSubmit.css">
</head>
<body>
	<div class="bar">
	 <h2>
		 <span onclick="location.href = 'index.php'"><?php
		   echo $currentUser->getUser();
		?></span> 
		<form action="logout.php" method="POST">
		 <button type="submit" name="signOut">Sign Out</button>	
		</form>
		
	</h2>	
	</div>
	
	<div class="container justify-content-center">
		<div class="jumbotron">
			<div>
				<img src="assets/images/success.png">
			</div>
			<h3>Thank You</h3>
			<h6>Your response has been submitted successfully</h6>
		</div>	
	</div>

</body>
</html>