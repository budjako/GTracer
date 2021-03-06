$(document).ready(function() {
	$(".submit-query").click(function get_data(event) {									// submit query made in the drag and drop area
		event.preventDefault();															// prevent default behavior -- redirecting og page after submit
		$("#tablespecs").html("");
		$("#change_here_table").html("").css("height", "");
		$('#chartspecs').html("");
		$("#change_here_chart").html("").css("height", "");
		$('#mapspecs').html("");
		$("#change_here_map").html("").css("height", "");

		if($(".query").children(".draggable").length < 1){								// if query area has no children, there are no fields selected
			alert("No query!");										
			return;
		}
		getValues();																	// query area has children so get the values of those children

		if($("input:radio[name ='result-view']:checked").val() == "table"){				// selected table as the result vie of the query
			if($(".query").children(".draggable").length < 1){
				alert("No query!");
				return;
			}
			var drags=$(".query").children(".draggable");								// add and set default sort by and order by value to first dragged field ascending
			var str="<input type='hidden' id='sortby' name='sort_by' value='"+$(drags[0]).children('.lbl').text()+"' required='required' checked='checked'></input><br>\
				<input type='hidden' id='orderby' name='order_by' value='asc'></input><br>\
				";
			$("#tablespecs").append(str);

			$.ajax({																	// query the database
				url: base_url + "controller_interactive_search/query_table",
				type: 'POST',
				data: serialize_form(),

				success: function(result) {
					$('#change_here_table').html(result);
				},
				error: function(err) {
					$('#change_here_table').html(err);
				}
			});
		}
		else if($("input:radio[name ='result-view']:checked").val() == "chart"){		// selected chart as the result vie of the query
			// get possible graphingfactors
			if($(".query").children(".draggable").length < 1){							// if query area has no children, there are no fields selected
				alert("No query!");
				return;
			}
			var str="";
			var drags=$(".query").children(".draggable");
			for(i=0; i<drags.length; i++){
				if($(drags[i]).children('.lbl').hasClass('nongraph')) continue;
				dragval=$(drags[i]).children('.lbl').text();							// add form for getting the specifics of querying via chart
				str+="<input type='radio' name='chartgraphingfactor' id='"+dragval+"' value='"+dragval+"'  required='required'><label for='"+dragval+"'>"+dragval+"</label></input><br>";
			}

			var options=$(str);
			$("#chartspecs").html("Select graphing factor:<br>");
			$("#chartspecs").append(options);

			// charts can be viewed in two types: chart and bar
			str="<input type='radio' name='graphtype' id='pie' value='pie' required='required' checked='checked'><label for='pie'>Pie Chart</label></input><br>\
				<input type='radio' name='graphtype' id='bar' value='bar'><label for='bar'>Bar Chart</label></input><br>\
				";
			options=$(str);
			$("#chartspecs").append("Select graph type:<br>");
			$("#chartspecs").append(options);
		}
		else if($("input:radio[name ='result-view']:checked").val() == "map"){			// selected map as the result vie of the query
			if($(".query").children(".draggable").length < 1){
				alert("No query!");
				return;
			}
			var str="";
			var drags=$('.query').children('.draggable');
			var k=0, j=0, l=0;
			for(var i=0; i<drags.length; i++){
				if($(drags[i]).hasClass('curadd')){
					if(l==0){
						// add current address as an option to mapping if the query has a field that is dependent to a graduate
						if(drags.length == 1) str="<input type='radio' name='mapfactor' id='curadd' value='curadd' required='required'><label for='curadd'>Current Address</label></input>";
						else str+="<input type='radio' name='mapfactor' id='curadd' value='curadd' required='required'><label for='curadd'>Current Address</label></input><br>";
						l=1;
					}
				}
				if($(drags[i]).hasClass('sadd')){
					if(k==0){
						// add school address as an option to mapping if the query has a field that is dependent to a school
						if(drags.length == 1) str="<input type='radio' name='mapfactor' id='sadd' value='sadd'><label for='sadd'>School Address</label></input><br>";
						else str+="<input type='radio' name='mapfactor' id='sadd' value='sadd'><label for='sadd'>School Address</label></input><br>";
						k=1;
					}
				}
				else if($(drags[i]).hasClass('cadd')){
					if(j==0){
						// add company address as an option to mapping if the query has a field that is dependent to a company
						if(drags.length == 1) str="<input type='radio' name='mapfactor' id='cadd' value='cadd'><label for='cadd'>Company Address</label></input><br>";
						else str+="<input type='radio' name='mapfactor' id='cadd' value='cadd'><label for='cadd'>Company Address</label></input><br>";
						j=1;
					}
				}
			}
			options=$(str);
			$("#mapspecs").append("Select mapping factor:<br>");
			$("#mapspecs").append(options);
		}
	});

	// option if current job is the only one selected or all jobs related
	$('#current_job').on('change', function(){	
		var value=$('#currentjob').val();
		if(value == 'false') $('#currentjob').val('true');
		else $('#currentjob').val('false');
	});
});

