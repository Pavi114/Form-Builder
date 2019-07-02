<?php
if(isset($_POST['sendForm'])){
  	//get form details from $_POST
	if(isset($_POST['title']) && isset($_POST['description'])){
		$title = $_POST['title'];
		$description = $_POST['description'];

		$username = $currentUser->getUser();

		if($title != "" && $description != ""){
  	        //insert form details and prevent sql injections
			$stmt = $currentUser->getCon()->prepare("INSERT INTO form_list (username,form_title,form_description) VALUES (?, ?, ?)");
			$stmt->bind_param('sss',$username,$title,$description);
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
}
?>