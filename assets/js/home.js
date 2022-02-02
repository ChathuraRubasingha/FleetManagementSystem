$(function(){
	
	$("#autocomplete").focus();

	//var bgImages = ['home-bg1.jpg', 'home-bg2.jpg', 'home-bg3.jpg', 'home-bg4.jpg', 'home-bg5.jpg', 'home-bg6.jpg'];
	var bgImages = ['home-bg1.jpg'];
	$('#homebg').css({'background-image': 'url('+TASTY.baseUrl +'/assets/img/' + bgImages[Math.floor(Math.random() * bgImages.length)] + ')'});


	$('#recent-reviews').easyTicker({
	direction: 'up',
	interval: 4000,
	height: 300,
	visible: 0,
	mousePause: 0
	}); 

	 


});