// serializing the form of the specifics of the query
function serialize_form(){
	return $("#interactivesearch").serialize();
}

// change result view type
$(document).on("change","input:radio[name ='result-view']", function(){
	$('#chartspecs').html("");
	$('#mapspecs').html("");
});

// change mapfactor value
// view results using a map
$(document).on("change","input:radio[name ='mapfactor']", function(){
	$.ajax({																			// ajax call for getting values with respect to map factor
		url: base_url + "controller_interactive_search/query_map",
		type: 'POST',
		data: serialize_form(),
		dataType: 'json',

		success: function(result) {
			$('#change_here_map').html(result);
			var items=$.parseJSON(JSON.stringify(result));								// convert json to array
			
			var queryres=items['result'];												
			var countryvalues=items['country'];
			var provincevalues=items['province'];
			var mappath=new Array();
			var mapCount=0;

			function getQueryValue(countryname){										// get values with respect to country name
				if(countryvalues[countryname]) return countryvalues[countryname];
				else return 0;
			}

			function getProvinceValue(provincename){									// get values with respect to state or province name
				if(provincevalues[provincename]) return provincevalues[provincename];
				else return 0;
			}


			$.each(Highcharts.mapDataIndex, function (mapGroup, maps) {					// iterate through all the maps available on highcharts
		        if (mapGroup !== "version") {
		            $.each(maps, function (desc, path) {
		                mappath.push(path);
		                mapCount += 1;
		            });
		        }
		    });
		    $('#change_here_map').css("height", "800px");
			var data = Highcharts.geojson(Highcharts.maps['custom/world']),         	// points to be refered to when setting series
			// Some responsiveness
			small = $('#change_here_map').width() < 400;

			// Set drilldown pointers
			$.each(data, function (i) {
				this.drilldown = this.properties['hc-key'];    
				this.key= this.properties['hc-key'],                     				// link to drilldown map
				this.value = getQueryValue(this.name);                                  // Non-random bogus data    
			});

			// Instantiate the map
			$('#change_here_map').highcharts('Map', {
				chart : {
					events: {
						drilldown: function (e) {
							var key = e.point.key;
							var country;
							if(typeof e.point.parentcountry !== 'undefined') country=e.point.parentcountry;
							else country=e.point.key;

							if (!e.seriesOptions) {
								var chart = this,
									mapKey = 'countries/' + country + '/' + key + '-all',			// for countries only
									// Handle error, the timeout is cleared on success
									fail = setTimeout(function () {
										if (!Highcharts.maps[mapKey]) {
											chart.showLoading('<i class="icon-spinner icon-spin icon-3x"></i>'); // Font Awesome spinner

											fail = setTimeout(function () {
												chart.hideLoading();
											}, 1000);
										}
									}, 3000);

								// Show the spinner
								chart.showLoading('<i class="icon-spinner icon-spin icon-3x"></i>'); // Font Awesome spinner

								// Load the drilldown map
								$.getScript('http://code.highcharts.com/mapdata/' + mapKey + '.js', function () {
									data = Highcharts.geojson(Highcharts.maps[mapKey]);

									// Set a non-random bogus value
									$.each(data, function (i) {
										this.key= this.properties['hc-key'],          // link to drilldown map
										this.value = getProvinceValue(this.name);
										this.parentcountry=country;
									});

									// Hide loading and add series
									chart.hideLoading();
									clearTimeout(fail);
									chart.addSeriesAsDrilldown(e.point, {
										name: e.point.name,
										data: data,
										dataLabels: {
											enabled: true,
											format: '{point.name}'
										}
									});
								})
							}

							this.setTitle(null, { text: e.point.name });
						}
					}
				},

				title : {
					text : 'Query Mapped Results'										// set title of map
				},

				legend: small ? {} : {													// right color range legend
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle'
				},

				colorAxis: {															// set color range used
					min: 0,
                    stops: [
                        [0, '#EFEFFF'],
                        [0.5, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).brighten(-0.5).get()]
                    ]
				},

				mapNavigation: {														// dragging of map
					enabled: true,
					buttonOptions: {
						verticalAlign: 'bottom'
					}
				},

				plotOptions: {
					map: {
						states: {
							hover: {
								color: '#EEDD66'
							}
						}
					}
				},

				series : [{																// labels on locations
					data : data,
					name: 'World',
					dataLabels: {
						enabled: true,
						format: '{point.name}'
					}
				}],

				drilldown: {															// drilldown on a country
					activeDataLabelStyle: {
						textDecoration: 'none'
					},
					drillUpButton: {
						relativeTo: 'spacingBox',
						position: {
							x: 0,
							y: 60
						}
					}
				}
			});
		},
		error: function(err){
			console.log(err);
		}
	});
});

