/*Переменные для регистрации*/
var signUp = document.querySelector(".registration .sign-up-btn");
var regWindow = document.querySelector(".sign-up-window");
var regWindowClose = regWindow.querySelector(".close-sign-up-window");
var regPassword = regWindow.querySelector("[name=password]");
var regLogin = regWindow.querySelector("[name=login]");
var regEmail = regWindow.querySelector("[name=email]");
var regForm = regWindow.querySelector("form");


signUp.addEventListener("click", function(event) {
	event.preventDefault();
	regWindow.classList.remove("no-display");
	regWindow.classList.add("show");
	if(document.querySelector(".login-window").classList.contains("show")){
		document.querySelector(".login-window").classList.remove("show")
	};
	if(!document.querySelector(".login-window").classList.contains("no-display")){
		document.querySelector(".login-window").classList.add("no-display")
	};	
});
regWindowClose.addEventListener("click", function(event) {
	event.preventDefault();
	regPassword.setAttribute("type", "text");
	regPassword.value = "Пароль";
	regLogin.value = "Логин";
	regEmail.value = "Почта";
	regWindow.classList.add("no-display");
	regWindow.classList.remove("show");
	if(regPassword.classList.contains("required")) {
		regPassword.classList.remove("required")
	};
	if(regLogin.classList.contains("required")) {
		regLogin.classList.remove("required")
	};
	if(regEmail.classList.contains("required")) {
		regEmail.classList.remove("required")
	};
});
regPassword.addEventListener("focus", function(event){
	regPassword.setAttribute("type","password");
	regPassword.value = "";
	if(regPassword.classList.contains("required")) {
		regPassword.classList.remove("required")
	};
});
regPassword.addEventListener("blur", function(event){
	if(regPassword.value == "") {
		regPassword.value = "Пароль";
		regPassword.setAttribute("type", "text");
	};
});
regLogin.addEventListener("blur", function(event){
	if(regLogin.value == "") {
		regLogin.value = "Логин";
	};
});
regLogin.addEventListener("focus", function(event) {
	regLogin.value= "";
	if(regLogin.classList.contains("required")) {
		regLogin.classList.remove("required")
	};
});
regEmail.addEventListener("blur", function(event){
	if(regEmail.value == ""){
		regEmail.value = "Почта";
	};
});
regEmail.addEventListener("focus", function(event){
	regEmail.value="";
	if(regEmail.classList.contains("required")){
		regEmail.classList.remove("required")
	};
});
regForm.addEventListener("submit", function(event) {
	if (regLogin.value === "Логин") {
		event.preventDefault();
		regLogin.classList.add("required");
	};
	if (regPassword.value === "Пароль") {
		event.preventDefault();
		regPassword.classList.add("required");
	};
	if (regEmail.value === "Почта") {
		event.preventDefault();
		regEmail.classList.add("required");
	};
});
