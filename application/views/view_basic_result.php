<!--
	Shows the results of the basic search made by the user
-->

<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<div id="search_result">
			<h3>Basic Search Results</h3>
			<?php
				if(isset($no_results)){
					echo "<h5 class='no-content'>No results.<h5>";						// search details specified does not match to any alumni
				}
				else{
					echo "<table class='table table-hover table-bordered' >";			// set table headers
					echo "<th>Student Number</th>";										// table shows only the alumnus's student number, name and email address
					echo "<th>Name</th>";
					echo "<th>Email Address</th>";
					foreach ($results as $row){											// iterate through the results 
					    echo "<tr><td>".$row->student_no."</td>";						// print the results
						echo "<td>".$row->firstname." ".$row->lastname."</td>";
						echo "<td>".$row->email."</td></tr>";
					} 
					echo "</table>";
					echo $links;														// pagination results
				}
			?>
		</div>
	</div>
</div>
