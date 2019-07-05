<?php
$submissionCount = 0;
$timeForm = 0;
//get max submissions per user and validity of form
if(isset($_SESSION['submissionCount'])){
			$submissionCount = $_SESSION['submissionCount'];
		}
if(isset($_SESSION['timeForm'])){
	$timeForm = $_SESSION['timeForm'];
}		
if(isset($_POST['sendForm'])){
  	//get form details from $_POST
	if(!empty($_POST['title']) && !empty($_POST['description'])){
		$title = $_POST['title'];
		$description = $_POST['description'];
		$username = $currentUser->getUser();

		if($title != "" && $description != ""){
			$date = date("Y-m-d H:i:s");
			$totalSubmissions = 0;
			$status = 1;
  	        //insert form details and prevent sql injections
			$stmt = $currentUser->getCon()->prepare("INSERT INTO form_list (username,form_title,form_description,total_submissions,submissions_per_user,form_validity,date_created,status) VALUES (?, ?, ?, ?, ?, ?, ?,?)");
			$stmt->bind_param('sssiiiss',$username,$title,$description,$totalSubmissions,$submissionCount,$timeForm,$date,$status);
			$stmt->execute();
			$stmt->close();

			$_SESSION['formInsert'] = true;
		}

		else {
			header("location: formCreate.php");
			$_SESSION['formInsert'] = false;
		}
	}
	else {
		header("location: formCreate.php");
		$_SESSION['formInsert'] = false;
	}

	unset($_SESSION['submissionCount']);
	unset($_SESSION['timeForm']);
}
?>

