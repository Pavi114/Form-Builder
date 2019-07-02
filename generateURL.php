  <?php
  if(isset($_POST['sendForm']) && $_SESSION['questionInsert']){
    //get id of recently inserted form
    $stmt = $con->prepare("SELECT * FROM form_list ORDER BY id DESC LIMIT 1");
    $stmt->execute();

   $getId = $stmt->get_result();
   if(mysqli_num_rows($getId) == 1){
    $row = $getId->fetch_assoc();
    $id = $row['id'];
    $username = $row['username'];
    
    //create url
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
      $url = "https"; 
    }
    else{
     $url = "http";
   }

   $url .= "://";  
   $url .= $_SERVER['HTTP_HOST']; 

   $url .= "/form%20builder/fillform.php?";
   $data = array('id' => $id, 
     'username' => $username);
   $url .= http_build_query($data);  
   
   //insert url
   $stmt = $con->prepare("UPDATE form_list SET url = ? WHERE id=?");
   $stmt->bind_param('si',$url,$id);
   $stmt->execute();
   $stmt->close();

 }
}  
?>