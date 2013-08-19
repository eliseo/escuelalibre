$(document).ready(function() {
	html = '<div id="toolbar">\
	<div class="toolbar-wrapper">\
		<header>Options <a class="arrow" href="#">Minimize</a></header>\
		<div class="toolbar-content">\
			<div class="form">\
				<div class="line">\
					<h5 class="marginBottom-5">Choose menu BG color:</h5><hr/>\
					<div id="colorSelector_menubg" class="colorSelector float-left"><div style="background-color:#09729E;"></div></div> \
					<input type="text" class="text" size="20" value="#09729E" name="menubg" data-color="#09729E" /> \
					<div class="clearfix"></div>\
					<div id="custombodybg" class="hidden">\
						<div id="colorSelector_bodybg" class="colorSelector float-left"><div style="background-color:#1c1c1c;"></div></div> \
						<input type="text" class="text" size="20" value="#1c1c1c" name="bodybg" data-color="#1c1c1c" />\
					</div>\
				</div>\
				<div class="line styles">\
					<h5 class="marginBottom-5">Styles:</h5><hr/>\
					<ul>\
						<li><a href="#" data-bgwrapper="dark" data-bgtabs="#09719e" data-bgcolor="transparent" data-bgimage="images/bg/bg-light.jpg">Default</a></li>\
						<li><a href="#" data-bgwrapper="dark" data-bgtabs="#09719e" data-bgcolor="transparent" data-bgimage="images/bg/bg-yellow.jpg">Cube yellow</a></li>\
						<li><a href="#" data-bgwrapper="dark" data-bgtabs="#09719e" data-bgcolor="transparent" data-bgimage="images/bg/bg-gray.jpg">Cube gray</a></li>\
						<li><a href="#" data-bgwrapper="light" data-bgtabs="#09719e" data-bgcolor="transparent" data-bgimage="images/bg/bg-dark.jpg">Cube dark</a></li>\
						<li style="margin-right:0;"><a href="#" data-bgwrapper="dark" data-bgtabs="#5c913d" data-bgcolor="transparent" data-bgimage="images/bg/bg-wood.png">Wood</a></li>\
						<li><a href="#" data-bgwrapper="light" data-bgtabs="#595959" data-bgcolor="transparent" data-bgimage="images/bg/bg-ventisei.gif">Ventisei</a></li>\
						<li><a href="#" data-bgwrapper="light" data-bgtabs="#e34c00" data-bgcolor="transparent" data-bgimage="images/bg/bg-jeans.png">Jeans</a></li>\
						<li class="current"><a href="#" data-bgwrapper="dark" data-bgtabs="#d40808" data-bgcolor="transparent" data-bgimage="images/bg/bg-whitejeans.png">White jeans</a></li>\
						<li><a href="#" data-bgwrapper="dark" data-bgtabs="#45adad" data-bgcolor="transparent" data-bgimage="images/bg/bg-notebook.png">Notebook</a></li>\
						<li style="margin-right:0;"><a href="#" data-bgwrapper="light" data-bgtabs="#09719e" data-bgcolor="#1c1c1c" data-bgimage="images/bg/bg-noise.png">Noise</a></li>\
						<li><a href="#" data-bgwrapper="dark" data-bgtabs="#d92e2e" data-bgcolor="transparent" data-bgimage="images/bg/santa.png">Cristmass</a></li>\
						<li><a href="#" data-bgwrapper="dark" data-bgtabs="#ff0000" data-bgcolor="transparent" data-bgimage="images/bg/papurri.png">Papurri</a></li>\
					</ul>\
				</div>\
				<div class="clearfix"></div>\
				<div align="center" class="line">\
					<a class="button" href="#csscode" rel="prettyPhoto[code]"><span><span>Show CSS code</span></span></a>\
					<div id="csscode" class="hidden"><pre class="code language-css"></pre></div>\
				</div>\
			</div>\
		</div>\
		<div class="clearfix"></div>\
	</div>';
	//if($.browser.msie && parseFloat($.browser.version) < 8) return false;
	//else 
	$("body").append(html);
	if($.browser.opera) $("a.button > span > span").css('marginRight', '25px');
	
	if(true) $.rloader([
		{type:'js',src:'js/jquery.prettyPhoto.js', callback:function(){
			$("a[rel^=prettyPhoto]").prettyPhoto({theme:'light_rounded'});
		}},
		{type: 'js', src: 'modules/syntax-highlighter/js/jquery.syntaxhighlighter.min.js'},
		{type:'css',src:'css/colorpicker.css'},
		{type:'js',src:'js/colorpicker.js',callback:function(){
			$('#colorSelector_menubg').ColorPicker({
				color: '#09729E',
				onShow: cpshow,
				onHide: cphide,
				onChange: function (hsb, hex, rgb) {
					$('#container-auth header').css('backgroundColor', '#' + hex);
					$('#colorSelector_menubg div').css('backgroundColor', '#' + hex);
					//var text_hsb = $.RGBToHSB($.RGB($("#userpanel").css('color')));
					//text_hsb.b = Math.abs((hsb.b+50)%100);
					$(this).parent().find(":text[name=menubg]").val('#' + hex).data("color", '#' + hex);
				}
			});
			$('#colorSelector_bodybg').ColorPicker({
				color: '#1c1c1c',
				onShow: cpshow,
				onHide: cphide,
				onChange: function (hsb, hex, rgb) {
					$("body").css('backgroundColor', '#'+hex);
					$('#colorSelector_bodybg div').css('backgroundColor', '#' + hex);
					$(this).parent().find(":text[name=bodybg]").val('#' + hex).data("color", '#' + hex);
				}
			});
		}}
	]);
	//$("#toolbar .styles ul li:eq(4), #toolbar .styles ul li:eq(9)").css("marginRight", 0);
	$("#toolbar .styles > ul > li > a").each(function(){
		$(this).css("backgroundImage", "url("+$(this).data("bgimage")+")");
	});
	$("#toolbar .styles > ul").delegate("li > a", "click", function(){
		$(this).parent().addClass("current").siblings().removeClass("current");
		bgtabs = $(this).data("bgtabs");
		$('#colorSelector_menubg').ColorPickerSetColor(bgtabs).parent().find(".text[name=menubg]").val(bgtabs).data("color", bgtabs);
		
		$('#colorSelector_menubg div').css('backgroundColor', bgtabs);
		if($(this).data("bgcolor")=='transparent') $("#custombodybg").hide();
		else $("#custombodybg").show();
		setCode();
		return false;
	});
	$("a[rel^=prettyPhoto]").prettyPhoto({default_width:600,theme:'light_rounded'});
	
	if($.browser.msie && $.browser.version == 7) $("a.button[rel^=prettyPhoto]").unbind("click").find("span span").text("Before upgrade your IE");
	
	setCode();
	
	if($("#toolbar").length > 0){
		ie = $.browser.msie && ($.browser.version == 7 || $.browser.version == 8);
		arrow = (ie) ? $("#toolbar a.arrow") : $("#toolbar header > a.arrow");
		arrow.css("opacity", .7).bind("mouseover", function(){
			$(this).stop().animate({ opacity: 1 }, 250);
		}).bind("mouseout", function(){
			$(this).stop().animate({ opacity: .7 }, 250);
		}).click(function(){
			if($(this).hasClass("up")){
				
				$(this).css("opacity", .7).bind("mouseover", function(){
					$(this).stop().animate({ opacity: 1 }, 250);
				}).bind("mouseout", function(){
					$(this).stop().animate({ opacity: .7 }, 250);
				});
				$("#toolbar").unbind("mouseover mouseout click");
				$(this).removeClass("up");
				if(!ie) $("#toolbar header").removeAttr("style");
				animwidth = $("#toolbar .toolbar-content").width() + 22;
				animheight = $("#toolbar .toolbar-content").outerHeight() + 46;
				//console.log(animheight);
				$("#toolbar .toolbar-wrapper").animate({width: animwidth, minHeight: animheight}, 250, function(){
					$("#toolbar .toolbar-content").fadeIn(250);
				});
				//$("#toolbar .toolbar-content").show("fast", function(){ /*$("#toolbar .toolbar-wrapper").width(function(){ return ($("#toolbar .toolbar-content").width()+22) +"px"; });*/ });
			}else{
				
				$(this).unbind("mouseover mouseout");
				$("#toolbar").bind("mouseover", function(){
					$(this).stop().animate({ opacity: 1 }, 250);
				}).bind("mouseout", function(){
					$(this).stop().animate({ opacity: .7 }, 250);
				}).bind("click", function(){
					arrow.click();
				});
				if(!ie) $("#toolbar header").attr("style", "cursor:pointer;");
				$(this).addClass("up");
				$("#toolbar .toolbar-content").fadeOut(250, function(){
					$("#toolbar .toolbar-wrapper").animate({width: 81, minHeight: 21}, 250);
				});
			}
			
			return false;
		}).click();
	}
});