// change result view
// view results via charts 
$(document).on("change","input:radio[name ='chartgraphingfactor']", function(){
	$.ajax({
		url: base_url + "controller_interactive_search/query_chart",
		type: 'POST',
		data: serialize_form(),
		dataType: 'json',

		success: function(result) {
			var factor=result.factor[0];
			var graphtype=result.graphtype[0];
			if(graphtype == 'pie'){														// if chart view type is a pie
				var values=new Array();
				for(var i=0; i<result.categories.length; i++){
					if(result.categories[i]==null) values.push("Not available/applicable", parseInt(result.count[i]))	// null or empty values 
					else values.push([result.categories[i], parseInt(result.count[i])]);
				}
				// console.log(values);
				$('#change_here_chart').highcharts({									// show results via highcharts - pie
					chart: {
						type: 'pie'														// specify view type
					},
					title: {
						text: factor
					},
					tooltip: {
						pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								format: '<b>{point.name}</b>: {point.percentage:.1f} %',
								style: {
									color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
								}
							}
						}
					},
					series: [{
						type: 'pie',
						name: 'Population',
						data: values
					}]
				});
			}
			else if(graphtype == "bar"){												// show results via highcharts - bar
				var categories=new Array();
				var counter=new Array();

				for(var i=0; i<result.categories.length; i++){
					categories.push(result.categories[i]);
					counter.push(parseInt(result.count[i]));
				}
				$('#change_here_chart').css("height", (categories.length*50+100));
				$('#change_here_chart').highcharts({
					chart: {
						type: 'bar'
					},
					title: {
						text: factor
					},
					xAxis: {
						categories: categories
					},
					yAxis: {
						title: {
							text: 'Population'
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								format: '<b>{point.name}</b>: {point.percentage:.1f} %',
								style: {
									color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
								}
							}
						}
					},
					series: [{
						name: 'Population',
						data: counter
					}]
				});
			}
		},
		error: function(err) {
			$('#change_here_chart').html(err);
		}
	});
});

// get the values from the query made
function getValues(){											
	if(! validateValues()) return false;						// check if values supplied is correct
	var children=$(".query").children(".clone");				// cloned fields -- items in the query area
	if(children.length==0) return false;						// if there are no items in the query area, return 
	var querystring="";
	
	for(var i=0; i<children.length; i++){						// iterate through every item in the query area
		if(i>0) querystring+="&";								// delimit every item using '&'
		var child=$(children[i]);
		querystring+=child.children('.view')[0].innerText;		// field to be shown
		
		if(child.children('.compare').length > 0){				// single constraint
			querystring+=":Val("+child.children('.compare').val()+","+child.children('.value').val()+")";
		}
		else if(child.children('.op').length > 0){				// and or or operation
			var operator=child.children('.op').children('.operator')[0].innerText;
			querystring+=":"+operator+"(";
			var retval=operationValues(child.children('.op'), operator);
			if(! retval) return false; 
			else querystring+=retval+")";
		}
	}
	$("#values").val(querystring);								// set the value input field with the id values to query string made 
	return true;
}

