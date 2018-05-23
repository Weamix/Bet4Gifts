

function resizeHeaderHeight(){ // image aléatoire du background de l'index

	var random = Math.ceil(Math.random()*3);

	document.getElementById("full-background").style.height =  window.innerHeight + "px"; // s'adapte à la taille de l'écran
	document.getElementById("full-background").style.backgroundImage = "url(images/background" + random +".jpg)";



}
