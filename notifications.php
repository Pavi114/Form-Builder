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
			$time = time();
			$diff = $time - strtotime($row['date_filled']);
			$suf = '';
			if(7*24*60*60 < $diff){
				$suf = 'w';
				$diff = (int)($diff/(7*24*60*60));
			}
			else
				if(24*60*60 < $diff) {
					$suf = 'd';
					$diff = (int)($diff/(24*60*60));
				}
				else 
					if(60*60 < $diff){
						$suf = 'h';
						$diff = (int)($diff/(60*60));
					}
					else if(60 < $diff){
						$suf = 'm';
						$diff = (int)($diff/60);
					}
					else {
						$suf = 's';
						$diff = (int)$diff;	
					}

				
				$output .= '<div class="dropdown-item">'.$row['message'].'<div style="margin:0;padding:0;text-align:right;font-size:0.7vw;">'.$diff.'<small>'.$suf.'</small></div></div>';

		}
	}
		else {
		//no notifs
			$output .= '<a class="dropdown-item bg-danger">No new notifications</a>';
		}

		echo $output;
	}
	?>