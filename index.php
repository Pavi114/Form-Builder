<?php
include("initial.php");
include("classes/User.php");
include("current_user.php");

//display form created by user 
function display($row){
  $url = str_replace("fillform.php", "response.php", $row['url']);
  return '<tr><td>'.$row['form_title'].'<br>'.$row['form_description'].'</td><td><form action='.$url.' method="POST">
  <button class="btn" name="response">RESPONSES</button>
  </form></td></tr>';
}
?>

<!DOCTYPE html>
<html>
<head>
 <title>you figure out this aswell</title>
 <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
 <link rel="stylesheet" type="text/css" href="assets/stylesheets/index.css">
</head>
<body>

 <!-- navbar -->
 <nav class="navbar navbar-expand-md navbar-light" id="navBar">
   <a href="#" class="navbar-brand nav-link disabled"><?php echo $currentUser->getUser(); ?></a>
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
   </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
  </div>
</nav>

<!-- view forms created and templates(to be made) -->
<div class="container">
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <img src="assets/images/new.jpg" class="card-img-top" alt="NEW">
        <div class="card-body">
          <h5 class="card-title">Blank Form</h5>
          <a href="formCreate.php" class="btn">Go</a>
        </div>
      </div>  
    </div>    
  </div>
</div>
<hr>

<div class="container mt-lg-4 mr-auto">
  <div class="col-md-8">
    <h2 class="text-center">Your Forms</h2>
    <hr>
    <div class="table-responsive-sm">
      <table class="table rounded table-striped">

       <?php
       //get user's forms
       $user = $currentUser->getUser();
       $stmt = $con->prepare("SELECT * FROM form_list WHERE username = ? ");
       $stmt->bind_param('s',$user);
       $stmt->execute();
       // $query = "SELECT * FROM form_list WHERE username = '$user'";
       $getForms = $stmt->get_result();

       //display form titles to view response
       $output = '';
      
       if(mysqli_num_rows($getForms) == 0){
          //no forms created
         $output = '<div class="container text-center p-lg-2">
         Nothing to display
         </div>';
       }
       else {
         while($row = $getForms->fetch_assoc()){
           $output .= display($row);
         }  
       }
       echo $output;
       ?>

     </table>
   </div>
 </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
