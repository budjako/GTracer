<!--
	Shows the personal information of an alumni
-->

<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<h1>
			<?php 
				echo $info['basic']->firstname;				// Print name of student as header of the page
				echo " ".$info['basic']->lastname;
			?>
		</h1>
			<?php 
				if($info['basic'] != null){					// other background details of the alumni
					echo "<br><h5>".$info['basic']->student_no."</h5>";
					echo "<h5>".$info['basic']->email."</h5>";
					echo "<h5>".$info['basic']->sex."</h5>";
				}
			?>
		<div id="alumni_info">
		<?php

			if($info['work'] != null){						// show the working experience of the alumni if there are any
				echo "<div class='alumni_info_sec' id='work'><h4>Work Experience</h4>";
				foreach ($info['work'] as $work) {
					echo "<div class='form-group2 alumni_info_sec'>";
					if($work->currentjob == 1){
						echo "<span class='value bold'>".$work->position."</span></br>";
						echo "<span class='value'>Current Job</span></br>";
						echo "<span class='value'>".$work->companyname."</span></br>";
						echo "<span class='value'>Start Date: ".$work->workdatestart."</span></br>";
					}
					else{
						echo "<span class='value bold'>".$work->position."</span></br>";
						echo "<span class='value'>".$work->companyname."</span></br>";
						echo "<span class='value'>".$work->workdatestart."-".$work->workdateend."</span></br>";
					}
					if($work->salary != null){
						echo "<span class='label col-sm-2 control-label'>Salary:</span> <span class='value'>";
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
						echo "<span class='label col-sm-2 control-label'>Employment Status:</span> <span class='value'>".$work->employmentstatus."</span></br>";
					echo "</div>";
				}
				echo "</div>";
			}

			if($info['profexam'] != null){				// show the professional exams taken by the alumni if there are any
				echo "<div class='alumni_info_sec' id='profexam'><h4>Professional Exams</h4>";
				foreach ($info['profexam'] as $profexam){ 
					echo "<div class='form-group2 alumni_info_sec'>";
					echo "<span class='value bold'>".$profexam->prof_exam_name."</span></br>";
					echo "<span class='value'>".$profexam->profexamdatetaken."</span></br>";
					echo "<span class='value'>Rating: ".$profexam->rating."%</span></br>";
					echo "</div>";
				}
				echo "</div>";
			}

			if($info['publication'] != null){			// show the publications made by the alumni if there are any
				echo "<div class='alumni_info_sec' id='publication'><h4>Publications</h4>";
				foreach ($info['publication'] as $publication) {
					echo "<div class='form-group2 alumni_info_sec'>";
					echo "<span class='value bold'>".$publication->publicationtitle."</span></br>";
					echo "<span class='value'>".$publication->publicationdate."</span></br>";
					if($publication->publicationdesc != null)
						echo "<span class='value'>".$publication->publicationdesc."</span></br>";
					if($publication->publicationpeers != null)
						echo "<span class='value'>Peers: ".$publication->publicationpeer."</span></br>";
					echo "</div>";
				}
				echo "</div>";
			}

			if($info['assoc'] != null){					// show the associations that the alumni have if there are any
				echo "<div class='alumni_info_sec' id='assoc'><h4>Associations</h4>";
				$i=0;
				echo "<div class='form-group2 alumni_info_sec'>";
				foreach ($info['assoc'] as $assoc) {
					if($i>0) echo "<br><br>";
					echo "<span class='value'>".$assoc->assoc_name."</span></br>";
					$i++;
				}
				echo "</div>";
				echo "</div>";
			}

			if($info['award']){							// show the awards received by the alumni if there are any
				echo "<div class='alumni_info_sec' id='award'><h4>Awards</h4>";
				foreach ($info['award'] as $award) {
					echo "<div class='form-group2 alumni_info_sec'>";
					if($award->awardtitle != null)
						echo "<span class='value bold'>".$award->awardtitle."</span></br>";
					if($award->awardbody != null)
						echo "<span class='value'>".$award->awardbody."</span></br>";
					if($award->awarddategiven != null)
						echo "<span class='value'>".$award->awarddategiven."</span></br>";
					echo "</div>";
				}
				echo "</div>";
			}

			if($info['grant'] != null){					// show the grants received by the alumni if there are any
				echo "<div class='alumni_info_sec' id='grant'><h4>Grants</h4>";
				foreach ($info['grant'] as $grant) {
					echo "<div class='form-group2 alumni_info_sec'>";
					echo "<span class='value bold'>".$grant->grant_name."</span></br>";
					if($grant->grantor != null)
						echo "<span class='value'>".$grant->grantor."</span></br>";
					if($grant->granttype != null)
						echo "<span class='value'>".$grant->granttype."</span></br>";
					if($grant->grantyear != null)
						echo "<span class='value'>".$grant->grantyear."</span></br>";
					echo "</div>";
				}
				echo "</div>";
			}

			if($info['lang'] != null){					// show the languages known by the alumni if there are any
				echo "<div class='alumni_info_sec' id='language'><h4>Languages</h4>";
				$i=0;
				echo "<div class='form-group2 alumni_info_sec'>";
				foreach ($info['lang'] as $lang) {
					if($i>0) echo ", ";
					echo "<span class='value'>".$lang->language."</span>";
					$i++;
				}
				echo "</div>";
				echo "</div>";
			}

			if($info['ability'] != null){				// show the abilities specified by the alumni if there are any
				echo "<div class='alumni_info_sec' id='ability'><h4>Abilities</h4>";
				$i=0;
				echo "<div class='form-group2 alumni_info_sec'>";
				foreach ($info['ability'] as $ability) {
					if($i>0) echo ", ";
					echo "<span class='value'>".$ability->ability_name."</span>";
					$i++;
				}
				echo "</div>";
				echo "</div>";
			}

			if($info['education'] != null){				// show the educational background by the alumni if there are any specified
				echo "<div class='alumni_info_sec' id='education'><h4>Educational Background</h4>";
				foreach ($info['education'] as $education) {
					echo "<div class='form-group2 alumni_info_sec'>";
					echo "<span class='value bold'>".$education->level."</span></br>";
					echo "<span class='value'>".$education->schoolname."</span></br>";
					echo "<span class='value'>".$education->batch."-".$education->class."</span></br>";
					if($education->course != null)
						echo "<span class='value'>".$education->course."</span></br>";
					echo "</div>";
				}
				echo "</div>";
			}
		?>
		</div>
	</div>
</div>

