var register = document.querySelector("#signUp");
var login = document.querySelector("#signIn");
var showRegister = document.querySelector("#registerShow");
var showLogin = document.querySelector("#loginShow");
var hidden = document.querySelector(".hidden");

showRegister.addEventListener("click",function(){
	register.classList.remove("hidden");
	login.classList.add("hidden");
});

showLogin.addEventListener("click",function(){
	register.classList.add("hidden");
	login.classList.remove("hidden");
});

