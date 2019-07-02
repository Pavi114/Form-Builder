var inputType = document.querySelector("#inputType");
var typeButton = document.querySelector("#typeButton");
var form = document.querySelector("#form");
var sendForm = document.querySelector("#sendForm");
var outerDiv;
var nameArray = [];
class addInput{
  constructor(type,ansType){
    this.type = type;
    this.ansType = ansType;
  }
  static updateQuestionNum(){
   this.questionNum += 1;
 }

 static getQuestionNum(){
  return this.questionNum;
}

createQuestion(){
  outerDiv = document.createElement("DIV");
  outerDiv.classList.add("outer");
  var div = document.createElement("DIV");
  div.classList.add("input-group");
  outerDiv.appendChild(div);
  var question = document.createElement("INPUT");
  var inputName = "answer"+ this.ansType;
  inputName +=  addInput.questionNum.toString();
  question.type = this.type;
  nameArray.push(inputName);
  question.setAttribute("id",inputName);
  question.setAttribute("name",inputName);
  question.setAttribute("required","true");
  question.setAttribute("value","Question")
  question.classList.add("form-control");
  question.classList.add("input");
  div.appendChild(question);
 }

 createTextElements(){
  var div = document.createElement("DIV");
  div.classList.add("input-group");
  outerDiv.appendChild(div);
  var answer = document.createElement("INPUT");
  answer.type = this.ansType;
  answer.setAttribute("placeholder","Answer");
  answer.classList.add("form-control");
  answer.classList.add("input");
  answer.disabled = "true";
  div.appendChild(answer);
 }

 createDelete(){
  var button = document.createElement("button");
  button.type = "button";
  button.innerHTML = '<i class="fas fa-trash"></i>';
  button.setAttribute("id",this.ansType + addInput.questionNum);
  button.classList.add("btn");
  button.classList.add("btn-danger");
  button.onclick = function(){
                     
                      var name = "answer" + this.id;
                      var search = "input[name="+ name + "]";
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
  form.insertBefore(outerDiv,sendForm.parentNode);
}

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

addInput.questionNum = 1;
typeButton.addEventListener("click",function(){
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
  radio.checked = false;
});


sendForm.addEventListener("click",function(){
  var title = document.querySelector("#title");
  var description = document.querySelector("#description");
  if(title.value == ""){
    alert("enter valid title");
  }
  if(description.value == ""){
    alert("Enter valid Description");
  }
  for (var i = 0; i < nameArray.length; i++) {
     var type = nameArray[i];
     var question = document.querySelector('#'+ nameArray[i]);
     if(question.value == ""){
      alert("Plaese enter all questions");
     }
  }
});