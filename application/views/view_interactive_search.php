<script type="text/javascript">
	var base_url = "<?php echo base_url() ?>";

	$(document).ready(function(){
		$(".submit-query").click(function get_data(event){  
			var values=getValues();

			if(! values) return false;
			event.preventDefault();
			console.log(values);
			$.ajax({
				url: base_url+"controller_interactive_search/query",
				type: 'POST',
				data: {"values" : values},

				success: function(result){
					$('#change_here').html(result);
				},
				error: function(err){
					$('#change_here').html(err);
				}
			});
		});
	});

	function getValues(){											// getting the query
		if(! validateValues()) return false;
		var children=$(".query").children(".clone");
		if(children.length==0) return false;
		var querystring="";
		
		console.log(children.length);
		for(var i=0; i<children.length; i++){
			if(i>0) querystring+="&";
			var child=$(children[i]);
			querystring+=child.children('.view')[0].innerText;		// field to be shown
			
			if(child.children('.compare').length > 0){				// single constraint
				querystring+=":Val("+child.children('.compare').val()+","+child.children('.value').val()+")";
			}
			else if(child.children('.op').length > 0){				// and or or operation
				// console.log(child.children('.op').children('.operator'));
				var operator=child.children('.op').children('.operator')[0].innerText;
				querystring+=":"+operator+"(";
				var retval=operationValues(child.children('.op'), operator);
				//Or(Val(,)) etc.
				// console.log(retval);
				if(! retval) return false; 
				else querystring+=retval+")";
			}
		}
		return querystring;
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
			// console.log()	
			console.log(item);
			var childop=item.children('.op');
			console.log("Children: ");
			console.log(childop);
			console.log(childop.length);
			if(childop.length > 0){	
				// for(var i=0; i<childop.length; i++){	
					var val=new Array();
					for (var l=0; l<childop.length; l++) {
						console.log("children of l: "+l);
						console.log(childop[l]);
						val.push(operationValues(childop[l], childop.children('.operator')[0].innerText));
					};
					console.log(val);

					for(var l=0; l<val.length; l++){
						if(/*l>0 && (*/i>0 || j==1)/*)*/ querystring+=",";
						querystring+=childop.children('.operator')[0].innerText+"(";
						querystring+=val[l]+")";
					}

					if(! querystring) return false;
				// }
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
			if(! querystring.match(/^[A-Za-z0-9_\- ]*$/)){
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
					if(! comparestring.match(/^[A-Za-z0-9_\- ]*$/)){
						alert("Fix Values Compare!");
						return false;
					}
					valuestring=value[j].value;
					// console.log(valuestring);
					// console.log(valuestring.match(/^[A-Za-z0-9_\- @\.%]*$/));
					if(! valuestring.match(/^[A-Za-z0-9_\- @\.%]*$/)){
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
		<div class="notes">
			<h5>Notes:</h5>
			<span>Supervisor values: 1 for yes</span>
			<span>remove a constraint</span>
		</div>
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
				
				
				<div class="draggable ui-draggable ui-draggable-handle clone open" style="top: 0px; left: 0px; clear: both; z-index: 2;">
					<span class="rem opt">X</span>				
					<span class="lbl view" aria-expanded="true">Student Number</span>
					<div class="op" style="display: table;">
						<span class="rem opt">X</span>
						<span class="caret opt" data-toggle="dropdown" aria-expanded="false"></span>
						<span class="lbl operator dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Or</span>
						<ul class="dropdown-menu">
							<li class="dropdown-item add-cons"><a>Add Constraint</a></li>
							<li class="dropdown-item and"><a>Multiple Constraints (And)</a></li></ul><br>		
						<select class="compare">
							<option>Equals</option>			
							<option>Not Equals</option>			
							<option>Less Than</option>			
							<option>Greater Than</option>			
							<option>Less Than or Equal</option>			
							<option>Greater Than or Equal</option>			
							<option>Like</option>			
							<option>Not Like</option>		
						</select>		
						<input type="text" class="value" value="2011-29712"><br>		
						<select class="compare">			
							<option>Equals</option>			
							<option>Not Equals</option>			
							<option>Less Than</option>			
							<option>Greater Than</option>			
							<option>Less Than or Equal</option>			
							<option>Greater Than or Equal</option>			
							<option>Like</option>			
							<option>Not Like</option>		
						</select>		
						<input type="text" class="value" value="2011-53005">
						<div class="op" style="display: table;">
							<span class="rem opt">X</span>
							<span class="caret opt" data-toggle="dropdown" aria-expanded="false"></span>
							<span class="lbl operator dropdown-toggle" data-toggle="dropdown" aria-expanded="true">And</span>
							<ul class="dropdown-menu">
								<li class="dropdown-item add-cons"><a>Add Constraint</a></li>
								<li class="dropdown-item or"><a>Multiple Constraints (Or)</a></li>
							</ul><br>		
							<select class="compare">			
								<option>Equals</option>			
								<option>Not Equals</option>			
								<option>Less Than</option>			
								<option>Greater Than</option>			
								<option>Less Than or Equal</option>			
								<option>Greater Than or Equal</option>			
								<option>Like</option>			
								<option>Not Like</option>		
							</select>		
							<input type="text" class="value" value="2011-36586"><br>		
							<select class="compare">			
								<option>Equals</option>			
								<option>Not Equals</option>			
								<option>Less Than</option>			
								<option>Greater Than</option>			
								<option>Less Than or Equal</option>			
								<option>Greater Than or Equal</option>			
								<option>Like</option>			
								<option>Not Like</option>		
							</select>		
							<input type="text" class="value" value="2011-33788">
						</div>
						
					</div>
				</div>
				<div class="draggable ui-draggable ui-draggable-handle clone open" style="top: 0px; left: 0px; clear: both;">
					<span class="rem opt">X</span>				
					<span class="lbl view" aria-expanded="true">Last Name</span>
					<div class="op resizable" style="display: table;">
						<span class="rem opt">X</span>
						<span class="caret opt" data-toggle="dropdown" aria-expanded="false"></span>
						<span class="lbl operator dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Or</span>
						<ul class="dropdown-menu">
							<li class="dropdown-item add-cons"><a>Add Constraint</a></li>
							<li class="dropdown-item and"><a>Multiple Constraints (And)</a></li>
						</ul><br>		
						<select class="compare">			
							<option>Equals</option>			
							<option>Not Equals</option>			
							<option>Less Than</option>			
							<option>Greater Than</option>			
							<option>Less Than or Equal</option>			
							<option>Greater Than or Equal</option>			
							<option>Like</option>			
							<option>Not Like</option>		
						</select>		
						<input type="text" class="value" value="Dela Rosa"><br>		
						<select class="compare">			
							<option>Equals</option>			
							<option>Not Equals</option>			
							<option>Less Than</option>			
							<option>Greater Than</option>			
							<option>Less Than or Equal</option>			
							<option>Greater Than or Equal</option>			
							<option>Like</option>			
							<option>Not Like</option>		
						</select>		
						<input type="text" class="value" value="De Guzman">
						<div class="op resizable" style="display: table;">
							<span class="rem opt">X</span>
							<span class="caret opt" data-toggle="dropdown" aria-expanded="false"></span>
							<span class="lbl operator dropdown-toggle" data-toggle="dropdown" aria-expanded="true">And</span>
							<ul class="dropdown-menu">
								<li class="dropdown-item add-cons"><a>Add Constraint</a></li>
								<li class="dropdown-item or"><a>Multiple Constraints (Or)</a></li>
							</ul><br>		
							<select class="compare">			
								<option>Equals</option>			
								<option>Not Equals</option>			
								<option>Less Than</option>			
								<option>Greater Than</option>			
								<option>Less Than or Equal</option>			
								<option>Greater Than or Equal</option>			
								<option>Like</option>			
								<option>Not Like</option>		
							</select>		
							<input type="text" class="value" value="Lomibao"><br>		
							<select class="compare">			
								<option>Equals</option>			
								<option>Not Equals</option>			
								<option>Less Than</option>			
								<option>Greater Than</option>			
								<option>Less Than or Equal</option>			
								<option>Greater Than or Equal</option>			
								<option>Like</option>			
								<option>Not Like</option>		
							</select>		
							<input type="text" class="value" value="Contreras">
						</div>
					</div>
				</div>
			</fieldset>
		</div>
		<center><form name="interactivesearch" id="interactivesearch">
			<!-- <input type="radio" name="result-view" id="table" value="table" checked="checked"><label for="table">Table</label></input>
			<input type="radio" name="result-view" id="chart" value="chart"><label for="chart">Chart</label></input>
			<input type="radio" name="result-view" id="map" value="map"><label for="map">Map</label></input>
			<input type="hidden" name="string" id="string" value="asdf"></input> -->
			
				<input type="submit" style="float: right;" class="submit-query btn btn-default" value="Submit Query" ></input>
			
		</form></center>
		<div id="change_here"></div>
	</div>
</div>