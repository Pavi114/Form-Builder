<?php

class FormBuilder {
  private $con;
  private $title;
  private $description;
  private $inputs = array();
  private $formAttr = array();
  private $error = array();

  function __construct($con,$id,$action,$args=array()){

    //connect to db
    $this->con = mysqli_connect('localhost','root','idc1234','delta');
    
    //default form settings
    $default = array('action' => '',
     'method' => 'POST',
     'enctype' => 'application/x-www-form-urlencoded',
     'id' => '');

    //change action
    if(!empty($action)){
      $default['action'] = $action;
    }
    
    //change id
    if(!empty($id)){
      $default['id'] = $id;
    }
    
    //if form attributes are different than the default
    if(!empty($args)){
     $formAttr = array_merge($default,$args);
   }
   else{
     $formAttr = $default;
   }

    //set form attributes
   foreach ($formAttr as $key => $value) {
     $this->setAttr($key,$value);
   }

   //fetch questions from db based on form_id
   $query = "SELECT * FROM form_questions WHERE form_id = '$id' ORDER BY id";
   $getdata = mysqli_query($con,$query);

   //set inputs array with questions and its attributes
   if(mysqli_num_rows($getdata) > 0){
     while($row = $getdata->fetch_assoc()){
       array_push($this->inputs, new Input($row['id'], $row['question'],$row['answer_type'],$row['required']));
     }
   }
   else {
    array_push($this->error, "Form Not Found");
  }

   //fetch title and description based on form id
  $query = "SELECT form_title,form_description FROM form_list WHERE id = '$id'";
  $getdata = mysqli_query($con,$query);
  $row = $getdata->fetch_assoc();

   //set title and description
  $this->title = $row['form_title'];
  $this->description = $row['form_description'];

}

private function setAttr($attr,$value){
  if($attr == "method"){
    if(!in_array($value,array('GET','POST'))){
      $value = 'POST';
    }
  }
  else if($attr == "enctype"){
    if(!in_array($value,array('application/x-www-form-urlencoded','multipart/form-data','text/plain'))){
      $value = 'application/x-www-form-urlencoded';
    }
  }
  else if($attr == "action" || $attr == "id"){

  }
  else {
    return;
  }

  $this->formAttr[$attr] = $value;
}


 //add question and input field to form
private function addInput($value){
  $input = '';
  //get ans type for this question
  $type = $value->getAnstype();
  //set name,id for answer field
  $value->setAttr();
  
  switch ($type) {
    case 'text': 
    case 'number':
    case 'email':
    case 'url':   $input .= '<li><div class="form-group">'; 
                  //append question field
                  $input .= '<label for="answer">'.$value->getQuestion().'</label>';
                  if($value->getRequired() == "true"){
                    $input .= '<span><i class="fas fa-plus"></i></span>';
                  }
                  //append answer field
                  $input .= '<input type="'.$type.'"';
                  $input .= 'class=';
                  //add classes to ans field
                  $class = $value->getAttr("class");
                  foreach($class as $key){
                    $input .= '"'.$key.'" ';
                  }
                  //get id,name of ans field
                  $input .= 'id="'.$value->getAttr('id').'"';
                  $input .= 'name="'.$value->getAttr('name').'"';
                  $input .= 'placeholder="'.$type.'"';
                  //if answering this is required
                  if($value->getRequired() == "true"){
                   $input .= ' required';
                  }
                 $input .= '>';
                 //if any errors are found during validation add them as well
                 if(isset($this->error[$value->getAttr('name')])){
                   $input .= '<span>'.$this->error[$value->getAttr("name")].'</span>';
                 }

                 $input .= '</div></li>';
              break;
  }
  return $input;
}


public function getTitle(){
  return $this->title;
}

public function buildForm(){

  $form = '';

  $form = '<form method ="'.$this->formAttr['method'].'" 
  action ="'.$this->formAttr['action'].'"
  enctype ="'.$this->formAttr['enctype'].'" 
  >';      
  $form .= '<div class="container rounded">';
  $form .=   '<div class="card border-0">
  <div class="card-body">'
  .'<h2>'.$this->title.'</h2>'
  .$this->description
  .'<br>'
  .'<span><i class="fas fa-plus"></i> Required</span>'
  .'<hr>
  </div>
  </div>
  <ol>';
  
  //add input to form body
  foreach ($this->inputs as $key => $value) {
   $form .= $this->addInput($value);
  }

 $form .= '</ol>';

 $form .= '<button type="submit" class="btn" name="submitForm">SUBMIT</button></div></form>';

 return $form;

}

public function validate(){
  $this->error = array();
  //validate input
  foreach ($this->inputs as $key => $value) {
    $name = $value->getAttr('name');
    if(isset($_POST[$name])){
      $answer = strip_tags($_POST[$name]);
     $validate = $value->validateAnswer($answer);
     if(!is_string($validate)){
      $value->setAnswer($_POST[$name]);
      }
     else {
      $this->error[$name] = $validate;
     }
    }
  }

 //if no errors the success
 if(empty($this->error)){
  $this->insertAns();
  header("location: afterSubmit.php");
 }
}

//insert answers to db with the coressponding id of question
public function insertAns(){
 foreach ($this->inputs as $key => $value) {
  $id = $value->getId();
  $answer = $value->getAnswer();
  $user = $_SESSION['userLoggedIn'];        
  $con = mysqli_connect('localhost','root','idc1234','delta');
  
  //inserting answer and prevent sql injections
  $stmt = $con->prepare("INSERT INTO answers (question_id,answer,username) VALUES (?,?,?)");
  $stmt->bind_param('iss',$id,$answer,$_SESSION["userLoggedIn"]);
  $stmt->execute();
  $res = $stmt->get_result();
  $stmt->close();
  }
  //unsetting session 
  unset($_SESSION['form']);
}

}
?>