  <?php
  if(isset($_POST['sendForm'])){
    //get id of recently inserted form
  $stmt = $con->prepare("SELECT * FROM form_list ORDER BY id DESC LIMIT 1");
  $stmt->execute();

  $getId = $stmt->get_result();
  if(mysqli_num_rows($getId) == 1){
    $row = $getId->fetch_assoc();
    $id = $row['id'];
    
    //create url
   $url = "http://";  
   $url .= "localhost"; 
   $url .= "/form%20builder/fillform.php?id=".$id;  

   //insert url
   $stmt = $con->prepare("UPDATE form_list SET url = ? WHERE id=?");
   $stmt->bind_param('si',$url,$id);
   $stmt->execute();
   $stmt->close();
 } 
 } 
 ?>