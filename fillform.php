<?php
include("initial.php");
include("classes/input.php");
include("classes/buildform.php");
session_start();

$_SESSION['logInToFillForm'] = false;
if(isset($_GET['id'])){
	$_SESSION['current_form'] = $_GET['id'];
	$id = $_GET['id'];
	$buildForm = new FormBuilder($con,$id,"fillform.php",array('method' => 'POST'));
}
else {
	if(isset($_SESSION['form'])){
		$buildForm = unserialize($_SESSION['form']);
		$buildForm->validate();
	}

	else {
		die("invalid url");
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($_SESSION['userLoggedIn'])){echo $buildForm->getTitle(); }?> -Forms</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
	<link rel="stylesheet" type="text/css" href="assets/stylesheets/fillform.css">
</head>
<body>
	<nav class="navbar navbar-expand-xl navbar-light" id="navBar">
		<ul class="navbar-nav ml-auto align-items-center">
			<li class="nav-item">
				<form method="POST" action="logout.php">
					<button name="signOut" class="btn">SIGN OUT</button>
				</form>  
			</li>
		</ul>
	</nav>
     
    <!-- display form -->
	<?php 
	echo $buildForm->buildForm();
	$_SESSION['form'] = serialize($buildForm);
	?>
    
    <!-- modal-->
	<div class="modal" id="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="ModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<p>Please Login To Fill The Form</p>
				</div>
				<div class="modal-footer">
					<button type="button" name = "loginToFill" onclick="location.href='register.php'" class="btn">Log In</button>
				</div>
			</div>
		</div>
	</div>
	<div id="backdrop" class="hidden"></div>

    <!-- modal trigger -->
	<button type="button" class="hidden" id="showmodal" data-toggle="modal" data-target="#modal">
		Launch demo modal
	</button>

	<?php
	//if user not logged in trigger modal
	if(!isset($_SESSION['userLoggedIn'])){
		echo '<script>
		         var hidden = document.querySelector(".hidden");
		         var modal = document.querySelector("#modal");
		         var showmodal = document.querySelector("#showmodal");		
		         modal.style.display = "block";
		         document.querySelector("#backdrop").classList.remove("hidden"); 

		         showmodal.click();
		         showmodal.addEventListener("click",function(){
			        modal.classList.add("fade");
			      });
			 </script>';
			$_SESSION['logInToFillForm'] = true;
			$_SESSION['url'] = "http://localhost/form%20builder/fillform.php?&id=".$_GET['id'];
		}
		?>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>