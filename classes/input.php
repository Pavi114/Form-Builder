<?php 
class Input {
   	private $id; //question id in db
   	private $question;
   	private $answerType;
    private $ansAttr = array();
    private $answer;
    protected $required;

    function __construct($id,$question,$answerType,$required){
     $this->id = $id;
     $this->question = $question;
     $this->answerType = $answerType;
     $this->required = $required;
     $this->ansAttr = array('id' => '',
      'name' => '',
      'class' => array(),
      'ext' => '');
   }

   public function getId(){
     return $this->id;
   }

   public function getQuestion(){
     return $this->question;
   }

   public function getAnsType(){
     return $this->answerType;
   }
   public function getRequired(){
     return $this->required;
   }
   public function setAnswer($answer){
    $this->answer = $answer;
  }

  public function validateAnswer($answer){
    if($this->answerType == "text"){
     $ans = str_replace(array(' ', "'", '-','!','@','#','$','%','^','&','*','(',')',':',';','?','/','<','>',',','.','-','_','+','='), '', $answer);
     if($this->required == "false"){
      if(!ctype_alnum($ans) && !empty($ans)){
        return "Enter Text";
      }
    }
    else{
      if(!ctype_alpha($ans) || is_null($answer) || empty($ans)){
        return "Enter text";
      }
    }
  }
  else if($this->answerType == "number"){
    if($this->required == "false"){
      if(ctype_alpha($answer) && !empty($ans)){
        return "Enter numeric values";
      }
    }
    else{
      if(!is_numeric($answer) || is_null($answer) || empty($ans)){
        return "Enter numeric values";
      }
    }
  }
  else if($this->answerType == "mcq"){
    if($this->required == "true" && empty($answer)){
       return "Please Choose an option";
    }
  }
  return 1;
}

//validating file
public function validateFile($file){
  $fileName = $file['name'];
  $fileError = $file['error'];
  $fileSize = $file['size'];

  $fileExt = explode('.',$fileName);
  $actualFileExt = strtolower(end($fileExt));
  
  if($this->answerType == "file"){
    $allowedExt = array('jpg', 'jpeg', 'png', 'gif');
    if(!in_array($actualFileExt, $allowedExt)){
      return "Files of this type cannot be uploaded";
    }
    else {
      $this->ansAttr['ext'] = $actualFileExt;
      if($fileError != 0){
        return "There's some error in uploading";
      }
      else {
        if($fileSize > 1000000){
          return "Size of file is too large";
        }
        else {
          return true;
        }
      }
    }  
  }
}

//move file from temp dir to uploads
public function moveFile($file){
  $fileName = uniqid('', true) . '.' . $this->ansAttr['ext'];

  $target = $_SERVER['DOCUMENT_ROOT'].'/form builder/uploads/'.$fileName;
  move_uploaded_file($file['tmp_name'], $target);
  
  $this->setAnswer($target);
}

public function setAttr(){

  $slug = "answer".$this->id;
  $this->ansAttr['id'] = $slug;
  $this->ansAttr['name'] = $slug;
  array_push($this->ansAttr['class'],"form-control","border-bottom");
}

public function getAttr($key){
  return $this->ansAttr[$key];
}

public function getAnswer(){
  return $this->answer;
}
}
?>