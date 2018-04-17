

function resizeHeaderHeight(){

	var random = Math.ceil(Math.random()*3);

	document.getElementById("full-background").style.height =  window.innerHeight + "px";
	document.getElementById("full-background").style.backgroundImage = "url(images/background" + random +".jpg)";



}
