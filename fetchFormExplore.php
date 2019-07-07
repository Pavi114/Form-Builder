<?php
$con = mysqli_connect('localhost','root','idc1234','delta');
$orderBy = 'total_submissions';
$stmt = $con->prepare("SELECT * FROM form_list WHERE status = '1' ORDER BY total_submissions DESC");
$output = ' <tr>
        	<th>TITLE</th>
        	<th>TOTAL SUBMISSIONS</th>
        	<th>DATE OF CREATION</th>
        </tr>';
if(isset($_POST['option'])){
	if($_POST['option'] === '0'){
		$stmt = $con->prepare("SELECT * FROM form_list WHERE status = '1' ORDER BY date_created DESC");
	
	}
	$stmt->execute();
	$result = $stmt->get_result();
    
    if(mysqli_num_rows($result) > 0){
	while($row = $result->fetch_assoc()){
		$output .= '<tr><td>'.$row['form_title'].'</td><td>'.$row['total_submissions'].'</td><td>'.date('Y-m-d',strtotime($row['date_created'])).'</td></tr>';
	}
}
else {
	$output .= "<div>No Forms are open now";
}

	echo $output;
}
    
?>