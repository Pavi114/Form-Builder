<?php
include("initial.php");
include("classes/User.php");
include("current_user.php");

$user = $currentUser->getUser();
$stmt = $con->prepare("SELECT * FROM form_list WHERE username = ?");
$stmt->bind_param('s',$user);
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()){
  $timeNow = time();
  if($row['form_validity'] != 0 && ($timeNow - (strtotime('+'.$row['form_validity']." day", strtotime($row['date_created'])))) > 0){
       //if time over then close form
    $stmt = $con->prepare("UPDATE form_list SET status='0' WHERE id=?");
    $stmt->bind_param('i',$row['id']);
    $stmt->execute();
  }
}

//display form created by user 
  function display($row){
    $url = str_replace("fillform.php", "response.php", $row['url']);
    return '<tr><td>'.$row['form_title'].'<br><small><a href="'.$row['url'].'">View form</a></small></td><td style="font-size: 1.5vw;">'.$row['total_submissions'].'</td><td><form action='.$url.' method="POST">
    <button name="response" class="btn">VIEW</button>
    </form></td></tr>';
  }
  ?>

  <!DOCTYPE html>
  <html>
  <head>
   <title>you figure out this aswell</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
   <link rel="stylesheet" type="text/css" href="assets/stylesheets/index.css">
 </head>
 <body>

   <!-- navbar -->
   <nav class="navbar navbar-expand-lg navbar-light" id="navBar">
     <a href="#" class="navbar-brand nav-link disabled" id="user"><?php echo $currentUser->getUser(); ?></a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav mr-auto ml-4">
       <li class="nav-item">
         <a class="nav-link border-0" href="index.php">HOME</a>
       </li>
       <li class="dropdown nav-item" id="notifs">
        <a href="#" class="nav-link rounded" data-toggle="dropdown" class="dropdown-toggle text-dark">Notifications</a>
        <div class="dropdown-menu" id="notifications"></div>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link rounded" href="formCreate.php">CREATE FORM</a>
      </li>
      <li class="nav-item">
        <a class="nav-link rounded" href="explore.php">EXPLORE</a>
      </li>
      <li class="nav-item">
        <a class="nav-link rounded" href="logout.php?signOut=true">SIGN OUT</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container mt-lg-4 mx-md-auto m-sm-0">
  <div class="rounded">
    <h2 class="text-center">Your Forms</h2>
    <hr>
    <!---display open and trending forms----->
    <h3>Open Forms</h3>
    <div class="table-responsive-sm">
      <table class="table rounded table-striped">
       <?php
       //get user's forms
       $user = $currentUser->getUser();
       $stmt = $con->prepare("SELECT * FROM form_list WHERE username = ? and status = '1' ORDER BY total_submissions DESC");
       $stmt->bind_param('s',$user);
       $stmt->execute();
       
       $getForms = $stmt->get_result();

       //display form titles to view response
       $output = '';

       if(mysqli_num_rows($getForms) == 0){
          //no forms created
         $output .= '<div class="container text-center p-lg-2">
         No current forms
         </div>';
       }
       else {
         echo '<tr><th>Form</th><th>submissions</th><th>Response</th></tr>';
         while($row = $getForms->fetch_assoc()){
           $output .= display($row);
         }  
       }

       echo $output;
       ?>
     </table>
   </div>

   <!------display closed forms in decreasinf order of responses---->
   <h3>Closed Forms</h3>
   <div class="table-responsive-sm">
    <table class="table rounded table-striped">
     <?php
     $output = '';
     $user = $currentUser->getUser();
     $stmt = $con->prepare("SELECT * FROM form_list WHERE username = ? and status = '0' ORDER BY total_submissions DESC");
     $stmt->bind_param('s',$user);
     $stmt->execute();

     $getForms = $stmt->get_result();

     if(mysqli_num_rows($getForms) == 0){
      $output .= '<div class="container text-center p-lg-2">
      No closed forms
      </div>';
    }
    else {
      echo '<tr><th>Form</th><th>submissions</th><th>Response</th></tr>';
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
<script type="text/javascript" src="assets/scripts/index.js"></script>
</body>
</html>