function cpshow(colpkr) {
	$(colpkr).fadeIn(500);
	return false;
}

function cphide(colpkr) {
	$(colpkr).fadeOut(500);
	setCode();
	return false;
}

function setCode(){
	current = $("#toolbar .styles > ul > li.current > a");
	bgtabs = $("#toolbar .text[name=menubg]").data("color");
	bgcolor = $("#custombodybg").is(":visible") ? $("#toolbar :text[name=bodybg]").data("color") : current.data("bgcolor");
	bgwrapper = current.data("bgwrapper");
	$('body').css("background", bgcolor+" url("+current.data("bgimage")+") 0 0 repeat");
	$('#container-auth header').css('backgroundColor', bgtabs);
	if(bgwrapper == 'light') $("#wrapperbg-auth").css('backgroundColor', 'rgba(255, 255, 255, 0.3)');
	else $("#wrapperbg-auth").css('backgroundColor', 'rgba(0, 0, 0, 0.1)');
	var wrapper = (bgwrapper == 'light') ? '#wrapperbg-auth { background-color: rgba(255, 255, 255, 0.3); }' : '#wrapperbg-auth { background-color: rgba(0, 0, 0, 0.1); }';
	var width = '';
	code = "body#auth-page { background: "+bgcolor+" url('../"+current.data('bgimage')+"') 0 0 repeat; } \n"+width+"#container-auth header { background-color: "+bgtabs+"; } \n"+ wrapper +"\n";
	$("#csscode pre").attr('class', 'code language-js').removeAttr('style').empty().append(code);
	$.SyntaxHighlighter.init({
		'prettifyBaseUrl': 'modules/syntax-highlighter/prettify',
		'baseUrl': 'modules/syntax-highlighter'
	});
}