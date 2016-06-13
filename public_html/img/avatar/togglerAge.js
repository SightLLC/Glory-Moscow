var toggleAgeLeft = document.querySelector(".age .toggle-left");
var toggleAgeRight = document.querySelector(".age .toggle-right");
var minAge = document.querySelector(".age .toggle-left .toggle-label");
var maxAge = document.querySelector(".age .toggle-right .toggle-label");
var selectedRangeAge = document.querySelector(".age .selected-range");
var barAge = document.querySelector(".age .bar");
var ageBlock = document.querySelector(".age.filter-toggle");
var flagAgeLeft = false;
var flagAgeRight = false;
var maxBarAge = 200;
var minBarAge = 0;
var leftInputAge = document.querySelector("[name=age-left-toggle]");
var rightInputAge = document.querySelector("[name=age-right-toggle]");

toggleAgeLeft.addEventListener("mousedown", function(event) {
	event.preventDefault();
	flagAgeLeft = true;
	maxBarAge = selectedRangeAge.offsetWidth + selectedRangeAge.offsetLeft;
}, false);
toggleAgeLeft.addEventListener("mouseup", function(event){
	event.preventDefault();
	flagAgeLeft = false;
}, false);
ageBlock.addEventListener("mousemove", function(event){
	var resAge = event.pageX - this.offsetLeft;
	if (flagAgeLeft == true && (resAge > 0) && (resAge < barAge.offsetWidth)) {
		toggleAgeLeft.style.left = (resAge - 6) + "px";
		selectedRangeAge.style.left = resAge + "px";
		selectedRangeAge.style.width = (maxBarAge - resAge) + "px";
		minAge.innerHTML = 18 + Math.round(resAge/5);
		leftInputAge.value = 18 + Math.round(resAge/5);
	}
},false);

toggleAgeRight.addEventListener("mousedown", function(event) {
	event.preventDefault();
	flagAgeRight = true;
	minBarAge = selectedRangeAge.offsetLeft;
}, false);
toggleAgeRight.addEventListener("mouseup", function(event){
	event.preventDefault();
	flagAgeRight = false;
}, false);
ageBlock.addEventListener("mousemove", function(event){
	var resAge = event.pageX - this.offsetLeft;
	if (flagAgeRight == true && (resAge > 0) && (resAge < barAge.offsetWidth)) {
		toggleAgeRight.style.left = (resAge - 6) + "px";
		selectedRangeAge.style.width = (resAge - minBarAge) + "px";
		maxAge.innerHTML = 18 + Math.round(resAge/5);
		rightInputAge.value = 18 + Math.round(resAge/5);
	}
},false);