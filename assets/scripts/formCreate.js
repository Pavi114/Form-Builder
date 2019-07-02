var inputType = document.querySelector("#inputType");
var typeButton = document.querySelector("#typeButton");
var form = document.querySelector("#form");
var sendForm = document.querySelector("#sendForm");
var outerDiv;
//array to store names of form elements
var nameArray = [];
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
 //create delete option for each form element
 createDelete(){
  var button = document.createElement("button");
  button.type = "button";
  button.innerHTML = '<i class="fas fa-trash"></i>';
   //setting id based on anstype and question num of question
  button.setAttribute("id",this.ansType + addInput.questionNum);
  button.classList.add("btn");
  button.onclick = function(){
                     //get name of form element to be deleted
                      var name = "answer" + this.id;
                      var search = "input[name="+ name + "]";
                      //remove that name from nameArray
                      nameArray = nameArray.filter(function(value,index,arr){
                        return name != value;
                      })
                      document.querySelector(search).setAttribute("name", "null");
                       this.parentNode.style.display = "none";
                    };
  outerDiv.appendChild(button);
  button.style.position = "absolute";
  button.style.bottom = "18px";
  button.style.right = "10px";
   //append outer div to form
  form.insertBefore(outerDiv,sendForm.parentNode);
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
var label = document.createElement("LABEL");
label.innerHTML = "Required";
label.setAttribute("for","checkBox");
label.style.margin = "0.5rem";
div.appendChild(label);
div.appendChild(checkBox);
outerDiv.appendChild(div);
}

}
//static member of class
addInput.questionNum = 1;
//add on click
typeButton.addEventListener("click",function(){
  //get value of type of ans chosen
  var radio = document.querySelector('input[name="type"]:checked');
  var inputType = radio.value;
  if(inputType == "text" || inputType == "number"){
    var add = new addInput("text",inputType);
    add.createQuestion();
    add.createTextElements();
    add.createDelete();
    add.createRequired();
    addInput.updateQuestionNum();
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
      alert("Plaese enter all questions");
     }
  }
});
