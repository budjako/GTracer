<div id="content-box" class="content-box clearfix">
	<div class="inner-content">
		<h3>Home</h3>
		<?php if (isset($authUrl)){ ?>
			<div id="content">
				<center>
					<a href="<?php echo $authUrl; ?>">
						<img id="google_signin" src="<?php echo base_url(); ?>img/g_login.jpg" width="100%" >
					</a>
				</center>
			</div>
		<?php }else{ 
				var_dump($userData);
			?>
			<header id="info">
				<a target="_blank" class="user_name" href="<?php echo $userData->link; ?>" /><img class="user_img" src="<?php echo $userData->picture; ?>" width="15%" />
				<?php echo '<p class="welcome"><i>Welcome ! </i>' . $userData->name . "</p>"; ?></a><a class='logout' href='https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=<?php echo base_url(); ?>controller_home'>Logout</a>
			</header>
		<?php
			echo "<p class='profile'>Profile :-</p>";
			echo "<p><b> First Name : </b>" . $userData->given_name . "</p>";
			echo "<p><b> Last Name : </b>" . $userData->family_name . "</p>";
			echo "<p><b> Gender : </b>" . $userData->gender . "</p>";
			echo "<p><b>Email : </b>" . $userData->email . "</p>";
		?>
		<?php }?>
	</div>
</div>

					