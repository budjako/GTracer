<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<h1>
			<?php 
				echo $info['basic']->firstname;
				echo " ".$info['basic']->midname;
				echo " ".$info['basic']->lastname;
			?>
		</h1>

		<?php
			// var_dump($info);
			if($info['basic'] != null){
				echo "<div id='basic_info'><h4>Basic Information</h4>";
				echo "<span class='label'>Student Number:</span> <span class='value'>".$info['basic']->student_no."</span></br>";
				echo "<span class='label'>Email Address:</span> <span class='value'>".$info['basic']->email."</span></br>";
				echo "<span class='label'>Sex:</span> <span class='value'>".$info['basic']->sex."</span></br>";
				echo "<span class='label'>Mobile Number:</span> <span class='value'>".$info['basic']->mobileno."</span></br>";
				echo "</div>";
			}

			if($info['ability'] != null){
				echo "<div id='ability'><h4>Abilities</h4>";
				foreach ($info['ability'] as $ability) {
					echo "<span class='value'>".$ability->ability_name."</span></br>";
				}
				echo "</div>";
			}

			if($info['assoc'] != null){
				echo "<div id='assoc'><h4>Associations</h4>";
				foreach ($info['assoc'] as $assoc) {
					echo "<span class='value'>".$assoc->assoc_name."</span></br>";
				}
				echo "</div>";
			}

			if($info['award']){
				echo "<div id='award'><h4>Awards</h4>";
				foreach ($info['award'] as $award) {
					if($award->awardtitle != null)
						echo "<span class='label'>Award Name:</span> <span class='value'>".$award->awardtitle."</span></br>";
					if($award->awardbody != null)
						echo "<span class='label'>Awarding Body:</span> <span class='value'>".$award->awardbody."</span></br>";
					if($award->awarddategiven != null)
						echo "<span class='label'>Date Given:</span> <span class='value'>".$award->awarddategiven."</span></br>";
				}
				echo "</div>";
			}


			if($info['education'] != null){
				echo "<div id='education'><h4>Educational Background</h4>";
				foreach ($info['education'] as $education) {
					echo "<span class='label'>Name:</span> <span class='value'>".$education->schoolname."</span></br>";
					echo "<span class='label'>Attended:</span> <span class='value'>".$education->batch."-".$education->class."</span></br>";
					echo "<span class='label'>Level:</span> <span class='value'>".$education->level."</span></br>";
					if($education->course != null)
						echo "<span class='label'>Course:</span> <span class='value'>".$education->course."</span></br>";
				}
				echo "</div>";
			}

			if($info['grant'] != null){
				echo "<div id='grant'><h4>Grants</h4>";
				foreach ($info['grant'] as $grant) {
					echo "<span class='label'>Grant Name:</span> <span class='value'>".$grant->grant_name."</span></br>";
					if($grant->grantor != null)
						echo "<span class='label'>Granting Body:</span> <span class='value'>".$grant->grantor."</span></br>";
					if($grant->granttype != null)
						echo "<span class='label'>Grant Type:</span> <span class='value'>".$grant->granttype."</span></br>";
					if($grant->grantyear != null)
						echo "<span class='label'>Grant Effective:</span> <span class='value'>".$grant->grantyear."</span></br>";
				}
				echo "</div>";
			}

			if($info['lang'] != null){
				echo "<div id='language'><h4>Languages</h4>";
				foreach ($info['lang'] as $lang) 
					echo "<span class='value'>".$lang->language."</span></br>";
				echo "</div>";
			}

			if($info['profexam'] != null){
				echo "<div id='profexam'><h4>Professional Exams</h4>";
				foreach ($info['profexam'] as $profexam){ 
					echo "<span class='label'>Exam Name:</span>  <span class='value'>".$profexam->prof_exam_name."</span></br>";
					echo "<span class='label'>Date Taken:</span>  <span class='value'>".$profexam->profexamdatetaken."</span></br>";
					echo "<span class='label'>Rating:</span>  <span class='value'>".$profexam->rating."</span></br>";
				}
				echo "</div>";
			}

			if($info['publication'] != null){
				echo "<div id='publication'><h4>Publications</h4>";
				foreach ($info['publication'] as $publication) {
					echo "<span class='label'>Title:</span> <span class='value'>".$publication->publicationtitle."</span></br>";
					echo "<span class='label'>Date:</span> <span class='value'>".$publication->publicationdate."</span></br>";
					if($publication->publicationdesc != null)
						echo "<span class='label'>Description:</span> <span class='value'>".$publication->publicationdesc."</span></br>";
					if($publication->publicationpeers != null)
						echo "<span class='label'>Peers:</span> <span class='value'>".$publication->publicationpeer."</span></br>";
				}
				echo "</div>";
			}

			if($info['work'] != null){
				echo "<div id='work'><h4>Work Experience</h4>";
				foreach ($info['work'] as $work) {
					echo "<span class='label'>Position:</span> <span class='value'>".$work->position."</span></br>";
					echo "<span class='value'>".$work->workdatestart."-".$work->workdateend."</span></br>";
					echo "<span class='label'>Company Name:</span> <span class='value'>".$work->companyname."</span></br>";
					if($work->salary != null){
						echo "<span class='label'>Salary:</span> <span class='value'>";
						if($work->salary == 0) echo "< 20 000";
						else if($work->salary == 1) echo "20 001 - 40 000";
						else if($work->salary == 2) echo "40 001 - 60 000";
						else if($work->salary == 3) echo "60 001 - 80 000";
						else if($work->salary == 4) echo "80 001 - 100 000";
						else if($work->salary == 5) echo "100 001 - 150 000";
						else if($work->salary == 6) echo "> 150 001";
						echo "</span></br>";
					}
					if($work->employmentstatus != null)
						echo "<span class='label'>Employment Status:</span> <span class='value'>".$work->employmentstatus."</span></br>";
					}
				echo "</div>";
			}

		?>
	</div>
</div>

