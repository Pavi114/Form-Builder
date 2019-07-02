<?php
session_start();
include("createDB.php");
include("classes\constants.php");
include("classes\signup.php");
if(isset($_SESSION['userLoggedIn'])){
	header("location: index.php");
}

$user = new Account($con);
$registerSuccess = false;

include("registerCheck.php");
include("classes\signin.php");

//login
if(isset($_POST['loginButton'])){
	$name = $_POST['username'];
	$password = $_POST['password'];
	$user = new SignIn($con,$name,$password);
}

include("loginCheck.php");

function getValue($name){
	if(isset($_POST[$name]))
		echo $_POST[$name];
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>You Figure Out</title>
	<link href="https://fonts.googleapis.com/css?family=Rubik|Itim&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/stylesheets/register.css">
</head>
<body>
	
	<!-- login -->
	<div class="container">
		<div class="row">
			<div id="signIn">
				<div class="col-md-8">
					<div class="image">
						<div class="middle">
							<h2>FORM BUILDER</h2>	
							<hr>
							<h4><span id="intro">Collect and Organise Information </span>with our FORMS</h4>	
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="loginGroup">
						<h1 class="text-center">Sign In</h1>
						<?php
						if($registerSuccess){
							echo '<p class="text-center" style="color:rgb(1,50,32);">'.Constants::$successRegister.'</p>';
						}
						?>

						<form class="login-form" action="register.php" method="POST">
							<div class="form-group">
								<label>Username:</label>
								<input type="text" name="username" class="form-control" placeholder="USERNAME" required> 
							</div>
							<div class="form-group">
								<label>Password:</label>
								<input type="password" name="password" class="form-control" placeholder="PASSWORD" required>
								<?php
								echo $user->displayError(Constants::$loginFailed);
								?>
							</div>
							<div class="form-group">
								<button type="submit" name="loginButton" style="float:right;" class="btn btn-login">SIGN IN</button>	
							</div>

							<div class="showSpan">
								<p id="registerShow" >No account? Click Here.</p>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- register -->
	<div class="container">
		<div class="row">
			<div id="signUp" class="hidden">
				<div class="col-md-7">
					<div class="image">
						<div class="middle">
							<h2>REGISTER HERE</h2>	
							<hr>	
						</div>
					</div>
				</div>	
				<div class="col-md-5">
					<div class="loginGroup">
						<form action="register.php" method="POST">
							<h1 class="text-center">Sign In</h1>
							<div class="form-group" style="margin: 0px;">
								<?php
								echo $user->displayError(Constants::$invalidFirstName);
								?>
								<input type="text" name="firstname" class="form-control" style="width:50%;" value="<?php getValue("firstname");?>" placeholder="First Name (5-20 char)" required>	
							</div>	
							<div class="form-group" style="margin: 0px;">
								<?php
								echo $user->displayError(Constants::$invalidLastName);
								?>	
								<input type="text" name="lastname" class="form-control" style="width:50%;" value="<?php getValue("lastname");?>" placeholder="Last Name (5-20 char)" required>

							</div>						
							<div class="form-group row" style="margin: 0px;">
								<input type="text" name="username" id="username" class="form-control" style="width:60%" placeholder="Username (5-20 char)" required>
								<span style="padding: 2px;padding-bottom: 0;" id="userAvail"></span>
								<?php
								echo $user->displayError(Constants::$invalidUsername);
								echo $user->displayError(Constants::$existingUsername);
								?>
							</div>
							<div class="form-group" style="margin: 0px;">
								<input type="email" name="email"  class="form-control" value="<?php getValue("email");?>" placeholder="Email" required>
								<?php
								echo $user->displayError(Constants::$existingEmail);
								?>
								<small class="form-text text-muted">We'll never share your email with anyone else.</small>
							</div>
							<div class="form-group" style="margin: 0px;">
								<input type="password" name="passwordCreate"  class="form-control" style="width:50%" placeholder="Password" required>
								<?php
								echo $user->displayError(Constants::$invalidPasswordLength);
								?>	
								<small class="form-text text-muted">Password must be minimun 6 characters long.</small>		
							</div>
							<div class="form-group" style="margin: 0px;">
								<input type="password" name="passwordConfirm"  class="form-control" style="width:50%" placeholder="Confirm Password" required>
								<?php
								echo $user->displayError(Constants::$passwordsDoNotMatch);
								?>
							</div>
							<div class="submit">
								<button type="submit" name="registerButton" class="btn btn-login">SIGN UP</button>		
							</div>
							<div class="showSpan"><p id="loginShow">Have an account? Click Here</p></div>	
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!--  if register success then display login else register -->
	<?php
	if(isset($_POST['registerButton'])){
		if($registerSuccess){
			echo '<script>
			var hidden = document.querySelector(".hidden");
			var login = document.querySelector("#signIn");
			var register = document.querySelector("#signUp");
			register.classList.add("hidden");
			login.classList.remove("hidden");
			</script>';
		}
		else {
			echo '<script>
			var hidden = document.querySelector(".hidden");
			var login = document.querySelector("#signIn");
			var register = document.querySelector("#signUp");
			register.classList.remove("hidden");
			login.classList.add("hidden");
			</script>';
		}
	} ?>

	<script type="text/javascript" src="assets/scripts/register.js"></script>
	<script type="text/javascript" src="ajax.js"></script>
</body>
</html>