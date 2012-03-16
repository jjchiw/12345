$('document').ready(function(){
	
	//Esconder los grupos y ultima modificacion
	$(".groups, .update").css('opacity',0.35);

	
	//Agregar comportamiento para mostrarlos
	
	$("div.items .idea").hover(
		function () {
			$(this).find(".groups, .update").animate({opacity:1}, 500)
		  },
		  function () {
			  $(this).find(".groups, .update").animate({opacity:0.35}, 200)
		  }
	);
});