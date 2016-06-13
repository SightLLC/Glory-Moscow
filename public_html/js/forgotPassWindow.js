/*Переменные для забытого пароля*/
var forgotPass = document.querySelector(".remember-password");
var FPWindow = document.querySelector(".login-window");
var FPWindowClose = FPWindow.querySelector(".close-login-window");
var FPEmail = FPWindow.querySelector("[name=email]");
var FPForm = FPWindow.querySelector("form");


forgotPass.addEventListener("click", function(event) {
	event.preventDefault();
	FPWindow.classList.remove("no-display");
	FPWindow.classList.add("show");
	if(document.querySelector(".sign-up-window").classList.contains("show")){
		document.querySelector(".sign-up-window").classList.remove("show")
	};
	if(!document.querySelector(".sign-up-window").classList.contains("no-display")){
		document.querySelector(".sign-up-window").classList.add("no-display")
	};	
});
FPWindowClose.addEventListener("click", function(event) {
	event.preventDefault();
	password.setAttribute("type", "text");
	password.value = "Пароль";
	login.value = "Логин";
	FPWindow.classList.add("no-display");
	FPWindow.classList.remove("show");
	if(password.classList.contains("required")) {
		password.classList.remove("required")
	};
	if(login.classList.contains("required")) {
		login.classList.remove("required")
	};			
});
password.addEventListener("focus", function(event){
	password.setAttribute("type","password");
	password.value = "";
	if(password.classList.contains("required")) {
		password.classList.remove("required")
	};
});
password.addEventListener("blur", function(event){
	if(password.value == "") {
		password.value = "Пароль";
		password.setAttribute("type", "text");
	};
});
login.addEventListener("blur", function(event){
	if(login.value == "") {
		login.value = "Логин";
	};
});
login.addEventListener("focus", function(event) {
	login.value= "";
	if(login.classList.contains("required")) {
		login.classList.remove("required")
	};
});
form.addEventListener("submit", function(event) {
	if (login.value === "Логин") {
		event.preventDefault();
		login.classList.add("required");
	};
	if (password.value === "Пароль") {
		event.preventDefault();
		password.classList.add("required");
	};	
});
