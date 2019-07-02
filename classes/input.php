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
                             'class' => array());
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
      echo $this->answer;
    }

    public function validateAnswer($answer){
      if($this->answerType == "text"){
          if(!ctype_alpha($answer) || (is_null($answer) && $this->required == true)){
            return "Enter text";
          }
      }
      else if($this->answerType == "number"){
        if(!is_numeric($answer) || (is_null($answer) && $this->required == true)){
          return "Enter numeric values";
        }
      }

      return true;
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