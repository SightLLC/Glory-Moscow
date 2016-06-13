var allOpenButtons = document.querySelectorAll(".js-open-form-button");
var allWindows = document.querySelectorAll(".js-window");
var allInputs = document.querySelectorAll(".js-window .user-info");
var allCloseButtons = document.querySelectorAll(".js-close-form-button");
var allForms = document.querySelectorAll(".js-window form");
var allStatButtons = document.querySelectorAll(".js-stat-form-button");
var allStatWindows = document.querySelectorAll(".js-stat-form-window");
var allResultItems = document.querySelectorAll(".js-open-meeting-window");
var allResultWindows = document.querySelectorAll(".result-item .meeting-choose");
var allSendInvitationBtns = document.querySelectorAll(".send-invitation");
var flag = true;

for (i = 0; i < allStatWindows.length; i++){
	if (allStatWindows[i]) {
		closeOnClickOutside(allStatWindows[i]);
	}
}
for (i = 0; i < allResultItems.length; i++){
	closeOnClickOutside(allResultWindows[i]);
	allResultItems[i].addEventListener("click", function(){
		for (j = 0; j < allResultWindows.length; j++){
			allResultWindows[j].classList.add("no-display");
		}
	});
	windowAppearance(allResultWindows[i], allResultItems[i]);
};
for (i = 0; i < allResultWindows.length; i++){
	closeWindow(allResultWindows[i], allSendInvitationBtns[i]);
	closeAllWindows(allResultWindows,allSendInvitationBtns[i]);
};

if (allStatButtons){
	for(i = 0; i < allStatButtons.length;i++){
		windowAppearance (allStatWindows[i], allStatButtons[i]);
	};
};
if (allCloseButtons){
	for (i = 0; i < allCloseButtons.length; i++){
		closeAllWindows(allWindows, allCloseButtons[i]);
	};	
};
if (allOpenButtons){
	for(i = 0; i < allOpenButtons.length;i++){
		windowAppearance (allWindows[i], allOpenButtons[i]);
	};
};
if(allInputs){
	for (i = 0; i < allInputs.length; i++){
		inputValueErase(allInputs[i]);
	};	
};
if(allForms){
	for (i = 0; i < allForms.length; i++){
		requiredDemand(allForms[i])
	};	
};
function closeOnClickOutside(windowToOperate){
	document.addEventListener("click", function(event){
		var myDiv = document.getElementById(windowToOperate.id);
		if(myDiv){var myDivElements = myDiv.querySelector("*")};
		var conditionOne = event.target.nodeName != "LABEL";
		var conditionTwo = event.target.classList.contains("js-protect-from-auto-closure");
		if (event.target.closest(".js-protect-from-auto-closure")) {
			var conditionThree = event.target.closest(".js-protect-from-auto-closure").classList.contains("js-protect-from-auto-closure")	
		}
		else {
			var conditionThree  = false;
		}
		if(myDiv){var conditionFour = event.target.id != myDiv.id};
		var conditionFive = windowToOperate.classList.contains("no-display");
		if (conditionOne && !conditionTwo && !conditionThree && conditionFour && !conditionFive) 
		{
			windowToOperate.classList.add("no-display");
		}
		})
};
function closeAllWindows(windowToOperate, closeButton){
	closeButton.addEventListener("click", function(event) {
		for (j = 0; j < windowToOperate.length; j++){
			if (!windowToOperate[j].classList.contains("no-display")){
				windowToOperate[j].classList.add("no-display");
				windowToOperate[j].classList.remove("required");
			};
		};
		flag = true;
		
	});
};
function windowAppearance (windowToOperate, openButton){
	openButton.addEventListener("click", function(event) {
		event.preventDefault();
		event.stopPropagation();
		if (windowToOperate.classList.contains("no-display") && event.target.nodeName != "BUTTON"){
			windowToOperate.classList.remove("no-display");
		};
		flag=false;
	});
};
function closeWindow(windowToOperate, closeButton){
	closeButton.addEventListener("click", function(){
		if(!windowToOperate.classList.contains("no-display")){
			windowToOperate.classList.add("no-display");
		}
	});
};
function inputValueErase(inputToOperate){
	inputToOperate.addEventListener("focus", function(event) {
		event.preventDefault;
		inputToOperate.value="";
		if(inputToOperate.dataset.name === "Пароль"){
			inputToOperate.type = "password";
		};
	});
	inputToOperate.addEventListener("blur", function(event){
		event.preventDefault;
		if (inputToOperate.value === ""){
			inputToOperate.value = inputToOperate.dataset.name;
			if(inputToOperate.dataset.name === "Пароль"){
				inputToOperate.type = "text";
			};	
		};
	});
};
function requiredDemand (appliedForm){
	var windowFields = appliedForm.querySelectorAll(".user-info");
	appliedForm.addEventListener("submit", function(event){
		for (k = 0; k < windowFields.length; k++){
			if (windowFields[k].value === windowFields[k].dataset.name){
				event.preventDefault();
				appliedForm.parentNode.classList.add("required");
			};
		};
	});
}