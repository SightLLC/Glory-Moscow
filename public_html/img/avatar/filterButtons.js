var filterButton = document.querySelectorAll(".I-want .btn");
var filterButtonInput = document.querySelectorAll(".I-want .btn input");
var meetingButton = document.querySelectorAll(".meeting-var-item");
var meetingButtoninput = document.querySelectorAll(".meeting-var-item input");

for (i = 0; i < meetingButton.length; i++){
	simpleFilterToggle(meetingButton[i], meetingButtoninput[i])
}
for(i = 0; i < filterButton.length; i++){
	simpleFilterToggle(filterButton[i], filterButtonInput[i]);
};
function simpleFilterToggle(iWantControl, iWantControlInput){
	iWantControl.addEventListener("click", function(event) {
		event.preventDefault();
		if (iWantControlInput.checked) {
			iWantControl.classList.remove("active");
			iWantControlInput.checked = false;
		}
		else {
			iWantControl.classList.add("active");
			iWantControlInput.checked = true;
		}
	});
};