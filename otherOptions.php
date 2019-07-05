<?php
session_start();
$submissionsPerUser = 0;
$timeForm = 0;
if(!empty($_POST['submissionCount'])){
	$submissionsPerUser = $_POST['submissionCount'];
}
if(!empty($_POST['time'])){
	$timeForm = $_POST['time'];
}
$_SESSION['submissionCount'] = $submissionsPerUser;
$_SESSION['timeForm'] = $timeForm;

$data = array('subCount' => $_SESSION['submissionCount'] ,
              'timeCount' => $_SESSION['timeForm'] );

          echo json_encode($data);
          return true;    
?>