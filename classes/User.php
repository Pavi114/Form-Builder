<?php  
  class User {
  	private $con;
  	private $username;

  	function __construct($con,$user){
  		$this->con = $con;
  		$this->username = $user;
  	}

  	public function getUser(){
  		return $this->username;
  	}

    public function getCon(){
      return $this->con;
    }
  }
  ?>