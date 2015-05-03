<div id="content-box" 
	class="<?php
				if($this->session->userdata('logged_in') == FALSE){
					echo "fill-space ";
				}
			?>content-box clearfix">
	<div class="inner-content">
		<div id="message">
			<?php
				if(isset($header)){
					echo "<h3>$header</h3>";
				}

				if(isset($body)){
					echo "<p>$body</p>";
				}
			?>
		</div>
	</div>
</div>