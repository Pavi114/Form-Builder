var username = document.querySelector("#username");
var value = username.value;
var userAvail = document.querySelector("#userAvail");
var httpRequest,response;
username.addEventListener("input",function(){
    httpRequest = new XMLHttpRequest();
  if(!httpRequest){
  	alert("cannot create a http request");
  	return false;
  }

  httpRequest.onreadystatechange = checkName;
  httpRequest.open('POST','checkAjax.php');
  httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  httpRequest.send('username='+username.value);
})

function checkName(){
	if(httpRequest.readyState == XMLHttpRequest.DONE){
		if(httpRequest.status == 200){
           response = httpRequest.responseText;
           if(response == "false"){
              userAvail.style.color = "#e10000";
              userAvail.innerHTML = "Unavailable";	
           }
           else if(response == "true"){
            userAvail.style.color = "#076520";
            userAvail.innerHTML = "Available";
           }
           else if(response == "short"){
            userAvail.style.color = "#00004c";
            userAvail.innerHTML = "Username too short";
           }
           else if(response == "long"){
            userAvail.style.color = "#00004c";
            userAvail.innerHTML = "Username too long";
           }
          
		}
	}
}