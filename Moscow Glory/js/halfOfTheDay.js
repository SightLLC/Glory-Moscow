var sunButton = document.querySelector(".day-half.am");
var moonButton = document.querySelector(".day-half.pm");
var amHours = document.querySelectorAll(".hour-am");
var pmHours = document.querySelectorAll(".hour-pm");

function dayHalfChange (changeButton, changeHours, buttonToAppear, hoursToAppear){
	changeButton.addEventListener("click", function(event){
		event.preventDefault();
		if ((!changeButton.classList.contains("no-display")) && (buttonToAppear.classList.contains("no-display"))){
			console.log("ok");
			changeButton.classList.add("no-display");
			buttonToAppear.classList.remove("no-display");
			for (i = 0; i < changeHours.length; i++) {
				if ((!changeHours[i].classList.contains("no-display")) && (hoursToAppear[i].classList.contains("no-display")))
				changeHours[i].classList.add("no-display");
				hoursToAppear[i].classList.remove("no-display");
			}			
		}
	})
};
dayHalfChange(sunButton,amHours,moonButton,pmHours)
dayHalfChange(moonButton,pmHours,sunButton,amHours)