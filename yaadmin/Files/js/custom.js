// graph color schemes

var color = [
	["#6fb9e8", "#ec8526", "#9dc453", "#ddd74c"], // default
	["#c9e054", "#eab19d", "#e05461", "#b454e0"], // light
	["#b4b280", "#dd9473", "#7fdd73", "#7396dd"], // washy
	["#707ABD", "#833607", "#94A34C", "#FFCF2E"], // marine
	["#8ED915", "#0F5BBD", "#00AA58", "#E74B16"] // primary
];
var defaultColorScheme = color[0];

$(document).ready(function() {
	/* setup navigation, content boxes, etc... */
	$(window).load(Yaadmin.setup);
	
	// GA graph init
	if($("#placeholder").length > 0) $("#placeholder").ga();
	
	// load prettyPhoto and syntaxHighlighter plugin
	$.rloader([
		{type:'js',src:'js/jquery.prettyPhoto.js', callback:function(){
			$("a[rel^=prettyPhoto]").prettyPhoto({theme:'light_rounded'});
		}},
		{type: 'js', src: 'modules/syntax-highlighter/js/jquery.syntaxhighlighter.min.js', callback: function(){
			$.SyntaxHighlighter.init({
				'prettifyBaseUrl': 'modules/syntax-highlighter/prettify',
				'baseUrl': 'modules/syntax-highlighter'
			});
		}}
	]);
	
	// validate form on keyup and submit
	var validator = $("#sampleform").validate({
		rules: {
			firstname: "required",
			lastname: "required",
			username: {
				required: true,
				minlength: 2
			},
			password: {
				required: true,
				minlength: 5
			},
			password_confirm: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			email: {
				required: true,
				email: true
			},
			dateformat: "required",
			terms: "required"
		},
		messages: {
			firstname: "Enter your firstname",
			lastname: "Enter your lastname",
			username: {
				required: "Enter a username",
				minlength: jQuery.format("Enter at least {0} characters")
			},
			password: {
				required: "Provide a password",
				rangelength: jQuery.format("Enter at least {0} characters")
			},
			password_confirm: {
				required: "Repeat your password",
				minlength: jQuery.format("Enter at least {0} characters"),
				equalTo: "Enter the same password as above"
			},
			email: {
				required: "Please enter a valid email address",
				minlength: "Please enter a valid email address"
			},
			dateformat: "Choose your preferred dateformat",
			terms: " "
		},
		// the errorPlacement has to take the layout into account
		errorPlacement: function(error, element) {
			note = element.next("span.note");
			if(note.length > 0) note.addClass("error").text(error.text());
			else element.after('<span class="note error">'+error.text()+'</span>');
			if($.trim(error.text()).length == 0) element.parent().find("span.note").remove();
		},
		// specifying a submitHandler prevents the default submit, good for the demo
		submitHandler: function() {
			alert("Data submitted!");
		},
		// set new class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.html("&nbsp;").addClass("ok");
		}
	});
	
	// code preview
	$("a[rel=showInputCode]").each(function(){
		$(this).parents("div.line").find("pre.code").hide();
	}).toggle(function(){
		$(this).text("Hide code").parents("div.line").find("pre.code").show();
		return false;
	},function(){
		$(this).text("Show code").parents("div.line").find("pre.code").hide();
		return false;
	});
	
	// markitUp wysiwyg editor init
	if($("#markitUp").length > 0) $.rloader([
		{ type: 'css', src: 'modules/markitup/skins/markitup/style.css' },
		{ type: 'css', src: 'modules/markitup/sets/default/style.css' },
		{ type: 'js', src: 'modules/markitup/jquery.markitup.js' },
		{ type: 'js', src: 'modules/markitup/sets/default/set.js', callback: function(){
			$('#markitUp').markItUp(mySettings);
		} }
	]);
	
	// jquery wysiwyg init
	if($("#wysiwyg").length > 0) $.rloader({
		type: 'js', 
		src: 'js/jquery.wysiwyg.js', 
		callback: function(){
			$('#wysiwyg').wysiwyg();
		}
	});
	
	// flot examples init
	if($("#placeholder_demo").length > 0) $.rloader({
		type: 'js', 
		src: 'js/flot_examples.js'
	});
	
	// dataTable init
	if($("#dt_example").length > 0) $.rloader([
		{ type: 'css', src: 'modules/datatables/css/demo_table_jui.css' },
		{ type: 'js', src: 'modules/datatables/js/jquery.dataTables.js', callback: function(){
			$('#dt_example').dataTable({
				"bJQueryUI": true,
				"sPaginationType": "full_numbers"
			});
		} }
	]);
	
	// centering caption on the picture
	$(window).load(function(){
		$("div.gallery:not(.type2) > .item").each(function(){
			$caption = $(this).find("div.caption");
			$caption.css("top", function(){
				return (($(this).parent().innerHeight()/2) - ($(this).outerHeight()/2)) +"px";
			}).css("left", function(){
				return (($(this).parent().innerWidth()/2) - ($(this).outerWidth()/2)) +"px";
			}).find("li").css("opacity", 0.7).hover(function(){
				$(this).stop().animate({ opacity: 1 }, 250);
			},function(){
				$(this).stop().animate({ opacity: 0.7 }, 250);
			});
		});
	});
	
	// Gallery effect
	$("div.gallery:not(.type2) > .item *").mouseover(function(e){
		if($(e.target).is("img") || $(this).closest(".caption").is("div")){
			$(this).parents(".item").find("div.caption").stop().fadeTo(250, 1);
		}
	}).mouseout(function(e){
		if($(e.target).is("img") || $(this).closest(".caption").is("div")){
			$(this).parents(".item").find("div.caption").stop().fadeTo(250, 0);
		}
	});
	
	// Gallery type 2 animation effect
	$("div.gallery.type2 > .item").mouseover(function(e){
		$(this).closest(".item").find("div.caption").stop().animate({ opacity: 1, top: "-26px"}, 250, function(){
			$(this).css("z-index", 1);
		});
	}).mouseout(function(e){
		if(!$(e.target).closest(".caption").is("div")){
			$(this).find("div.caption").stop().animate({ opacity: 0, top: "3px" }, 250, function(){
				$(this).css("z-index", -1);
			});
		}
	});

	// Gallery type 3 effect
	$("ul.gallery li a, a.zoom").each(function(){
		$(this).prepend('<span class="caption"></span>');
	});
	$("ul.gallery li, a.zoom").live("mouseover", function(){
		$(this).find("span.caption").stop().show().animate({opacity: .6}, 250);
	}).live("mouseout", function(){
		$(this).find("span.caption").stop().animate({opacity: 0}, 250, function(){$(this).hide();});
	});
	
	// Collapse and expand the blocks
	$("div.block.collapsible > h3").click(function(){
		if($(this).parent().hasClass("closed")){
			$(this).next(".bcontent").slideDown("fast").parent().removeClass("closed");
		}else{
			$(this).next(".bcontent").slideUp("fast").parent().addClass("closed");
		}
	});
	
	// If there is an element with id="filemanager" then connect via elFinder rloader
	if($("#filemanager").length > 0) $.rloader([
		{type:'css',src:'css/smoothness/jquery-ui-1.8.7.custom.css'},
		{type:'css',src:'modules/elfinder/css/elfinder.css'},
		{type:'js',src:'modules/elfinder/js/elFinder.js'},
		{type:'js',src:'modules/elfinder/js/elFinder.view.js'},
		{type:'js',src:'modules/elfinder/js/elFinder.ui.js'},
		{type:'js',src:'modules/elfinder/js/elFinder.quickLook.js'},
		{type:'js',src:'modules/elfinder/js/elFinder.eventsManager.js', callback:function(){
		//{type:'js',src:'modules/elfinder/js/i18n/elfinder.ru.js', callback:function(){}, // Russian language
			$("#filemanager").elfinder({
				url : 'modules/elfinder/connectors/php/connector.php',
				lang : 'ru',
				docked : true,
				editorCallback : function(url) { window.console.log(url) },
				closeOnEditorCallback : false,
				selectMultiple : true,
				dialog : {
					title : 'File manager',
					height : 500
				}
			});
		}}
	]);
	
	
	//make some charts
	$("table[rel=visualize]").visualize({width: $('#visualize_demo').width(), colors: defaultColorScheme}).appendTo('#visualize_demo');
	$("table[rel=visualize]").visualize({width: $('#visualize_demo2').width(), type: 'pie', height: 200, pieMargin: 10, title: '2009 Total Sales by Individual', colors: defaultColorScheme}).appendTo('#visualize_demo2');	
	$("table[rel=visualize]").visualize({width: $('#visualize_demo3').width(), type: 'line', lineWeight: 2, colors: defaultColorScheme}).appendTo('#visualize_demo3');
	$("table[rel=visualize]").visualize({width: $('#visualize_demo4').width(), type: 'area', lineWeight: 2, colors: defaultColorScheme}).appendTo('#visualize_demo4');
	
	initStats();
	
});

