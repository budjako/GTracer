	$(document).ready(function() {
		$(".submit-query").click(function get_data(event) {
			event.preventDefault();

			if($(".query").children(".draggable").length < 1){
				alert("No query!");
				return;
			}
			getValues();

			if($("input:radio[name ='result-view']:checked").val() == "table"){
				$.ajax({
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
			else if($("input:radio[name ='result-view']:checked").val() == "chart"){
				// get possible graphingfactors
				if($(".query").children(".draggable").length < 1){
					alert("No query!");
					return;
				}
				var str="";
				var drags=$(".query").children(".draggable");
				for(i=0; i<drags.length; i++){
					console.log(drags[i]);
					if($(drags[i]).children('.lbl').hasClass('nongraph')) continue;
					dragval=$(drags[i]).children('.lbl').text();
					console.log(dragval);
					str+="<input type='radio' name='chartgf' id='"+dragval+"' value='"+dragval+"'><label for='"+dragval+"'>"+dragval+"</label></input><br>";
				}

				var options=$(str);
				$("#chartspecs").html("Select graphing factor:<br>");
				$("#chartspecs").append(options);

				str="<input type='radio' name='graphtype' id='pie' value='pie'><label for='pie'>Pie Chart</label></input><br>\
					<input type='radio' name='graphtype' id='bar' value='bar'><label for='bar'>Bar Chart</label></input><br>\
					";
				options=$(str);
				$("#chartspecs").append("Select graph type:<br>");
				$("#chartspecs").append(options);
			}
			else if($("input:radio[name ='result-view']:checked").val() == "map"){
				$.ajax({
					url: base_url + "controller_interactive_search/query_map",
					type: 'POST',
					data: serialize_form(),

					success: function(result) {
						var data=[
							{
								"code": "AF",
								"value": 53,
								"name": "Afghanistan"
							},
							{
								"code": "AL",
								"value": 117,
								"name": "Albania"
							},
							{
								"code": "DZ",
								"value": 15,
								"name": "Algeria"
							},
							{
								"code": "AS",
								"value": 342,
								"name": "American Samoa"
							},
							{
								"code": "AD",
								"value": 181,
								"name": "Andorra"
							},
							{
								"code": "AO",
								"value": 15,
								"name": "Angola"
							},
							{
								"code": "AI",
								"value": 202,
								"name": "Antigua and Barbuda"
							},
							{
								"code": "AR",
								"value": 15,
								"name": "Argentina"
							},
							{
								"code": "AM",
								"value": 109,
								"name": "Armenia"
							},
							{
								"code": "AW",
								"value": 597,
								"name": "Aruba"
							},
							{
								"code": "AU",
								"value": 3,
								"name": "Australia"
							},
							{
								"code": "AT",
								"value": 102,
								"name": "Austria"
							},
							{
								"code": "AZ",
								"value": 110,
								"name": "Azerbaijan"
							},
							{
								"code": "BS",
								"value": 34,
								"name": "Bahamas, The"
							},
							{
								"code": "BH",
								"value": 1660,
								"name": "Bahrain"
							},
							{
								"code": "BD",
								"value": 1142,
								"name": "Bangladesh"
							},
							{
								"code": "BB",
								"value": 636,
								"name": "Barbados"
							},
							{
								"code": "BY",
								"value": 47,
								"name": "Belarus"
							},
							{
								"code": "BE",
								"value": 359,
								"name": "Belgium"
							},
							{
								"code": "BZ",
								"value": 15,
								"name": "Belize"
							},
							{
								"code": "BJ",
								"value": 80,
								"name": "Benin"
							},
							{
								"code": "BM",
								"value": 1292,
								"name": "Bermuda"
							},
							{
								"code": "BT",
								"value": 19,
								"name": "Bhutan"
							},
							{
								"code": "BO",
								"value": 9,
								"name": "Bolivia"
							},
							{
								"code": "BA",
								"value": 73,
								"name": "Bosnia and Herzegovina"
							},
							{
								"code": "BW",
								"value": 4,
								"name": "Botswana"
							},
							{
								"code": "BR",
								"value": 23,
								"name": "Brazil"
							},
							{
								"code": "BN",
								"value": 76,
								"name": "Brunei Darussalam"
							},
							{
								"code": "BG",
								"value": 69,
								"name": "Bulgaria"
							},
							{
								"code": "BF",
								"value": 60,
								"name": "Burkina Faso"
							},
							{
								"code": "BI",
								"value": 326,
								"name": "Burundi"
							},
							{
								"code": "KH",
								"value": 80,
								"name": "Cambodia"
							},
							{
								"code": "CM",
								"value": 41,
								"name": "Cameroon"
							},
							{
								"code": "CA",
								"value": 4,
								"name": "Canada"
							},
							{
								"code": "CV",
								"value": 123,
								"name": "Cape Verde"
							},
							{
								"code": "KY",
								"value": 234,
								"name": "Cayman Islands"
							},
							{
								"code": "CF",
								"value": 7,
								"name": "Central African Republic"
							},
							{
								"code": "TD",
								"value": 9,
								"name": "Chad"
							},
							{
								"code": "CL",
								"value": 23,
								"name": "Chile"
							},
							{
								"code": "CN",
								"value": 143,
								"name": "China"
							},
							{
								"code": "CO",
								"value": 42,
								"name": "Colombia"
							},
							{
								"code": "KM",
								"value": 395,
								"name": "Comoros"
							},
							{
								"code": "CD",
								"value": 29,
								"name": "Congo, Dem. Rep."
							},
							{
								"code": "CG",
								"value": 12,
								"name": "Congo, Rep."
							},
							{
								"code": "CR",
								"value": 91,
								"name": "Costa Rica"
							},
							{
								"code": "CI",
								"value": 62,
								"name": "Cote d'Ivoire"
							},
							{
								"code": "HR",
								"value": 79,
								"name": "Croatia"
							},
							{
								"code": "CU",
								"value": 106,
								"name": "Cuba"
							},
							{
								"code": "CW",
								"value": 321,
								"name": "Curacao"
							},
							{
								"code": "CY",
								"value": 119,
								"name": "Cyprus"
							},
							{
								"code": "CZ",
								"value": 136,
								"name": "Czech Republic"
							},
							{
								"code": "DK",
								"value": 131,
								"name": "Denmark"
							},
							{
								"code": "DJ",
								"value": 38,
								"name": "Djibouti"
							},
							{
								"code": "DM",
								"value": 90,
								"name": "Dominica"
							},
							{
								"code": "DO",
								"value": 205,
								"name": "Dominican Republic"
							},
							{
								"code": "EC",
								"value": 58,
								"name": "Ecuador"
							},
							{
								"code": "EG",
								"value": 81,
								"name": "Egypt, Arab Rep."
							},
							{
								"code": "SV",
								"value": 299,
								"name": "El Salvador"
							},
							{
								"code": "GQ",
								"value": 25,
								"name": "Equatorial Guinea"
							},
							{
								"code": "ER",
								"value": 52,
								"name": "Eritrea"
							},
							{
								"code": "EE",
								"value": 32,
								"name": "Estonia"
							},
							{
								"code": "ET",
								"value": 83,
								"name": "Ethiopia"
							},
							{
								"code": "FO",
								"value": 35,
								"name": "Faeroe Islands"
							},
							{
								"code": "FJ",
								"value": 47,
								"name": "Fiji"
							},
							{
								"code": "FI",
								"value": 18,
								"name": "Finland"
							},
							{
								"code": "FR",
								"value": 118,
								"name": "France"
							},
							{
								"code": "PF",
								"value": 74,
								"name": "French Polynesia"
							},
							{
								"code": "GA",
								"value": 6,
								"name": "Gabon"
							},
							{
								"code": "GM",
								"value": 173,
								"name": "Gambia, The"
							},
							{
								"code": "GE",
								"value": 78,
								"name": "Georgia"
							},
							{
								"code": "DE",
								"value": 234,
								"name": "Germany"
							},
							{
								"code": "GH",
								"value": 107,
								"name": "Ghana"
							},
							{
								"code": "GR",
								"value": 88,
								"name": "Greece"
							},
							{
								"code": "GL",
								"value": 0.02,
								"name": "Greenland"
							},
							{
								"code": "GD",
								"value": 307,
								"name": "Grenada"
							},
							{
								"code": "GU",
								"value": 333,
								"name": "Guam"
							},
							{
								"code": "GT",
								"value": 134,
								"name": "Guatemala"
							},
							{
								"code": "GN",
								"value": 41,
								"name": "Guinea"
							},
							{
								"code": "GW",
								"value": 54,
								"name": "Guinea-Bissau"
							},
							{
								"code": "GY",
								"value": 4,
								"name": "Guyana"
							},
							{
								"code": "HT",
								"value": 363,
								"name": "Haiti"
							},
							{
								"code": "HN",
								"value": 68,
								"name": "Honduras"
							},
							{
								"code": "HK",
								"value": 6783,
								"name": "Hong Kong SAR, China"
							},
							{
								"code": "HU",
								"value": 112,
								"name": "Hungary"
							},
							{
								"code": "IS",
								"value": 3,
								"name": "Iceland"
							},
							{
								"code": "IN",
								"value": 394,
								"name": "India"
							},
							{
								"code": "ID",
								"value": 132,
								"name": "Indonesia"
							},
							{
								"code": "IR",
								"value": 45,
								"name": "Iran, Islamic Rep."
							},
							{
								"code": "IQ",
								"value": 73,
								"name": "Iraq"
							},
							{
								"code": "IE",
								"value": 65,
								"name": "Ireland"
							},
							{
								"code": "IM",
								"value": 145,
								"name": "Isle of Man"
							},
							{
								"code": "IL",
								"value": 352,
								"name": "Israel"
							},
							{
								"code": "IT",
								"value": 206,
								"name": "Italy"
							},
							{
								"code": "JM",
								"value": 250,
								"name": "Jamaica"
							},
							{
								"code": "JP",
								"value": 350,
								"name": "Japan"
							},
							{
								"code": "JO",
								"value": 69,
								"name": "Jordan"
							},
							{
								"code": "KZ",
								"value": 6,
								"name": "Kazakhstan"
							},
							{
								"code": "KE",
								"value": 71,
								"name": "Kenya"
							},
							{
								"code": "KI",
								"value": 123,
								"name": "Kiribati"
							},
							{
								"code": "KP",
								"value": 202,
								"name": "Korea, Dem. Rep."
							},
							{
								"code": "KR",
								"value": 504,
								"name": "Korea, Rep."
							},
							{
								"code": "XK",
								"value": 167,
								"name": "Kosovo"
							},
							{
								"code": "KW",
								"value": 154,
								"name": "Kuwait"
							},
							{
								"code": "KG",
								"value": 28,
								"name": "Kyrgyz Republic"
							},
							{
								"code": "LA",
								"value": 27,
								"name": "Lao PDR"
							},
							{
								"code": "LV",
								"value": 36,
								"name": "Latvia"
							},
							{
								"code": "LB",
								"value": 413,
								"name": "Lebanon"
							},
							{
								"code": "LS",
								"value": 72,
								"name": "Lesotho"
							},
							{
								"code": "LR",
								"value": 41,
								"name": "Liberia"
							},
							{
								"code": "LY",
								"value": 4,
								"name": "Libya"
							},
							{
								"code": "LI",
								"value": 225,
								"name": "Liechtenstein"
							},
							{
								"code": "LT",
								"value": 53,
								"name": "Lithuania"
							},
							{
								"code": "LU",
								"value": 195,
								"name": "Luxembourg"
							},
							{
								"code": "MO",
								"value": 19416,
								"name": "Macao SAR, China"
							},
							{
								"code": "MK",
								"value": 82,
								"name": "Macedonia, FYR"
							},
							{
								"code": "MG",
								"value": 36,
								"name": "Madagascar"
							},
							{
								"code": "MW",
								"value": 158,
								"name": "Malawi"
							},
							{
								"code": "MY",
								"value": 86,
								"name": "Malaysia"
							},
							{
								"code": "MV",
								"value": 1053,
								"name": "Maldives"
							},
							{
								"code": "ML",
								"value": 13,
								"name": "Mali"
							},
							{
								"code": "MT",
								"value": 1291,
								"name": "Malta"
							},
							{
								"code": "MH",
								"value": 300,
								"name": "Marshall Islands"
							},
							{
								"code": "MR",
								"value": 3,
								"name": "Mauritania"
							},
							{
								"code": "MU",
								"value": 631,
								"name": "Mauritius"
							},
							{
								"code": "YT",
								"value": 552,
								"name": "Mayotte"
							},
							{
								"code": "MX",
								"value": 58,
								"name": "Mexico"
							},
							{
								"code": "FM",
								"value": 159,
								"name": "Micronesia, Fed. Sts."
							},
							{
								"code": "MD",
								"value": 124,
								"name": "Moldova"
							},
							{
								"code": "MC",
								"value": 17704,
								"name": "Monaco"
							},
							{
								"code": "MN",
								"value": 2,
								"name": "Mongolia"
							},
							{
								"code": "ME",
								"value": 47,
								"name": "Montenegro"
							},
							{
								"code": "MA",
								"value": 72,
								"name": "Morocco"
							},
							{
								"code": "MZ",
								"value": 30,
								"name": "Mozambique"
							},
							{
								"code": "MM",
								"value": 73,
								"name": "Myanmar"
							},
							{
								"code": "NA",
								"value": 3,
								"name": "Namibia"
							},
							{
								"code": "NP",
								"value": 209,
								"name": "Nepal"
							},
							{
								"code": "NL",
								"value": 492,
								"name": "Netherlands"
							},
							{
								"code": "NC",
								"value": 14,
								"name": "New Caledonia"
							},
							{
								"code": "NZ",
								"value": 17,
								"name": "New Zealand"
							},
							{
								"code": "NI",
								"value": 48,
								"name": "Nicaragua"
							},
							{
								"code": "NE",
								"value": 12,
								"name": "Niger"
							},
							{
								"code": "NG",
								"value": 174,
								"name": "Nigeria"
							},
							{
								"code": "MP",
								"value": 132,
								"name": "Northern Mariana Islands"
							},
							{
								"code": "NO",
								"value": 16,
								"name": "Norway"
							},
							{
								"code": "OM",
								"value": 9,
								"name": "Oman"
							},
							{
								"code": "PK",
								"value": 225,
								"name": "Pakistan"
							},
							{
								"code": "PW",
								"value": 45,
								"name": "Palau"
							},
							{
								"code": "PA",
								"value": 47,
								"name": "Panama"
							},
							{
								"code": "PG",
								"value": 15,
								"name": "Papua New Guinea"
							},
							{
								"code": "PY",
								"value": 16,
								"name": "Paraguay"
							},
							{
								"code": "PE",
								"value": 23,
								"name": "Peru"
							},
							{
								"code": "PH",
								"value": 313
							},
							{
								"code": "PH-LAG",
								"value": 1000
							},
							{
								"code": "PL",
								"value": 126,
								"name": "Poland"
							},
							{
								"code": "PT",
								"value": 116,
								"name": "Portugal"
							},
							{
								"code": "PR",
								"value": 449,
								"name": "Puerto Rico"
							},
							{
								"code": "WA",
								"value": 152,
								"name": "Qatar"
							},
							{
								"code": "RO",
								"value": 93,
								"name": "Romania"
							},
							{
								"code": "RU",
								"value": 9,
								"name": "Russian Federation"
							},
							{
								"code": "RW",
								"value": 431,
								"name": "Rwanda"
							},
							{
								"code": "WS",
								"value": 65,
								"name": "Samoa"
							},
							{
								"code": "SM",
								"value": 526,
								"name": "San Marino"
							},
							{
								"code": "ST",
								"value": 172,
								"name": "Sao Tome and Principe"
							},
							{
								"code": "SA",
								"value": 14,
								"name": "Saudi Arabia"
							},
							{
								"code": "SN",
								"value": 65,
								"name": "Senegal"
							},
							{
								"code": "RS",
								"value": 83,
								"name": "Serbia"
							},
							{
								"code": "SC",
								"value": 188,
								"name": "Seychelles"
							},
							{
								"code": "SL",
								"value": 82,
								"name": "Sierra Leone"
							},
							{
								"code": "SG",
								"value": 7252,
								"name": "Singapore"
							},
							{
								"code": "SK",
								"value": 113,
								"name": "Slovak Republic"
							},
							{
								"code": "SI",
								"value": 102,
								"name": "Slovenia"
							},
							{
								"code": "SB",
								"value": 19,
								"name": "Solomon Islands"
							},
							{
								"code": "SO",
								"value": 15,
								"name": "Somalia"
							},
							{
								"code": "ZA",
								"value": 41,
								"name": "South Africa"
							},
							{
								"code": "SS",
								"value": 13,
								"name": "South Sudan"
							},
							{
								"code": "ES",
								"value": 92,
								"name": "Spain"
							},
							{
								"code": "LK",
								"value": 333,
								"name": "Sri Lanka"
							},
							{
								"code": "KN",
								"value": 202,
								"name": "St. Kitts and Nevis"
							},
							{
								"code": "LC",
								"value": 285,
								"name": "St. Lucia"
							},
							{
								"code": "MF",
								"value": 556,
								"name": "St. Martin (French part)"
							},
							{
								"code": "VC",
								"value": 280,
								"name": "St. Vincent and the Grenadines"
							},
							{
								"code": "SD",
								"value": 16,
								"name": "Sudan"
							},
							{
								"code": "SR",
								"value": 3,
								"name": "Suriname"
							},
							{
								"code": "SZ",
								"value": 69,
								"name": "Swaziland"
							},
							{
								"code": "SE",
								"value": 23,
								"name": "Sweden"
							},
							{
								"code": "CH",
								"value": 196,
								"name": "Switzerland"
							},
							{
								"code": "SY",
								"value": 111,
								"name": "Syrian Arab Republic"
							},
							{
								"code": "TJ",
								"value": 49,
								"name": "Tajikistan"
							},
							{
								"code": "TZ",
								"value": 51,
								"name": "Tanzania"
							},
							{
								"code": "TH",
								"value": 135,
								"name": "Thailand"
							},
							{
								"code": "TP",
								"value": 76,
								"name": "Timor-Leste"
							},
							{
								"code": "TG",
								"value": 111,
								"name": "Togo"
							},
							{
								"code": "TO",
								"value": 145,
								"name": "Tonga"
							},
							{
								"code": "TT",
								"value": 261,
								"name": "Trinidad and Tobago"
							},
							{
								"code": "TN",
								"value": 68,
								"name": "Tunisia"
							},
							{
								"code": "TR",
								"value": 95,
								"name": "Turkey"
							},
							{
								"code": "TM",
								"value": 11,
								"name": "Turkmenistan"
							},
							{
								"code": "TC",
								"value": 40,
								"name": "Turks and Caicos Islands"
							},
							{
								"code": "TV",
								"value": 328,
								"name": "Tuvalu"
							},
							{
								"code": "UG",
								"value": 170,
								"name": "Uganda"
							},
							{
								"code": "UA",
								"value": 79,
								"name": "Ukraine"
							},
							{
								"code": "AE",
								"value": 90,
								"name": "United Arab Emirates"
							},
							{
								"code": "GB",
								"value": 257,
								"name": "United Kingdom"
							},
							{
								"code": "US",
								"value": 3400,
								"name": "United asdfasdf States"
							},
							{
								"code": "UY",
								"value": 19,
								"name": "Uruguay"
							},
							{
								"code": "UZ",
								"value": 66,
								"name": "Uzbekistan"
							},
							{
								"code": "VU",
								"value": 20,
								"name": "Vanuatu"
							},
							{
								"code": "VE",
								"value": 33,
								"name": "Venezuela, RB"
							},
							{
								"code": "VN",
								"value": 280,
								"name": "Vietnam"
							},
							{
								"code": "VI",
								"value": 314,
								"name": "Virgin Islands (U.S.)"
							},
							{
								"code": "PS",
								"value": 690,
								"name": "West Bank and Gaza"
							},
							{
								"code": "EH",
								"value": 2,
								"name": "Western Sahara"
							},
							{
								"code": "YE",
								"value": 46,
								"name": "Yemen, Rep."
							},
							{
								"code": "ZM",
								"value": 17,
								"name": "Zambia"
							},
							{
								"code": "ZW",
								"value": 32,
								"name": "Zimbabwe"
							}
						];
						console.log(data.length);
						$('#change_here_map').highcharts('Map', {
							title: {
								text: 'Exploration of space Lels'
							},
							subtitle : {
								text : 'Experimental setup'
							},
								mapNavigation: {
								enabled: true,
								buttonOptions: {
									verticalAlign: 'bottom'
								}
							},
							colorAxis:{
								min: 1,
								max: 3400,
								type: 'logarithmic'
							},
							series : [{
								data : data,
								mapData: Highcharts.maps['custom/world'],
								joinBy: ['iso-a2', 'code'],
								name: 'Population density',
								borderColor: 'black',
								borderWidth: 0.2,
								states: {
									hover: {
										borderWidth: 1
									}
								},
								tooltip: {
									valueSuffix: '/km²'
								}
							}]
						});
					},
					error: function(err) {
						$('#change_here_map').html(err);
					}
				});
			}
		});
	});

	function serialize_form()
	{
		return $("#interactivesearch").serialize();
	}

	function getValues(){											// getting the query
		if(! validateValues()) return false;
		var children=$(".query").children(".clone");
		if(children.length==0) return false;
		var querystring="";
		
		// console.log(children.length);
		for(var i=0; i<children.length; i++){
			if(i>0) querystring+="&";
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
		$("#values").val(querystring);
		console.log(querystring);
		return true;
	}

	function operationValues(op, operator){									// within and and or operations --  recursive function
		var querystring="";
		var item=$(op);
		var j=0;
		console.log("OPERATION VALUES!!!");
		console.log("operator: "+operator);
		console.log("operationValues: ");
		console.log(item);
		if(item.children('.compare').length + item.children('.op').length < 2){
			alert("For operations, supply at least two possible values (value/operation)");
			return false;
		}

		if(item.children('.compare').length > 0){	
			j=1;
			for(var i=0; i<item.children('.compare').length; i++){	
				if(i>0) querystring+=",";
				querystring+="Val("+item.children('.compare')[i].value+","+item.children('.value')[i].value+")";
			}
			console.log("Compare: "+querystring);
		}
		if(item.children('.op').length > 0){
			console.log("Parent: ");
			console.log(item);
			var childop=item.children('.op');
			console.log("Children: ");
			console.log(childop);
			console.log(childop.length);
			if(childop.length > 0){	
				var val=new Array();
				for (var l=0; l<childop.length; l++) {
					console.log("children of l: "+l);
					console.log(childop[l]);
					val.push(operationValues(childop[l], childop.children('.operator')[0].innerText));
				}
				console.log(val);

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

	function validateValues(){
		var children=$(".query").children(".clone");
		for(var i=0; i<children.length; i++){
			var child=$(children[i]);
			var querystring=child.children('.view')[0].innerText;
			// console.log(querystring);
			// console.log(querystring.match(/^[A-Za-z0-9_\- ]*$/));
			if(! querystring.match(/^[A-Za-z0-9_\-\s]*$/)){
				alert("Fix Values Query!");
				return false;
			}
			var compare=child.find('.compare');
			var comparelength=compare.length;
			if(comparelength > 0){				// single constraint
				var value=child.find('.value');
				for(var j=0; j<comparelength; j++){
					comparestring=compare[j].value;
					// console.log(comparestring);
					// console.log(comparestring.match(/^[A-Za-z0-9_\- ]*$/));
					if(! comparestring.match(/^[A-Za-z0-9_\-\s]*$/)){
						alert("Fix Values Compare!");
						return false;
					}
					valuestring=value[j].value;
					// console.log(valuestring);
					// console.log(valuestring.match(/^[A-Za-z0-9_\- @\.%]*$/));
					if(! valuestring.match(/^[A-Za-z0-9_\-\s@\.%]*$/)){
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
			// $(ui.draggable).css("background", "#ddd");
			// var original=$(ui.draggable).hasClass('original');
			$(ui.draggable).draggable("disable");
			var clone = $(ui.draggable).clone();
			clone.removeClass('original');
			$(ui.draggable).css("background", "#ddd");
			clone.children('.lbl').attr("data-toggle", "dropdown");
			clone.children('.lbl').addClass("dropdown-toggle");
			var label=clone.children('.lbl').text();
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
			clone.css('top', 0).css('left', 0).css('clear', 'both').css('z-index', '');
			clone.addClass('clone');
			clone.prepend(mod);
			clone.append(options);
			$(this).append(clone);
			
			if($(ui.draggable).hasClass('draggable')){
				clone.draggable();
			}
		}
		else{													// duplicate of a clone -- sort
			var item=$(ui.draggable).detach();
			item.css('top', 0).css('left', 0).css('clear', 'both');
			$(this).append(item);
		}
	}

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

	$(".query").droppable({
		drop: handleDropEvent
	});

	$(document).on('click', '.rem', function(){
		if($(this).parent().hasClass('clone')){		// enable original
			var views=$('.view');
			for(var i=0; i<views.length; i++){
				if($(views[i]).text()==$(this).parent().children('.view').text()){
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
			console.log(secparent.children('.lbl'));
			secparent.children('.lbl').addClass("dropdown-toggle");
			secparent.children('.lbl').attr("data-toggle", "dropdown");
		}
	});

	$(document).on('click', '.single', function(){
		var single=$(consinput);
		
		$(this).parent().parent().append(single);
		$(this).parent().parent().css('z-index', '');
		$(this).parent().remove();
		single.siblings(".caret").remove();
	});

	$(document).on('click', '.add-cons', function(){
		var single=$(consinput);
		$(this).parent().parent().append(single);
	});

	$(document).on('click', '.and', function(){
		var secparent = $(this).parent().parent();
		if(secparent.hasClass("clone")){						// remove caret and other attributes and classes
			secparent.children().remove(".caret");
			secparent.children().remove(".dropdown-menu");
			secparent.children('.lbl').removeAttr("data-toggle");
			secparent.children('.lbl').removeClass("dropdown-toggle");
		}
		var mod=$("<span class='rem opt'>X</span><span class='caret opt' data-toggle='dropdown'>");
		var options=$("<ul class='dropdown-menu'><li class='dropdown-item add-cons'><a>Add Constraint</li><li class='dropdown-item or'><a>Multiple Constraints (Or)</a></li></ul>");
		var andop=$("<div class='op resizable'><span class='lbl operator dropdown-toggle' data-toggle='dropdown'>And</span></div>");
		andop.css("display", "table");
		andop.prepend(mod);
		andop.append(options);
		secparent.append(andop);
	});

	$(document).on('click', '.or', function(){
		var secparent = $(this).parent().parent();
		if(secparent.hasClass("clone")){						// remove caret and other attributes and classes
			secparent.children().remove(".caret");
			secparent.children().remove(".caret");
			secparent.children().remove(".dropdown-menu");
			secparent.children('.lbl').removeAttr("data-toggle");
			secparent.children('.lbl').removeClass("dropdown-toggle");
		}

		var mod=$("<span class='rem opt'>X</span><span class='caret opt' data-toggle='dropdown'>");
		var options=$("<ul class='dropdown-menu'><li class='dropdown-item add-cons'><a>Add Constraint</li><li class='dropdown-item and'><a>Multiple Constraints (And)</a></li></ul>");
		var orop=$("<div class='op resizable'><span class='lbl operator dropdown-toggle' data-toggle='dropdown'>Or</span></div>");
		orop.css("display", "table");
		orop.prepend(mod);
		orop.append(options);
		secparent.append(orop);
	});
});

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