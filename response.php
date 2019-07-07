<?php 
include("initial.php");
include("classes/User.php");
include("current_user.php");

if(isset($_POST['response'])){
	$id = $_GET['id'];

    //fetch form details of that id
	$stmt = $currentUser->getCon()->prepare("SELECT * FROM form_list WHERE id=?");
	$stmt->bind_param('i',$id);
	$stmt->execute();
	$result = $stmt->get_result();
	if(mysqli_num_rows($result) == 1){
		$row = $result->fetch_assoc();
		//if user who's viewing responses is not the same as the creator
		if($userLoggedIn != $row['username']){
			die("Not Authorised to view Responses"); 
		}

	}
	else{
		die("terminate");
	}
}
else{
	die("Not authorised to view responses");
}

//displays responses of each question
function displayAnswers($link){
	$output = '';
	while($row = $link->fetch_assoc()){
		$output .= '<div class="p-1 rounded">'.$row['answer'].'</div>';
	}
	$output .= '</div></li><hr>';
	echo $output;

}

function displayFile($link){
	$output = '<div class="row">';
	while($row = $link->fetch_assoc()){
		$output .= '<div class="row m-2"><a href="'.$row['answer'].'">'.$row['answer'].'</a></div>';

		//<img src="'.$row['answer'].'" alt="image"> cannot display image because of browser block
	}
	$output .= '</div></li><hr>';
	return $output;


}

//display title of form
function getTitle($id,$conn){

	$query = "SELECT * FROM form_list WHERE id ='$id'";
	$link = mysqli_query($conn,$query);
	$row = $link->fetch_assoc();
	return $row['form_title'];
}

//display form question
function displayQuestion($string){
	$output = '<li class="p-lg-1"><div class="p-lg-2">'.$string.'</div><div class="d-flex flex-column">';
	return $output;
}
?>


<!DOCTYPE html>
<html>
<head>
	<title><?php  if(isset($_POST['response'])){
		$conn = $currentUser->getCon();
		echo getTitle($id,$conn);
	}
	?>
:Responses</title>
<link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
<link rel="stylesheet" type="text/css" href="assets/stylesheets/response.css">

</head>
<body>
	<!--  navbar -->
	<nav class="navbar navbar-expand navbar-light" id="navBar">
		<a class="navbar-brand" href="index.php"><i style="color:white;" class="fas fa-arrow-left"></i></a>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto align-items-center">
				<li class="nav-item">
					<a class="nav-link" style="color:white;" href="register.php">SIGN OUT</a>
				</li>
			</ul>
		</div>
	</nav>

	<!-- Response list -->
	<div class="container justify-content-center border rounded p-lg-3 p-sm-1 mx-auto mt-4">
		<div class="card border-0">
			<div class="card-body">
				<h2><?php  
				if(isset($_POST['response'])){
					$conn = $currentUser->getCon();
					echo getTitle($id,$conn);
				} ?>	
			    </h2>
			    <hr>

		   </div>
	   </div>
	   <ol class="list rounded p-lg-4 p-sm-1">
		
		<?php
		if(isset($_POST['response'])){

            //get questions from db
			$stmt = $currentUser->getCon()->prepare("SELECT * FROM form_questions WHERE form_id= ? ORDER BY id");
			$stmt->bind_param('i',$id);
			$stmt->execute();

			$getQuestion = $stmt->get_result();

            //display answers for each question
			while($row = $getQuestion->fetch_assoc()){
				$question = $row['question'];

				echo displayQuestion($question);
                $question_id = $row['id'];

                    //get answers from db
				$stmt = $currentUser->getCon()->prepare("SELECT * FROM answers WHERE question_id = ?");
				$stmt->bind_param('i',$question_id);
				$stmt->execute();

				$link = $stmt->get_result();

				$stmt->close();
				if($row['answer_type'] == "number" || $row['answer_type'] == "text" || $row['answer_type'] == "mcq" || $row['answer_type'] == "dropdown"){
					$output = displayAnswers($link);
				}
				else if($row['answer_type'] == "file"){
					echo '<small>Copy Paste Link address to view Image</small>';
					$output = displayFile($link);
				}
				echo $output;
			}
		}
		?>

	</ol>
</div>
</body>
</html>