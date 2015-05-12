<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<h3>Interactive Search</h3>
		<!-- <div class="notes">
			<h5>Notes:</h5>
			<span>Supervisor values: 1 for yes</span><br>
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
				<div id="chartspecs"></div>
				<div id="mapspecs"></div>
			</form>
		</center>
		<div class="dragdrop">
			<fieldset class="fields">
				<legend>Fields</legend>
				<fieldset class="fieldcont">
					<legend>Basic Info</legend>
					<div class="draggable basicinfo original ui-draggable ui-draggable-handle ui-draggable-disabled" style="z-index: 2; background: rgb(221, 221, 221);"><span class="lbl nongraph view">Student Number</span></div>
					<div class="draggable basicinfo original"><span class="lbl view">First Name</span></div>
					<div class="draggable basicinfo original"><span class="lbl view">Last Name</span></div>
					<div class="draggable basicinfo original"><span class="lbl view">Middle Name</span></div>
					<div class="draggable basicinfo original ui-draggable ui-draggable-handle ui-draggable-disabled" style="z-index: 2; background: rgb(221, 221, 221);"><span class="lbl view">Sex</span></div>
					<div class="draggable basicinfo original"><span class="lbl nongraph view">Birth Date</span></div>
					<div class="draggable basicinfo original"><span class="lbl view">Email</span></div>
					<div class="draggable basicinfo original"><span class="lbl nongraph view">Mobile No</span></div>
					<div class="draggable basicinfo original"><span class="lbl nongraph view">Tel No</span></div>
				</fieldset>
				<fieldset class="fieldcont">
					<legend>Educational Background</legend>
					<div class="draggable educbg original"><span class="lbl view">Level</span></div>
					<div class="draggable educbg original"><span class="lbl view">Batch</span></div>
					<div class="draggable educbg original"><span class="lbl view">Class</span></div>
					<div class="draggable educbg original sadd"><span class="lbl view">Course</span></div>
					<div class="draggable educbg original sadd"><span class="lbl view">School Name</span></div>
				</fieldset>
				<fieldset class="fieldcont">
					<legend>Work</legend>
					<div class="draggable works original cadd"><span class="lbl view">Position</span></div>
					<div class="draggable works original cadd"><span class="lbl view">Salary</span></div>
					<div class="draggable works original cadd"><span class="lbl view">Supervisor</span></div>
					<div class="draggable works original cadd"><span class="lbl view">Employment Status</span></div>
					<div class="draggable works original"><span class="lbl nongraph view">Employment Start Date</span></div>
					<div class="draggable works original"><span class="lbl nongraph view">Employment End Date</span></div>
					<div class="draggable works original cadd"><span class="lbl view">Company Name</span></div>
				</fieldset>
				<fieldset class="fieldcont">
					<legend>Projects</legend>
					<div class="draggable projects original"><span class="lbl nongraph view">Project Title</span></div>
					<div class="draggable projects original"><span class="lbl nongraph view">Project Description</span></div>
					<div class="draggable projects original"><span class="lbl nongraph view">Project Start Date</span></div>
					<div class="draggable projects original"><span class="lbl nongraph view">Project End Date</span></div>
				</fieldset>
				<fieldset class="fieldcont">
					<legend>Publications</legend>
					<div class="draggable publications original"><span class="lbl nongraph view">Publication Title</span></div>
					<div class="draggable publications original"><span class="lbl nongraph view">Publication Date</span></div>
					<div class="draggable publications original"><span class="lbl nongraph view">Publication Description</span></div>
					<div class="draggable publications original"><span class="lbl nongraph view">Publisher</span></div>
					<div class="draggable publications original"><span class="lbl nongraph view">Peers</span></div>
				</fieldset>
				<fieldset class="fieldcont">
					<legend>Awards</legend>
					<div class="draggable awards original"><span class="lbl nongraph view">Award Title</span></div>
					<div class="draggable awards original"><span class="lbl view">Awarding Body</span></div>
					<div class="draggable awards original"><span class="lbl nongraph view">Awarding Date</span></div>
				</fieldset>
				<fieldset class="fieldcont">
					<legend>Grants</legend>
					<div class="draggable grant original"><span class="lbl view">Grant Name</span></div>
					<div class="draggable grant original"><span class="lbl view">Grant Awarding Body</span></div>
					<div class="draggable grant original"><span class="lbl view">Grant Type</span></div>
					<div class="draggable grant original"><span class="lbl view">Grant Effective Year</span></div>
				</fieldset>
				<fieldset class="fieldcont">
					<legend>Others</legend>
					<div class="draggable others original"><span class="lbl view">Ability</span></div>
					<div class="draggable others original"><span class="lbl view">Association</span></div>
					<div class="draggable others original"><span class="lbl view">Language</span></div>
				</fieldset>
			</fieldset>

			<fieldset class="query ui-droppable">
				<legend>Query</legend>
				<div class="draggable ui-draggable ui-draggable-handle ui-draggable-disabled clone" style="top: 0px; left: 0px; clear: both;">
					<span class="rem opt">X</span>				
					<span class="caret opt" data-toggle="dropdown"></span>
					<span class="lbl nongraph view dropdown-toggle" data-toggle="dropdown">Student Number</span>
					<ul class="dropdown-menu">					
						<li class="dropdown-item single"><a>Single Constraint</a></li>
						<li class="dropdown-item and"><a>Multiple Constraints (And)</a></li>					
						<li class="dropdown-item or"><a>Multiple Constraints (Or)</a></li>				
					</ul>
				</div>
				<div class="draggable ui-draggable ui-draggable-handle ui-draggable-disabled clone" style="top: 0px; left: 0px; clear: both;">
					<span class="rem opt">X</span>				
					<span class="caret opt" data-toggle="dropdown"></span>
					<span class="lbl view dropdown-toggle" data-toggle="dropdown">Sex</span>
					<ul class="dropdown-menu">					
						<li class="dropdown-item single"><a>Single Constraint</a></li>
						<li class="dropdown-item and"><a>Multiple Constraints (And)</a></li>					
						<li class="dropdown-item or"><a>Multiple Constraints (Or)</a></li>				
					</ul>
				</div>
			</fieldset>
		</div>
	</div>
</div>