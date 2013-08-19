(function($){
	var methods = {
		init : function( options ) { 
			var defaultSettings = {
				file	: 'php/ajax.php',
				params	: {
					get: "statistic"
				},
				loadingText	: 'Loading...',
				lang	: {
					daysOfWeek	: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
					dateformat	: "l, F j, Y", // Wednesday, May 19, 2010
					daysOfWeekShort	: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
					monthFullNames	: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
					visits	: "Visits",
					monthShortNames	: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
				}
			}
			
			if(!$.isFunction($.plot)) return this.each(function(){
				$(this).hide();
			});
			
			var elem;
			settings = $.extend(defaultSettings, options);
			return this.each(function(){
				elem = $(this).empty();
				// loading...
				var loading = $('<div/>', {'class': 'loading', text: settings.loadingText}).appendTo(elem);
				var ltop = (elem.height()/2-loading.height()/2)+'px';
				var lleft = (elem.width()/2-loading.outerWidth()/2)+'px';
				loading.css({top:ltop,left:lleft}).show();
				
				// ajax request
				ajax = $.post(settings.file, settings.params, getStats, 'json');
				elem.ajaxError(function(e, xhr, settings, exception) {
					if (ajax == xhr) {
						elem.html('<div class="error">Error! <a href="#">Try again</a></div>').find("a").click(function(){
							elem.ga("init");
							return false;
						});
						$(".error", elem).css("lineHeight", elem.height()+'px');
					}
				});
				// tips when hover
				var previousPoint = null;
				
				elem.bind("plothover", function (event, pos, item) {
					if (item) {
						if (previousPoint != item.dataIndex) {
							previousPoint = item.dataIndex;
							var date = new Date(item.datapoint[0]);
							var contents = '<span>'+dateformat(date, settings.lang.dateformat)+'</span><p>'+settings.lang.visits+': <strong>'+item.datapoint[1]+'</strong></p>';
							showTooltip(item.pageX, item.pageY, contents);
						}
					} else {
						$("#tooltip").remove();
						previousPoint = null;            
					}
				});
			});
			
			// display tooltips on the graph statistics
			function showTooltip(x, y, contents) {
				$('<div id="tooltip" class="tooltip"><div class="tcont-1"><div class="tcont-2"><div class="tcont-3">' + contents + '</div></div></div></div>').appendTo("body").css( {
					top: y - 20,
					left: x - $("#tooltip").width() - 10
				});
				if((x - $("#tooltip").width()) < elem.offset().left) $("#tooltip").css({left: x + 10}).fadeIn(200);
				else $("#tooltip").fadeIn(200);
			}

			// low-powered like formatting dates 
			function dateformat(date, format){
				return format.replace(/(Y|y|M|F|m|j|D|l|d)/g,
					function($1){
						switch ($1){
							case 'Y': return date.getFullYear();
							case 'y': var f = date.getFullYear()+"";
								return f.substr(2,4);
							case 'F': return settings.lang.monthFullNames[date.getMonth()];
							case 'M': return settings.lang.monthShortNames[date.getMonth()];
							case 'm': return (date.getMonth() < 9 ? '0' : '') + (date.getMonth() + 1);
							case 'j': return date.getDate();
							case 'D': return settings.lang.daysOfWeekShort[date.getDay()];
							case 'l': return settings.lang.daysOfWeek[date.getDay()];
							case 'd': return  (date.getDate() < 10 ? '0' : '') + date.getDate();
						}
					}
				);
			}
			
			// selection weekend on the graph statistics
			function weekendAreas(axes) {
				var markings = [];
				var d = new Date(axes.xaxis.min);
				// go to the first Saturday
				d.setUTCDate(d.getUTCDate() - ((d.getUTCDay() + 1) % 7));
				d.setUTCSeconds(0);
				d.setUTCMinutes(0);
				d.setUTCHours(0);
				var i = d.getTime();
				do {
					// when we don't set yaxis the rectangle automatically
					// extends to infinity upwards and downwards
					//markings.push({ xaxis: { from: i, to: i + 2 * 24 * 60 * 60 * 1000 } });
					i += 7 * 24 * 60 * 60 * 1000;
				} while (i < axes.xaxis.max);
				return markings;
			}
			
			// sending data to build a graphics
			function getStats(data){
				if($.isPlainObject(data)){
					elem.data("stats", data);
					var d = data.stats;
					var options = {
						xaxis: { mode: "time", timeformat: "%d %b", monthNames: settings.lang.monthShortNames, tickSize: [7, "day"] },
						selection: { mode: "xy" },
						lines: { show: true, fill: 0.1, lineWidth: 4 },
						points: { show: true, radius: 4, fillColor: "#ffffff" },
						yaxis: { min: data.min, max: data.max, ticks: data.ticks },
						grid: { markings: weekendAreas, hoverable: true, clickable: true, labelMargin: 10, borderWidth: 1 },
						colors: ["#0077cc"], //639ecb //e03c42 // 9f9f9f // 8dceff
						shadowSize: 0
					};
					var plot = $.plot(elem, [d], options);
					elem.append('<div class="galogo"></div>');
				}
			}
		},
		show : function( ) {  },
		hide : function( ) {  },
		update : function( content ) {  }
	};
	
	$.fn.ga = function( method ) {
		// Method calling logic
		if ( methods[method] ) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.tooltip' );
		}
	};
})(jQuery);