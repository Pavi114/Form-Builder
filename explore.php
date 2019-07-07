<?php
include("initial.php");
include("classes/User.php");
include("current_user.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Explore</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
</head>
<style type="text/css">
body {
	background: #000000;
	color: #FFFFFF;
	text-align: center;
	font-size: 1.5vw;
	font-family: Rubik;
}
#display {
	background: rgba(0, 0, 0, 0.3);
	margin-bottom: 10px;
	margin-top: 0px;
}
.container {
	background: #fffacd;
}
.btn {
	background-color: #fffacd;
	width: 100%;
	font-size: 2vw;
}
.btn:hover {
	background: rgba(0, 0, 0, 0.4);
}

@media (min-width: 300px) and (max-width: 480px) {
	body {
		font-size: 3.5vw;
	}
}
</style>
<body>
	<nav class="navbar navbar-expand navbar-dark bg-dark" id="navBar">
		<a href="#" class="navbar-brand nav-link disabled" id="user">Form Builder</a>
		<ul class="navbar-nav mr-auto ml-4">
			<li class="nav-item">
				<a class="nav-link border-0" href="index.php">HOME</a>
			</li>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link rounded" href="logout.php?signOut=true">SIGN OUT</a>
			</li>
		</ul>
	</nav>

	<div class="container rounded mt-lg-4 mx-md-auto m-sm-0">
		<div class="row">
			<div class="col-sm-6">
		     <button type="button" class="btn" id="byDate">ORDER BY DATE</button>		
			</div>
			<div class="col-sm-6">
			  <button type="button" class="btn" id="trending">TRENDING</button>	
			</div>
		</div>
        <table id="display" class="table rounded">  
            	
        </table>
	</div>

</body>
</html>


<script type="text/javascript">
	var byDate = document.querySelector("#byDate");
	var trending = document.querySelector("#trending");
    var httpRequest = new XMLHttpRequest();
	byDate.addEventListener("click",function(){
      ajaxCall(0);
	});
	trending.addEventListener("click",function(){
		ajaxCall(1);
    });
    	function displayList(){
			var response = httpRequest.responseText;
			document.querySelector("#display").innerHTML = response;
	}

	function ajaxCall(option){
		
		httpRequest.onreadystatechange = displayList;
		httpRequest.open('POST','fetchFormExplore.php');
		httpRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		httpRequest.send('option='+ option);

	}

	window.onload = ajaxCall(1);

</script>