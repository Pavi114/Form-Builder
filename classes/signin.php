<?php 
  class SignIn {
  	private $con;
  	private $error;
  	private $username;
  	private $password;

  	function __construct($con,$username,$password){
  		$this->con = $con;
  		$this->error = array();
  		$this->username = $username;
  		$this->password = $password;
  	}

  	public function signIn(){

      $this->validate();

      $stmt = $this->con->prepare("SELECT * FROM user WHERE username = ?");
      $stmt->bind_param('s',$this->username);
      $stmt->execute();
      $checkLogin = $stmt->get_result();
      
        if(mysqli_num_rows($checkLogin) == 1){
  	       $row = $checkLogin->fetch_assoc();
  	       $passwordCorrect = password_verify($this->password,$row['password']);
  	       if($passwordCorrect){
  	       	return true;
  	       }
  	       else{
  	       	 array_push($this->error,Constants::$loginFailed);
             return false;
           }
  	    }
  	    else {
  	    	 array_push($this->error,Constants::$loginFailed);
             return false;
  	    }
  	}

  	public function displayError($string){
       if(!in_array($string,$this->error)){
       	$string = "";
       }
      return '<div style="color:rgb(255,0,0);">'.$string.'</div>';
  	}

    private function validate(){
      $this->username = strip_tags($this->username);
      $this->password = strip_tags($this->password);
    }
  }
 ?> 