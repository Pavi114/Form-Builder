  //on notif click fetch notifs from db
  var httpRequest = new XMLHttpRequest();
  var user = document.querySelector("#user").innerHTML;

  document.querySelector("#notifs").addEventListener("click",function(){

    httpRequest.onreadystatechange = updatenotif;
    httpRequest.open('POST','notifications.php');
    httpRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    httpRequest.send('users=' + user);
    
  })

  function updatenotif(){
    if(httpRequest.status == 200){
      response = httpRequest.responseText;
      document.querySelector("#notifications").innerHTML = response;
    }
  }