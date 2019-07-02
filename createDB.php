<?php
include("initial.php");


        //user table
$query = "CREATE TABLE IF NOT EXISTS user(
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(60) NOT NULL UNIQUE,
name VARCHAR(100) NOT NULL,
password VARCHAR(100) NOT NULL,
email VARCHAR(100) NOT NULL
)";
$create = mysqli_query($con,$query);

  //created form list table
$query = "CREATE TABLE IF NOT EXISTS form_list(
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(30) NOT NULL,
form_title VARCHAR(100) NOT NULL,
form_description text NOT NULL,
url text NOT NULL,
no_of_submissions INT NOT NULL,
submissions_per_user INT NOT NULL
)";
$create = mysqli_query($con,$query);

//question table
$query = "CREATE TABLE IF NOT EXISTS form_questions(
id INT AUTO_INCREMENT PRIMARY KEY,
form_id INT NOT NULL,
question VARCHAR(128) NOT NULL,
required VARCHAR(10) NOT NULL,
answer_type VARCHAR(100) NOT NULL,
FOREIGN KEY (form_id) REFERENCES form_list(id)
)";  

$create = mysqli_query($con,$query);

//answer table
$query = "CREATE TABLE IF NOT EXISTS answers(
id INT AUTO_INCREMENT PRIMARY KEY,
question_id INT NOT NULL,
answer text NOT NULL,
username VARCHAR(60) NOT NULL,
FOREIGN KEY (question_id) REFERENCES form_questions(id)
)";  
$create = mysqli_query($con,$query);		

?>