function operationValues(op, operator){							// within and and or operations --  recursive function
	var querystring="";
	var item=$(op);
	var j=0;
	if(item.children('.compare').length + item.children('.op').length < 2){		// operations must have at least two values or operation specified
		alert("For operations, supply at least two possible values (value/operation)");
		return false;
	}

	if(item.children('.compare').length > 0){					// if there are specified values given
		j=1;
		for(var i=0; i<item.children('.compare').length; i++){	// iterate through values given
			if(i>0) querystring+=",";							// delimit values given using a comma
			querystring+="Val("+item.children('.compare')[i].value+","+item.children('.value')[i].value+")";	// values will be specified in the string using Val(<Comparison>,<Value>)
		}
	}
	if(item.children('.op').length > 0){						// if operations are specified -- and or or
		var childop=item.children('.op');
		if(childop.length > 0){	
			var val=new Array();
			for (var l=0; l<childop.length; l++) {
				val.push(operationValues(childop[l], childop.children('.operator')[0].innerText));				// recursive call for multiple values or operations within 
			}

			for(var l=0; l<val.length; l++){
				if(i>0 || j==1) querystring+=",";
				querystring+=childop.children('.operator')[0].innerText+"(";
				querystring+=val[l]+")";
			}

			if(! querystring) return false;						
			j=0;
		}
	}
	return querystring;
}

// validate values specified in the query area
function validateValues(){
	var children=$(".query").children(".clone");
	for(var i=0; i<children.length; i++){
		var child=$(children[i]);
		var querystring=child.children('.view')[0].innerText;
		if(! querystring.match(/^[A-Za-z0-9_\-\sñÑ]*$/)){				// values supplied
			alert("Fix Values Query!");
			return false;
		}
		var compare=child.find('.compare');
		var comparelength=compare.length;
		if(comparelength > 0){											// single constraint
			var value=child.find('.value');
			for(var j=0; j<comparelength; j++){
				comparestring=compare[j].value;							// comparison values
				if(! comparestring.match(/^[A-Za-z0-9_\-\s]*$/)){
					alert("Fix Values Compare!");
					return false;
				}
				valuestring=value[j].value;								// values supplied
				if(! valuestring.match(/^[A-Za-z0-9_\-\s@\.%ñÑ]*$/)){
					alert("Fix Values Value!");
					return false;
				}
			}
		}
	}
	return true;
}


