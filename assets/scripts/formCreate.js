var inputType = document.querySelector("#inputType");
var typeButton = document.querySelector("#typeButton");
var form = document.querySelector("#form");
var sendForm = document.querySelector("#sendForm");
var otherOptions = document.querySelector("#otherOptions");
var modal = document.querySelector("#modal");
var showmodal = document.querySelector("#showmodal"); 
var addRadio = document.querySelector("#addRadio");
var outerDiv;
//array to store names of form elements
var nameArray = [];
var httprequest,response;

class addInput{
  constructor(type,ansType){
    this.type = type; //question type
    this.ansType = ansType;
  }
  //keep track of number of questions added and used for assigning names to form elements
  static updateQuestionNum(){
   this.questionNum += 1;
 }
 //get question num
 static getQuestionNum(){
  return this.questionNum;
}
//add question field to form
createQuestion(){
  //creating div
  outerDiv = document.createElement("DIV");
  outerDiv.classList.add("outer");
  var div = document.createElement("DIV");
  div.classList.add("input-group");
  outerDiv.appendChild(div);
  //create question input
  var question = document.createElement("INPUT");
  //asssign input name of the pattern answer(ans type)(question num) 
  var inputName = "answer"+ this.ansType;
  inputName +=  addInput.questionNum.toString();
  //assign type to input field
  question.type = this.type;
  //push name into array
  nameArray.push(inputName);
  question.setAttribute("id",inputName);
  question.setAttribute("name",inputName);
  question.setAttribute("required","true");
  question.setAttribute("value","Question")
  question.classList.add("form-control");
  question.classList.add("input");
  //append question input to inner div
  div.appendChild(question);

}

createRadio(){
  var div = document.createElement("div");
  outerDiv.insertBefore(div,outerDiv.childNodes[1]);
  div.classList.add("row");
  div.classList.add("m-2");
  var input = document.createElement("INPUT");
   input.type = "radio";  
  input.disabled = "true";
  div.appendChild(input);
  var option = document.createElement("INPUT");
  option.type = "text";
  option.setAttribute("name","answer" + this.ansType + addInput.questionNum + addInput.optionNum);
  option.value = "option";
  option.classList.add("ml-2");
  option.classList.add("rounded");
  div.appendChild(option);
  addInput.optionNum++;
}

createOption(){
  var div = document.createElement("div");
  outerDiv.insertBefore(div,outerDiv.childNodes[1]);
  var option = document.createElement("INPUT");
  option.type = "text";
  option.setAttribute("name","answer" + this.ansType + addInput.questionNum + addInput.optionNum);
  option.value = "option";
  div.appendChild(option);
  addInput.optionNum++;
}

createTextElements(){
  var div = document.createElement("DIV");
  div.classList.add("input-group");
  outerDiv.appendChild(div);
   //create ans field
  var answer = document.createElement("INPUT");
  answer.type = this.ansType;
  answer.setAttribute("placeholder","Answer");
  answer.classList.add("form-control");
  answer.classList.add("input");
  answer.disabled = "true";
  //append ans field to inner div
  div.appendChild(answer);
}

 
//should the user necessarily answer this question while filling the form
createRequired(){
  var div = document.createElement("DIV");
  div.classList.add("input-group");
  div.classList.add("required");
  var checkBox = document.createElement("INPUT");
  checkBox.type = "checkbox";
  checkBox.name = "required" + addInput.questionNum;
  checkBox.value = "true";
  checkBox.style.margin = "0.2rem";
  var label = document.createElement("LABEL");
  label.innerHTML = "Required";
  label.setAttribute("for","checkBox");
  label.style.margin = "0.1rem";
  div.appendChild(label);
  div.appendChild(checkBox);
  outerDiv.appendChild(div);
  form.insertBefore(outerDiv,sendForm.parentNode);
}

}

//add on click
typeButton.addEventListener("click",function(){
     addInput.updateQuestionNum();
  //get value of type of ans chosen
  var radio = document.querySelector('input[name="type"]:checked');
  var inputType = radio.value;
  if(inputType == "text" || inputType == "number"){
    var add = new addInput("text",inputType);
    add.createQuestion();
    add.createTextElements();
    add.createRequired();
  }
  else if(inputType == "file"){
    var add = new addInput("text",inputType);
    add.createQuestion();
    add.createRequired();
  }
  else if(inputType == "mcq"){
    addInput.optionNum = 1;
    var add = new addInput("text",inputType);
    add.createQuestion();
    add.createRadio();
    var addRadio = document.createElement("INPUT");
    addRadio.type = "button";
    addRadio.value = "Add";
    addRadio.classList.add("rounded");
    addRadio.setAttribute("id","addRadio");
    addRadio.onclick = function(){
      if(addInput.optionNum < 5){
        add.createRadio();
      }
      else {
        alert("can't add more than 5 options");
      }
    }
    outerDiv.appendChild(addRadio);
    add.createRequired();
  }

  else if(inputType == "dropdown"){
    addInput.optionNum = 1;
    var add = new addInput("text",inputType);
    add.createQuestion();
    add.createOption();
    var addoption = document.createElement("INPUT");
    addoption.type = "button";
    addoption.value = "Add";
    addoption.classList.add("rounded");

    addoption.setAttribute("id","addoption");
    addoption.onclick = function(){
      if(addInput.optionNum < 5){
        add.createOption();
      }
      else {
        alert("can't add more than 5 options");
      }
    }
    outerDiv.appendChild(addoption);
    add.createRequired();
  }
  //reset radio buttons
  radio.checked = false;
});

//send on click
sendForm.addEventListener("click",function(){
  var title = document.querySelector("#title");
  var description = document.querySelector("#description");
  //title validation
  if(title.value == ""){
    alert("enter valid title");
  }
  //description validation
  if(description.value == ""){
    alert("Enter valid Description");
  }
  //check if all question fields are filled
  for (var i = 0; i < nameArray.length; i++) {
   var type = nameArray[i];
   var question = document.querySelector('#'+ nameArray[i]);
   if(question.value == ""){
    alert("Please enter all questions");
  }
}

})

//ajax call for setting max submissions and validity of form
otherOptions.addEventListener("click",function(){
  var submission = document.querySelector("#submissionCount").value;
  var time = document.querySelector("#timedForm").value;
  if(submission != "" && submission <= 0){
    alert("Enter integers greater than 0");
    return false;
  }
  if(time != "" && time <= 0){
    alert("Enter positive integral time");
    return false;
  }
  httpRequest = new XMLHttpRequest();
  if(!httpRequest){
    alert("cannot create request");
    return false;
  }
  httpRequest.onreadystatechange = setSettings;
  httpRequest.open('POST','otherOptions.php');
  httpRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');
  httpRequest.send('submissionCount=' + submission + '&time=' + time);

})

function setSettings(){
  if(httpRequest.readyState == XMLHttpRequest.DONE){
    if(httpRequest.status == 200){
      var row = document.querySelector("#others");
      response = JSON.parse(httpRequest.responseText);
      document.querySelector(".modal-body").innerHTML += "Successfully Updated";
      if(response.subCount > 0){
        others.innerHTML += '<div class="col-sm-6"><span>Submissions Per User: '+ response.subCount + '</span></div>'; 
      }
      if(response.timeCount > 0){
        others.innerHTML += '<div class="col-sm-6" style="text-align:right"><span>Validity: ' + response.timeCount + '</span></div>';
      }

    }
  }
}


