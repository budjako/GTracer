<script type="text/javascript">

	$(document).ready(function() {
		$(".submit-query").click(function get_data(event) {
			var base_url = "<?php echo base_url(); ?>";
			getValues();

			event.preventDefault();
			if($("input:radio[name ='result-view']:checked").val() == "table"){
				$.ajax({
					url: base_url + "controller_interactive_search/query",
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
				$.ajax({
					url: base_url + "controller_interactive_search/query",
					type: 'POST',
					data: serialize_form(),

					success: function(result) {
						var schoollist=['University of the Philippines', 'Ateneo', 'La Salle'];
						$('#change_here_chart').highcharts({
							chart: {
								type: 'bar'
							},
							title: {
								text: 'School Name'
							},
							xAxis: {
								categories: schoollist//['Apples', 'Bananas', 'Oranges']
							},
							yAxis: {
								title: {
									text: 'Population'
								}
							},
							series: [{
								name: 'Population per school',
								data: [1, 0, 4]
							}]
						});
					},
					error: function(err) {
						$('#change_here_chart').html(err);
					}
				});
			}
			else if($("input:radio[name ='result-view']:checked").val() == "map"){
				$.ajax({
					url: base_url + "controller_interactive_search/query",
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
								"value": 313,
								"name": "Philippines"
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
</script>

<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<h3>Interactive Search</h3>
		<!-- <div class="notes">
			<h5>Notes:</h5>
			<span>Supervisor values: 1 for yes</span><br>
			<span>Supervisor values: 1 to 6</span><br>
			<span>0: < 20 000</span><br>
			<span>1: 20 001 - 40 000</span><br>
			<span>2: 40 001 - 60 000</span><br>
			<span>3: 60 001 - 80 000</span><br>
			<span>4: 80 001 - 100 000</span><br>
			<span>5: 100 001 - 150 000</span><br>
			<span>6: >150 001</span><br>
			<span>remove a constraint</span><br>
		</div> -->
		<div id="change_here_table"></div>
		<div id="change_here_chart"></div>
		<div id="change_here_map"></div>

		<center>
			<form name="interactivesearch" id="interactivesearch">
				<input type="hidden" name="values" id="values"></input>
				<input type="submit" class="submit-query btn btn-default" value="Submit Query" ></input><br>
				<input type="radio" name="result-view" id="table" value="table" checked="checked"><label for="table">Table</label></input>
				<input type="radio" name="result-view" id="chart" value="chart"><label for="chart">Chart</label></input>
				<input type="radio" name="result-view" id="map" value="map"><label for="map">Map</label></input>
			</form>
		</center>
		<div class="dragdrop">
			<fieldset class="fields">
				<legend>Fields</legend>
				<fieldset class="fieldcont basicinfo">
					<legend>Basic Info</legend>
					<div class="draggable original"><span class="lbl view">Student Number</span></div>
					<div class="draggable original"><span class="lbl view">First Name</span></div>
					<div class="draggable original"><span class="lbl view">Last Name</span></div>
					<div class="draggable original"><span class="lbl view">Middle Name</span></div>
					<div class="draggable original"><span class="lbl view">Sex</span></div>
					<div class="draggable original"><span class="lbl view">Birth Date</span></div>
					<div class="draggable original"><span class="lbl view">Email</span></div>
					<div class="draggable original"><span class="lbl view">Mobile No</span></div>
					<div class="draggable original"><span class="lbl view">Tel No</span></div>
				</fieldset>
				<fieldset class="fieldcont educbg">
					<legend>Educational Background</legend>
					<div class="draggable original"><span class="lbl view">Year Level</span></div>
					<div class="draggable original"><span class="lbl view">Batch</span></div>
					<div class="draggable original"><span class="lbl view">Class</span></div>
					<div class="draggable original"><span class="lbl view">Course</span></div>
					<div class="draggable original"><span class="lbl view">School Name</span></div>
					<div class="draggable original"><span class="lbl view">School Address</span></div>
				</fieldset>
				<fieldset class="fieldcont works">
					<legend>Work</legend>
					<div class="draggable original"><span class="lbl view">Position</span></div>
					<div class="draggable original"><span class="lbl view">Salary</span></div>
					<div class="draggable original"><span class="lbl view">Supervisor</span></div>
					<div class="draggable original"><span class="lbl view">Employment Status</span></div>
					<div class="draggable original"><span class="lbl view">Employment Start Date</span></div>
					<div class="draggable original"><span class="lbl view">Employment End Date</span></div>
				</fieldset>
				<fieldset class="fieldcont companies">
					<legend>Company</legend>
					<div class="draggable original"><span class="lbl view">Company Name</span></div>
					<div class="draggable original"><span class="lbl view">Company Address</span></div>
				</fieldset>
				<fieldset class="fieldcont projects">
					<legend>Projects</legend>
					<div class="draggable original"><span class="lbl view">Project Title</span></div>
					<div class="draggable original"><span class="lbl view">Project Description</span></div>
					<div class="draggable original"><span class="lbl view">Project Start Date</span></div>
					<div class="draggable original"><span class="lbl view">Project End Date</span></div>
				</fieldset>
				<fieldset class="fieldcont publications">
					<legend>Publications</legend>
					<div class="draggable original"><span class="lbl view">Publication Title</span></div>
					<div class="draggable original"><span class="lbl view">Publication Date</span></div>
					<div class="draggable original"><span class="lbl view">Publication Description</span></div>
					<div class="draggable original"><span class="lbl view">Publisher</span></div>
					<div class="draggable original"><span class="lbl view">Peers</span></div>
				</fieldset>
				<fieldset class="fieldcont awards">
					<legend>Awards</legend>
					<div class="draggable original"><span class="lbl view">Award Title</span></div>
					<div class="draggable original"><span class="lbl view">Awarding Body</span></div>
					<div class="draggable original"><span class="lbl view">Awarding Date</span></div>
				</fieldset>
				<fieldset class="fieldcont grant">
					<legend>Grants</legend>
					<div class="draggable original"><span class="lbl view">Grant Name</span></div>
					<div class="draggable original"><span class="lbl view">Grant Awarding Body</span></div>
					<div class="draggable original"><span class="lbl view">Grant Type</span></div>
					<div class="draggable original"><span class="lbl view">Grant Effective Year</span></div>
				</fieldset>
				<fieldset class="fieldcont others">
					<legend>Others</legend>
					<div class="draggable original"><span class="lbl view">Ability</span></div>
					<div class="draggable original"><span class="lbl view">Association</span></div>
					<div class="draggable original"><span class="lbl view">Language</span></div>
				</fieldset>
			</fieldset>

			<fieldset class="query ui-droppable">
				<legend>Query</legend>
				<!-- <div class="draggable ui-draggable ui-draggable-handle clone" style="z-index: 5; top: 0px; left: 0px; clear: both;">Student Number<span class="caret" data-toggle="dropdown"></span> <span class="rem">X</span></div>
				<div class="draggable ui-draggable ui-draggable-handle clone" style="z-index: 5; top: 0px; left: 0px; clear: both;">First Name<span class="caret" data-toggle="dropdown"></span> <span class="rem">X</span></div>
				<div class="draggable ui-draggable ui-draggable-handle clone" style="z-index: 5; top: 0px; left: 0px; clear: both;">Last Name<span class="caret" data-toggle="dropdown"></span> <span class="rem">X</span></div> -->
				
				<!-- <div class="draggable ui-draggable ui-draggable-handle ui-draggable-disabled clone" style="top: 0px; left: 0px; clear: both;">
					<span class="rem opt">X</span>				
					<span class="caret opt" data-toggle="dropdown"></span>
					<span class="lbl view dropdown-toggle" data-toggle="dropdown">Student Number</span>
					<ul class="dropdown-menu">					
						<li class="dropdown-item single"><a>Single Constraint</a></li>
						<li class="dropdown-item and"><a>Multiple Constraints (And)</a></li>					
						<li class="dropdown-item or"><a>Multiple Constraints (Or)</a></li>				
					</ul>
				</div> -->
			</fieldset>
		</div>
	</div>
</div>