// drag and drop css
$(function() {
	// comparison types
	var consinput=
		"<br>\
		<select class='compare'>\
			<option>Equals</option>\
			<option>Not Equals</option>\
			<option>Less Than</option>\
			<option>Greater Than</option>\
			<option>Less Than or Equal</option>\
			<option>Greater Than or Equal</option>\
			<option>Like</option>\
			<option>Not Like</option>\
		</select>\
		<input type='text' class='value'></input>";

	function handleDropEvent(event, ui){
		if(! $(ui.draggable).hasClass('clone')){					// not a duplicate of a clone
			$(ui.draggable).addClass("includedField");				
			$(ui.draggable).draggable("disable");					// field on field list will be drag disabled
			var clone = $(ui.draggable).clone();
			clone.removeClass('original');							// remove original class from cloned item
			$(ui.draggable).css("background", "#ddd");				// set the color of original color to #ddd
			clone.children('.lbl').attr("data-toggle", "dropdown");	// label dropdown on 
			clone.children('.lbl').addClass("dropdown-toggle");
			var label=clone.children('.lbl').text();
			var str=												// add X for removing item on the query list
				"<span class='rem opt'>X</span>\
				<span class='caret opt' data-toggle='dropdown'></span>";
			var mod=$(str);											// add on the clone field
			str=													// specify constraint values
				"<ul class='dropdown-menu'>\
					<li class='dropdown-item single'><a>Single Constraint</li>\
					<li class='dropdown-item and'><a>Multiple Constraints (And)</a></li>\
					<li class='dropdown-item or'><a>Multiple Constraints (Or)</a></li>\
				</ul>"
			var options=$(str);
			clone.css('top', 0).css('left', 0).css('clear', 'both').css('z-index', '');
			clone.addClass('clone');
			clone.prepend(mod);
			clone.append(options);
			$(this).append(clone);
			
			if($(ui.draggable).hasClass('draggable')){
				clone.draggable();
			}
			disableUnrelatedFields();								
		}
		else{														// duplicate of a clone -- sort
			var item=$(ui.draggable).detach();
			item.css('top', 0).css('left', 0).css('clear', 'both');
			$(this).append(item);
		}
	}

	// disable fields that cannot be related to the currently selected fields
	// if there is a field from the basic info group of fields, all fields are enabled.
	// if not, only the graduate fields and the fields that the currently selected field belongs to is enabled 
	function disableUnrelatedFields(){	
		var classTabs=['graduate', 'educbg', 'works', 'projects', 'publications', 'awards', 'grant', 'others'];
		var drags=$(".query").children(".draggable");
		var included=new Array();
		// from children of query, identify which groups are possible to include.

		for(var i=0; i<drags.length; i++){
			var classification=-1;
			possible=$(drags[i]).attr('class').split(' ');

			for(var j=0; j<possible.length; j++){
				if($.inArray(possible[j], classTabs) > -1){
					if($.inArray(possible[j], included) < 0)
						included.push(possible[j]);
					break;
				}
			}
		}

		if($.inArray("graduate", included) < 0){
			// Note: graduate field is always possible 	
			for(var j=1; j<classTabs.length; j++){
				if(classTabs[j] != included[0]){
					$("."+classTabs[j]+":not(.clone)").css("background", "#ddd");
					$("."+classTabs[j]+":not(.clone)").draggable("disable");
				}
			}
			//conflicting values, must remove other elements from the query
			var drags=$(".query").children(".draggable");
			if(drags.length>1){
				for(var j=1; j<drags.length; j++){
					if(! $(drags[j]).hasClass(included[0]))
						$(drags[j]).remove();
				}
			}
		}
		else{
			// enable all other fields except those who have a class of includedField
			var original = $(".original");
			for(var j=1; j<original.length; j++){
				if(! $(original[j]).hasClass('includedField')){
					$(original[j]).css("background", "");
					$(original[j]).draggable({
						helper: 'clone',
						revert: true,
						revertDuration: 0,
						drag: function(event, ui) {
							$(this).css('z-index', 5);
						},
						stop: function(event, ui){
							$(this).css('z-index', 2);
						}
					});
					$(original[j]).draggable("enable");
				}
			}
		}
		if(included.length == 0){
			//enable all
			// enable all other fields except those who have a class of includedField
			var original = $(".original");
			for(var j=1; j<original.length; j++){
				if(! $(original[j]).hasClass('includedField')){
					$(original[j]).css("background", "");
					$(original[j]).draggable({
						helper: 'clone',
						revert: true,
						revertDuration: 0,
						drag: function(event, ui) {
							$(this).css('z-index', 5);
						},
						stop: function(event, ui){
							$(this).css('z-index', 2);
						}
					});
					$(original[j]).draggable("enable");
				}
			}
		}
	}

	// set divs with class draggable 
	$(".draggable").draggable({		
		helper: 'clone',
		revert: true,			
		revertDuration: 0,
		drag: function(event, ui) {
			$(this).css('z-index', 5);
		},
		stop: function(event, ui){
			$(this).css('z-index', 2);
		}
	});

	// set div with class query to be droppable
	// div in the right side of the page will be droppable
	$(".query").droppable({
		drop: handleDropEvent
	});

	// click on the X added on the draggable field
	$(document).on('click', '.rem', function(){
		if($(this).parent().hasClass('clone')){		// enable original
			var views=$('.view');
			for(var i=0; i<views.length; i++){
				if($(views[i]).text()==$(this).parent().children('.view').text()){
					$(views[i]).parent().removeClass('includedField');
					$(views[i]).parent().draggable("enable");
					$(views[i]).parent().css("background","");
				}
			}
		}
		var secparent=$(this).parent().parent();
		$(this).parent().remove();
		if(secparent.hasClass('clone') && secparent.children('.compare').length==0 && secparent.children('.op').length==0){
			secparent.children('.rem').remove();
			var str=
				"<span class='rem opt'>X</span>\
				<span class='caret opt' data-toggle='dropdown'></span>";
			var mod=$(str);
			str=
				"<ul class='dropdown-menu'>\
					<li class='dropdown-item single'><a>Single Constraint</li>\
					<li class='dropdown-item and'><a>Multiple Constraints (And)</a></li>\
					<li class='dropdown-item or'><a>Multiple Constraints (Or)</a></li>\
				</ul>"
			var options=$(str);
			secparent.prepend(mod);
			secparent.append(options);
			secparent.children('.lbl').addClass("dropdown-toggle");
			secparent.children('.lbl').attr("data-toggle", "dropdown");
		}
		disableUnrelatedFields();
	});

	$(document).on('click', '.single', function(){
		var single=$(consinput);
		
		$(this).parent().parent().append(single);
		$(this).parent().parent().css('z-index', '');
		$(this).parent().remove();
		single.siblings(".caret").remove();
	});

	// add conditions that
	$(document).on('click', '.add-cons', function(){
		var single=$(consinput);
		$(this).parent().parent().append(single);
	});

	// add an and operation
	$(document).on('click', '.and', function(){
		var secparent = $(this).parent().parent();
		if(secparent.hasClass("clone")){						// remove caret and other attributes and classes of draggable
			secparent.children().remove(".caret");
			secparent.children().remove(".dropdown-menu");
			secparent.children('.lbl').removeAttr("data-toggle");
			secparent.children('.lbl').removeClass("dropdown-toggle");
		}
		var mod=$("<span class='rem opt'>X</span><span class='caret opt' data-toggle='dropdown'>");
		var options=$("<ul class='dropdown-menu'><li class='dropdown-item add-cons'><a>Add Constraint</li><li class='dropdown-item or'><a>Multiple Constraints (Or)</a></li></ul>");
		var andop=$("<div class='op resizable'><span class='lbl operator dropdown-toggle' data-toggle='dropdown'>And</span></div>");		// and div
		andop.css("display", "table");
		andop.prepend(mod);										// add the caret and X for removing
		andop.append(options);									// add dropdown values
		secparent.append(andop);								// add the and div
	});

	// add an or operation
	$(document).on('click', '.or', function(){
		var secparent = $(this).parent().parent();
		if(secparent.hasClass("clone")){						// remove caret and other attributes and classes of draggable
			secparent.children().remove(".caret");
			secparent.children().remove(".caret");
			secparent.children().remove(".dropdown-menu");
			secparent.children('.lbl').removeAttr("data-toggle");
			secparent.children('.lbl').removeClass("dropdown-toggle");
		}

		var mod=$("<span class='rem opt'>X</span><span class='caret opt' data-toggle='dropdown'>");
		var options=$("<ul class='dropdown-menu'><li class='dropdown-item add-cons'><a>Add Constraint</li><li class='dropdown-item and'><a>Multiple Constraints (And)</a></li></ul>");
		var orop=$("<div class='op resizable'><span class='lbl operator dropdown-toggle' data-toggle='dropdown'>Or</span></div>");			// or div
		orop.css("display", "table");
		orop.prepend(mod);										// add the caret and X for removing
		orop.append(options);									// add dropdown values
		secparent.append(orop);									// add the or div
	});
});

