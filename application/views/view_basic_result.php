<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<div id="search_result">
			<h3>Basic Search Results</h3>
			<?php
				if(isset($no_results)){
					// echo $no_results;
					echo "<h5 class='no-content'>No results.<h5>";
				}
				else{
					echo "<table class='table table-hover table-bordered' >";
					echo "<th>Student Number</th>";
					echo "<th>Name</th>";
					echo "<th>Email Address</th>";
					// var_dump($data);
					// echo var_dump($result);
					// echo var_dump($result['results']);
					// for($i=0; $i<count($results); $i++){
					foreach ($results as $row){
						// echo $results[$i];
					    echo "<tr><td>".$row->student_no."</td>";
						echo "<td>".$row->firstname." ".$row->lastname."</td>";
						echo "<td>".$row->email."</td></tr>";
					} 
					echo "</table>";
					echo $links;
				}
			?>
		</div>
	</div>
</div>
