<?php
// include("initial.php");

$con = mysqli_connect('localhost','root','idc1234','delta');
if(isset($_POST['users'])){
	$output = '';
	//get all notifs with the username
	$stmt=$con->prepare("SELECT * FROM notifications WHERE username=? ORDER BY id DESC");
	$stmt->bind_param('s',$_POST['users']);
	$stmt->execute();
	$result = $stmt->get_result();
	if(mysqli_num_rows($result) != 0){
		while ($row = $result->fetch_assoc()) {
			$output .= '<a class="dropdown-item bg-danger">'.$row['message'].'</a>';
		}
	}
	else {
		//no notifs
		$output .= '<a class="dropdown-item bg-danger">No new notifications</a>';
	}

	echo $output;
}
?>