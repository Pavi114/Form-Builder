<?php
include("initial.php");
include("classes/input.php");
include("classes/buildform.php");
include("classes/User.php");
include("current_user.php");
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