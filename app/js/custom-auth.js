$(document).ready(function() {
	/* setup navigation, content boxes, etc... */
	$(window).load(Yaadmin.setup);
	
	// login form animation
	$("#wrapperbg-auth").css('top', function(){
		return ($(this).parent().height() - $(this).outerHeight())/2;
	}).css('opacity', 0).show().animate({opacity: 1}, 500, function(){
		$("#page-body-auth").animate({ width: 400 },500,function(){
			h = $("#container-auth .content").css('opacity', 0).outerHeight() + $("#container-auth header").css('opacity', 0).outerHeight();
			$("#container-auth").animate({ minHeight: h },500, function(){
				$(".content, header", this).show().animate({opacity: 1}, 500);
				$(this).removeAttr("style");
			});
			$("#wrapperbg-auth").animate({ top: h/2 },500);
		});
	});

});