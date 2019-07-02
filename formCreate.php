<?php
include("initial.php");
include("classes\User.php");
include("current_user.php");
include("insertForm.php");
include("insertQuestions.php");
include("generateURL.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>I Have No Idea</title>
  <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
 <link rel="stylesheet" type="text/css" href="assets/stylesheets/formCreate.css">
</head>
<body>
  
  <!-- navbar -->
  <nav class="navbar navbar-expand-md navbar-light" id="navBar">
    <a class="navbar-brand" href="index.php"><i style="color:white;" class="fas fa-arrow-left"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link" style="color:white;" href="logout.php?signOut=true">SIGN OUT</a>
        </li>
      </ul>
    </div>
  </nav>


  <div class="container">
    <div class="row">
      <!--  display types available -->
      <div class="col-md-3 option rounded mr-auto justify-content-center">
         <div class="input-group">
           <input type="radio" name="type" value="text">
           <label>Short Answer</label>
          </div>
         <div class="input-group">
           <input type="radio" name="type" value="number">  
           <label>Number</label>
         </div>
         <div class="input-group">
          <input type="radio" name="type" value="Multiple Choice">
          <label>Multiple Choice</label>   
         </div>
         <div class="input-group">
         <input type="reset" class="btn" id="typeButton" value="Add" style="border: 1px solid black">  
         </div>
      </div>
      
      <!-- form additions -->
      <div class="col-md-8">
       <div class="justify-content-center border border-dark rounded shadow-lg bg-white rounded">
         <form id="form" method="POST" action="formCreate.php">
            <div class="container">
             <header>
              <h2 class="text-center">CREATE CUSTOM FORMS</h2>
              <hr>
             </header>   
           </div>  
           <div class="input-group">
             <input type="text" name="title" id="title" class="form-control input" placeholder="Title" required>    
           </div>
           <div class="input-group">
            <input type="text" name="description" id="description" class="form-control input" placeholder="Description" required>
           </div>
           <div class="input-group">
            <button class="btn" type="submit" name="sendForm" id="sendForm">SEND</button>   
           </div>
         </form>  
       </div>
     </div>
   </div>
</div>

<!-- display url -->
<?php
if(isset($url)){
 echo '<div class="container"><div class="row url rounded justify-content-center">URL:-<a href='.$url.'>'.$url.'</a></div></div>';
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/scripts/formCreate.js"></script>
</body>
</html>