/* jquery visualize function 
@index index color scheme of the array color 0...4
*/
function visualize(type, index){
	index = index || defaultColorScheme;
	// remove all graphs
	//if($('div.visualize').length > 0) $('.visualize').remove();
	$('table.graph').each(function(){

		if($(this).attr('rel')) type = $(this).attr('rel');
		$(this).hide().visualize({
			type: type,
			width: $('#visualize').width() - 40 +"px",
			height: "150px",
			lineWeight: 2,
			colors: index
		}).appendTo('#visualize').trigger('visualizeRefresh');
	});
}

function getStats(data){
	if($.isArray(data)){
		var thead = '<thead><tr><td></td>{%ths%}</tr></thead>';
		var tbody = '<tbody><tr><th scope="row">Visits</th>{%tds%}</tr><tr><th scope="row">Pageviews</th>{%tds2%}</tr></tbody>';
		var th = '';
		var td = '';
		var td2 = '';
		
		$.each(data, function(index, value){
			if(index%7==0) th += '<th scope="col">'+value[0]+'</th>';
			else th += '<th scope="col"></th>';
			td += '<td>'+value[1]+'</td>';
			td2 += '<td>'+value[2]+'</td>';
		});
		thead = thead.replace("{%ths%}", th);
		tbody = tbody.replace("{%tds%}", td).replace("{%tds2%}", td2);
		var table = $("<table/>", { 'class': 'graph', rel: 'line', html: thead + tbody }).appendTo(visualizeholder);
		visualize("area", defaultColorScheme);
	}else{
		visualizeholder.html('<div class="error">Error! <a href="#" onclick="initStats();return false;">Try again</a></div>');
		$(".error", visualizeholder).css("lineHeight", visualizeholder.height()+'px');
	}
}

function initStats(){
	// loading...
	visualizeholder = $("#visualize").empty();
	var loading = $('<div class="loading">Loading...</div>').appendTo(visualizeholder);
	var ltop = (visualizeholder.height()/2-loading.height()/2)+'px';
	var lleft = (visualizeholder.width()/2-loading.outerWidth()/2)+'px';
	loading.css({top:ltop,left:lleft}).show();
	
	$.post("php/ajax.php", { get: 'statistic', type: 'visualize' }, getStats, 'json');
}

function removeItem(e){
	$item = $(e).parents(".item");
	$item.animate({ opacity: 0 }, 250, function(){
		$(this).animate({ width: 0 }, 250, function(){
			$(this).remove();
		});
	});
	return false;
}