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
	<title>Create Form</title>
  <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
  <link rel="stylesheet" type="text/css" href="assets/stylesheets/formCreate.css">

  <meta property="og:url"           content= "<?php if(isset($url)){ echo $url;} ?>" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="Fill Form" />
  <meta property="og:description"   content="I invite you to fill my form"  />
  
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
          <button type="button" class="btn" name="settings" data-toggle="modal" data-target="#modal">Settings</button>
        </li>
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
        <input type="radio" name="type" value="mcq">
        <label>Multiple Choice</label>   
      </div>
      <div class="input-group">
        <input type="radio" name="type" value="dropdown">
        <label>DropDown</label>
      </div>
        <div class="input-group">
        <input type="radio" name="type" value="file">
        <label>Image Upload</label>   
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
        <div id="others" class="row">  
        </div>
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
    <div><p>Click Settings for more options</p></div>
  </form>  
</div>
</div>
</div>
</div>

<!-- display url and add fb share -->
<?php
if(isset($url)){
 echo '<div class="container"><div class="row url rounded justify-content-center">URL:-<a href='.$url.'>'.$url.'</a>
       <div class="fb-share-button ml-2" 
         data-href="'.$url.'"
         data-layout="button_count">
       </div>
       <div>
       <a class="twitter-share-button m-1"
           href="https://twitter.com/intent/tweet"
           data-url="'.$url.'">
            Tweet</a></div></div></div>';
}
?>


<!-- modal -->
<div class="modal fade" id="modal" data-backdrop="true" data-keyboard="false">
 <div class="modal-dialog modal-dialog-centered">
   <div class="modal-content">
     <div class="modal-header">
       <h4 class="modal-title">Other Options</h4>
     </div>
     <div class="modal-body">
       <div class="container-fluid">  
         <form id="form2">     
          <div class="form-group">
           <label for="submissionCount">Number Of Submissions per User: </label>
           <input type="number" class="form-control" name="submissionCount" id="submissionCount" step="1" min="1" placeholder="No restrictions">
           <small>Leave blank for no restrictions</small>
         </div>
         <div class="form-group">
           <label for="timedForm">Validity of the Form:</label>
           <input type="number" class="form-control" name="time" id="timedForm" step="1" min="1" placeholder="in days">
           <small>Leave it blank for no time constraints</small>
         </div>
         <button type="button" class="btn" id="otherOptions">Send</button>
       </form>
     </div>
   </div>
 </div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- twitter share -->
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<script type="text/javascript" src="assets/scripts/formCreate.js"></script>

<!-- //for facebook share -->
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>