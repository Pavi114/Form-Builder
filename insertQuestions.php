<?php
if(isset($_POST['sendForm']) && $_SESSION['formInsert']){
	//get id of form inserted 
	$stmt = $currentUser->getCon()->prepare("SELECT * FROM form_list ORDER BY id DESC LIMIT 1");
	$stmt->execute();
	$getId = $stmt->get_result();
	//if form exists and only one of this type present
	if(mysqli_num_rows($getId) == 1){
		$_SESSION['questionInsert'] = false;
		$row = $getId->fetch_assoc();
		$id = $row['id'];
		//store question and its attributes in db
		foreach ($_POST as $key => $value) {
			if(strpos($key,"answer") === 0){
				if($value != ''){
				//set required attribute of question to false (default)
					$required = "false";
				//get answer type from question name
					$trim = str_replace("answer","",$key);
					$ansType = preg_replace('/[0-9]+/',"",$trim);
				//whether required or not
					$checkedName = preg_replace('/[^0-9]+/', "", $trim);
					if(isset($_POST['required'.$checkedName])){
						$required = "true";
					}
                //insert question into db
					$stmt = $currentUser->getCon()->prepare("INSERT INTO form_questions (form_id,question,answer_type,required) VALUES (?, ?, ?, ?)");
					$stmt->bind_param('isss',$id,$value,$ansType,$required);
					$stmt->execute();
					$stmt->close();		
				}
				else{
					echo '<script>alert("Enter values for all questions")</script>';
					header("location: formCreate.php");
				}		
			}
			
		}
		
		$_SESSION['questionInsert'] = true;
	}
	else{
		die("duplicate forms exist");
	}
}
?>