var toggleLengthLeft = document.querySelector(".length .toggle-left");
var toggleLengthRight = document.querySelector(".length .toggle-right");
var minLength = document.querySelector(".length .toggle-left .toggle-label");
var maxLength = document.querySelector(".length .toggle-right .toggle-label");
var selectedRangeLength = document.querySelector(".length .selected-range");
var barLength = document.querySelector(".length .bar");
var lengthBlock = document.querySelector(".length.filter-toggle");
var flagLengthLeft = false;
var flagLengthRight = false;
var maxBarLength = 200;
var minBarLength = 0;
var leftInputLength = document.querySelector("[name=length-left-toggle]");
var rightInputLength = document.querySelector("[name=length-right-toggle]");

toggleLengthLeft.addEventListener("mousedown", function(event) {
	event.preventDefault();
	flagLengthLeft = true;
	maxBarLength = selectedRangeLength.offsetWidth + selectedRangeLength.offsetLeft;
}, false);
toggleLengthLeft.addEventListener("mouseup", function(event){
	event.preventDefault();
	flagLengthLeft = false;
}, false);
lengthBlock.addEventListener("mousemove", function(event){
	var resLength = event.pageX - this.offsetLeft;
	if (flagLengthLeft == true && (resLength > 0) && (resLength < barLength.offsetWidth)) {
		toggleLengthLeft.style.left = (resLength - 6) + "px";
		selectedRangeLength.style.left = resLength + "px";
		selectedRangeLength.style.width = (maxBarLength - resLength) + "px";
		minLength.innerHTML = 5 + Math.round(resLength/8);
		leftInputLength.value = 5 + Math.round(resLength/8);
	}
},false);

toggleLengthRight.addEventListener("mousedown", function(event) {
	event.preventDefault();
	flagLengthRight = true;
	minBarLength = selectedRangeLength.offsetLeft;
}, false);
toggleLengthRight.addEventListener("mouseup", function(event){
	event.preventDefault();
	flagLengthRight = false;
}, false);
lengthBlock.addEventListener("mousemove", function(event){
	var resLength = event.pageX - this.offsetLeft;
	if (flagLengthRight == true && (resLength > 0) && (resLength < barLength.offsetWidth)) {
		toggleLengthRight.style.left = (resLength - 6) + "px";
		selectedRangeLength.style.width = (resLength - minBarLength) + "px";
		maxLength.innerHTML = 5 + Math.round(resLength/8);
		rightInputLength.value = 5 + Math.round(resLength/8);
	}
},false);