// from bootstrap
// dropdown js

+function ($) {
	'use strict';

	// DROPDOWN CLASS DEFINITION
	// =========================

	var backdrop = '.dropdown-backdrop'
	var toggle   = '[data-toggle="dropdown"]'
	var Dropdown = function (element) {
		$(element).on('click.bs.dropdown', this.toggle)
	}

	Dropdown.VERSION = '3.3.4'

	Dropdown.prototype.toggle = function (e) {
		var $this = $(this)

		if ($this.is('.disabled, :disabled')) return

		var $parent  = getParent($this)
		var isActive = $parent.hasClass('open')

		clearMenus()

		if (!isActive) {
			if ('ontouchstart' in document.documentElement && !$parent.closest('.navbar-nav').length) {
				// if mobile we use a backdrop because click events don't delegate
				$('<div class="dropdown-backdrop"/>').insertAfter($(this)).on('click', clearMenus)
			}

			var relatedTarget = { relatedTarget: this }
			$parent.trigger(e = $.Event('show.bs.dropdown', relatedTarget))

			if (e.isDefaultPrevented()) return

			$this
				.trigger('focus')
				.attr('aria-expanded', 'true')

			$parent
				.toggleClass('open')
				.trigger('shown.bs.dropdown', relatedTarget)
		}

		return false
	}

	Dropdown.prototype.keydown = function (e) {
		if (!/(38|40|27|32)/.test(e.which) || /input|textarea/i.test(e.target.tagName)) return

		var $this = $(this)

		e.preventDefault()
		e.stopPropagation()

		if ($this.is('.disabled, :disabled')) return

		var $parent  = getParent($this)
		var isActive = $parent.hasClass('open')

		if ((!isActive && e.which != 27) || (isActive && e.which == 27)) {
			if (e.which == 27) $parent.find(toggle).trigger('focus')
			return $this.trigger('click')
		}

		var desc = ' li:not(.disabled):visible a'
		var $items = $parent.find('[role="menu"]' + desc + ', [role="listbox"]' + desc)

		if (!$items.length) return

		var index = $items.index(e.target)

		if (e.which == 38 && index > 0)                 index--                        // up
		if (e.which == 40 && index < $items.length - 1) index++                        // down
		if (!~index)                                      index = 0

		$items.eq(index).trigger('focus')
	}

	function clearMenus(e) {
		if (e && e.which === 3) return
		$(backdrop).remove()
		$(toggle).each(function () {
			var $this         = $(this)
			var $parent       = getParent($this)
			var relatedTarget = { relatedTarget: this }

			if (!$parent.hasClass('open')) return

			$parent.trigger(e = $.Event('hide.bs.dropdown', relatedTarget))

			if (e.isDefaultPrevented()) return

			$this.attr('aria-expanded', 'false')
			$parent.removeClass('open').trigger('hidden.bs.dropdown', relatedTarget)
		})
	}

	function getParent($this) {
		var selector = $this.attr('data-target')

		if (!selector) {
			selector = $this.attr('href')
			selector = selector && /#[A-Za-z]/.test(selector) && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
		}

		var $parent = selector && $(selector)

		return $parent && $parent.length ? $parent : $this.parent()
	}


	// DROPDOWN PLUGIN DEFINITION
	// ==========================

	function Plugin(option) {
		return this.each(function () {
			var $this = $(this)
			var data  = $this.data('bs.dropdown')

			if (!data) $this.data('bs.dropdown', (data = new Dropdown(this)))
			if (typeof option == 'string') data[option].call($this)
		})
	}

	var old = $.fn.dropdown

	$.fn.dropdown             = Plugin
	$.fn.dropdown.Constructor = Dropdown


	// DROPDOWN NO CONFLICT
	// ====================

	$.fn.dropdown.noConflict = function () {
		$.fn.dropdown = old
		return this
	}


	// APPLY TO STANDARD DROPDOWN ELEMENTS
	// ===================================

	$(document)
		.on('click.bs.dropdown.data-api', clearMenus)
		.on('click.bs.dropdown.data-api', '.dropdown form', function (e) { e.stopPropagation() })
		.on('click.bs.dropdown.data-api', toggle, Dropdown.prototype.toggle)
		.on('keydown.bs.dropdown.data-api', toggle, Dropdown.prototype.keydown)
		.on('keydown.bs.dropdown.data-api', '[role="menu"]', Dropdown.prototype.keydown)
		.on('keydown.bs.dropdown.data-api', '[role="listbox"]', Dropdown.prototype.keydown)
		.on('click', '.dropdown', toggle, Dropdown.prototype.toggle)
}(jQuery);