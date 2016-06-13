var meetingsToDelete = document.querySelectorAll(".js-upcoming-meeting");
var meetingFlag = true;

function deleteButtonAppearance (closeWindow) {
	closeWindow.addEventListener("click", function(event) {
		if (!closeWindow.classList.contains("to-be-deleted")){
			closeWindow.classList.add("to-be-deleted");
		}
	})
}
function deleteButtonDisappearance (closeWindow, event){
	document.addEventListener("click", function(event) {
		if (closeWindow.classList.contains("to-be-deleted")) {
			closeWindow.classList.remove("to-be-deleted");
		};
	});
}
for (i = 0; i < meetingsToDelete.length; i++) {
	deleteButtonAppearance(meetingsToDelete[i]);
	deleteButtonDisappearance(meetingsToDelete[i]);
}