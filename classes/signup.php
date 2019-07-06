<?php 
  //register class
  class Account {

  	private $error;
    private $con;

  	//constructor
  	function __construct($con)
  	{
  		$this->error = array();
  		$this->con = $con;
  	}

  	public function signup($fn,$ln,$un,$pass,$pass2,$email){
  		$this->validateFirstName($fn);
  		$this->validateLastName($ln);
  		$this->validateUsername($un);
  		$this->validatePassword($pass,$pass2);
      $this->validateEmail($email);
  		if(empty($this->error)){
  			return $this->insertDetails($fn,$ln,$un,$pass,$email);	
  		}
  		else {
  			return false;
  		}
  	}
    
    //insert into db
  	private function insertDetails($fn,$ln,$un,$pass,$email){
  		$encrypt = password_hash($pass,PASSWORD_DEFAULT);
      $name = $fn." ".$ln;
      $stmt = $this->con->prepare("INSERT INTO user (name,username,password,email) VALUES (?, ?, ?, ?)");
      $stmt->bind_param('ssss',$name,$un,$encrypt,$email);
      $stmt->execute();
      $stmt->close();
  	    return true;
  	}
    
    //validate first name
  	private function validateFirstName($fn){
  		if(strlen($fn) > 20 || strlen($fn) < 5){
  			array_push($this->error,Constants::$invalidFirstName);
  			return;
  		}
  	}

  	private function validateLastName($ln){
  		if(strlen($ln) > 20 || strlen($ln) < 5){
  			array_push($this->error,Constants::$invalidLastName);
  			return;
  		}
  	}

  	private function validateUsername($un){
  		if(strlen($un) > 20 || strlen($un) < 5){
          array_push($this->error,Constants::$invalidUsername);
          return;
  		}

  		$query = "SELECT * FROM user WHERE username = '$un'";
  		$existingUsername = mysqli_query($this->con,$query);
  		if(mysqli_num_rows($existingUsername) > 0){
  			array_push($this->error,Constants::$existingUsername);
  			return;
  		}
  	}

  	public function validatePassword($pass,$pass2){
  		if(strlen($pass) < 8 || strlen($pass2) < 8){
  			array_push($this->error,Constants::$invalidPasswordLength);
  			return;
  		}
  		if($pass != $pass2){
  			array_push($this->error,Constants::$passwordsDoNotMatch);
  		}
  	}

    public function validateEmail($email){
      if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        array_push($this->error, Constants::$invalidEmail);
      }
    }

  	public function displayError($error){
  		if(!in_array($error,$this->error)){
  		       $error = "";
  		}
      if($error != "")
  		  return '<div style="color:rgb(255,0,0);">'.$error.'</div>';
      
  	}

}
  ?>