<?php
if(isset($_POST['sendForm']) && $_SESSION['formInsert']){
	//get id of form inserted 
	$stmt = $currentUser->getCon()->prepare("SELECT * FROM form_list ORDER BY id DESC LIMIT 1");
	$stmt->execute();
	$getId = $stmt->get_result();
	// print_r($_POST);
	//if form exists and only one of this type present
	if(mysqli_num_rows($getId) == 1){
		$row = $getId->fetch_assoc();
		$id = $row['id'];
		//store question and its attributes in db
		foreach ($_POST as $key => $value) {
			if(strpos($key,"answer") === 0 && isset($_POST[$key])){
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
                  //get options and insert into options table
					if($ansType == "mcq" || $ansType == "dropdown"){
						$options = getoptions($checkedName,$ansType);
						print_r($options);
						$stmt = $currentUser->getCon()->prepare("SELECT id from form_questions ORDER BY id DESC LIMIT 1");
							$stmt->execute();
							$row = $stmt->get_result();
							$row = $row->fetch_assoc();
							$qid = $row['id'];
						foreach ($options as $key => $value) {
							$stmt = $currentUser->getCon()->prepare("INSERT INTO form_options (question_id,options) VALUES (?, ?)");
							$stmt->bind_param('is',$qid,$value);
							$stmt->execute();
							$stmt->close();
						}
						echo $value;
					}
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

function getoptions($name,$ansType){
	$questionNum = substr($name,0,-1) ? substr($name,0,-1) : $name;
	$options = array();
	echo $questionNum;
	foreach ($_POST as $key => $value) {
		if(strpos($key, "answer".$ansType.$questionNum) === 0 && $key != "answer".$ansType.$questionNum){
		   array_push($options, $value);
		   unset($_POST[$key]);
		}
	}
	return $options;
}
?>