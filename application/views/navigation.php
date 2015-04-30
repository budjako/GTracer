<section id="content-menu" class="content-menu">
	
	<?php 
		if($this->session->userdata('logged_in')['is_admin'] == 1){
	?>
		<nav id="menu-wrapper" class="menu-component menu-wrapper">
			<button class="menu-trigger">Menu</button>
			<ul class="menu menu-toggle clearfix">
				<li><a href="<?php echo  base_url(); ?>controller_list_alumni"><div class="menu-item">List of all alumni</div></a></li>
				<li><a href="<?php echo  base_url(); ?>controller_basic_search"><div class="menu-item">Basic Search</div></a></li>
				<li><a href="<?php echo  base_url(); ?>controller_interactive_search"><div class="menu-item">Interactive Search</div></a></li>
				<li><a href="<?php echo  base_url(); ?>controller_log"><div class="menu-item">Logs</div></a></li>
				<li><a href="<?php echo  base_url(); ?>controller_users"><div class="menu-item">Users</div></a></li>
			</ul>
		</nav>
	<?php 
		} else if($this->session->userdata('logged_in')['is_admin'] == 0){
	?>
		<nav id="menu-wrapper" class="menu-component menu-wrapper">
			<button class="menu-trigger">Menu</button>
			<ul class="menu menu-toggle clearfix">
				<li><a href="<?php echo  base_url(); ?>controller_list_alumni"><div class="menu-item">List of all alumni</div></a></li>
				<li><a href="<?php echo  base_url(); ?>controller_basic_search"><div class="menu-item">Basic Search</div></a></li>
				<li><a href="<?php echo  base_url(); ?>controller_interactive_search"><div class="menu-item">Interactive Search</div></a></li>
			</ul>
		</nav>
	<?php } ?>
</section>