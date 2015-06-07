<!DOCTYPE html>

<html>
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
		<title><?php echo $titlepage?></title>
		<meta name="description" content="UPLB Office of Student Affairs"/>
		<meta name="keywords" content="uplb, osa, uplbosa, gtracer, graduate" />
		<meta name="author" content="OSA-COMMIT:CIA" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>mod/css/all.css">
		<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php echo base_url(); ?>mod/img/favicon.ico" >
		<script type="text/javascript" src="<?php echo base_url(); ?>mod/js/modernizr.custom.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>mod/js/jquery-2.0.3.js"></script>
		<script type="text/javascript">
			var base_url="<?php echo base_url()?>";
		</script>
	</head>
	<body>
		<div id="container" class="container" >
			<div class="content">
				<header class="header content-header">
					<div class="header-component">
						<div class="header-image">
							<img src="<?php echo base_url(); ?>mod/img/osam-logo.png" />
						</div>
						<span id="header-minor">University of the Philippines Los Banos</span>
						<span id="header-major">Office of Student Affairs - GTracer</span>
					</div>
				</header>
				<div class="content-inner">
					<section id="content-drawer" class="header content-drawer">
						<div id="content-login" class="content-login" >
							<div class="login-component"></div>
							<div class="login-icon">
								<svg width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 300 100">
									<defs>
										<filter id="svg-shadow" x="0" y="0" width="200%" height="200%" >
											<feOffset result="offset" in="SourceAlpha" dx="0" dy="5" />
											<feGaussianBlur result="shadow" in="offset" stdDeviation="10" />
											<feComponentTransfer>
												<feFuncA type="linear" slope="0.5" />
											</feComponentTransfer>
											<feMerge>
												<feMergeNode />
												<feMergeNode in="SourceGraphic"/>
											</feMerge>
										</filter>
									</defs>
									<path fill="#222" d="M 0 0 L 0 29 C 120 30 200 70 300 35 L 300 0 Z" filter="url(#svg-shadow)"/>
									<!-- <path fill="#222" d="M 0 0 L 0 35 C 100 70 180 5 300 5 L 300 0 Z" filter="url(#svg-shadow)"/> -->
									<!-- <path class="" fill="#222" d="M 0 0 L 0 5 L 5 5 C 200 10 350 80 600 70 Q 750 65 850 40 L 850 0 Z" filter="url(#svg-shadow)"/> -->
								</svg>
								<div id="login-button">
									<?php 
										if($this->session->userdata('logged_in') == TRUE){
											echo "<a class='logout' href='".base_url()."controller_login/logout'>Sign out</a>";
										}
									?>
								</div>
							</div>
						</div>
						<div id="content-des" class="content-des">
							<div class="des-filler">

							</div>
							<div class="des">
								<svg id="des-svg" width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 850 100">
									<def>
										<filter id="svg-shadow" x="0" y="0" width="200%" height="200%" >
											<feOffset result="offset" in="SourceAlpha" dx="0" dy="5" />
											<feGaussianBlur result="shadow" in="offset" stdDeviation="10" />
											<feComponentTransfer>
												<feFuncA type="linear" slope="0.5" />
											</feComponentTransfer>
											<feMerge>
												<feMergeNode />
												<feMergeNode in="SourceGraphic"/>
											</feMerge>
										</filter>
									</def>
									<path class="" fill="#222" d="M 850 0 L 850 35 L 845 35 C 650 30 500 80 250 70 Q 100 65 0 40 L 0 0 Z" filter="url(#svg-shadow)"/>									
									<!-- <path class="" fill="#222" d="M 0 0 L 0 5 L 5 5 C 200 10 350 80 600 70 Q 750 65 850 40 L 850 0 Z" filter="url(#svg-shadow)"/>									 -->
									<!-- <path fill="#222" d="M 0 0 L 0 35 C 100 70 180 5 300 5 L 300 0 Z" filter="url(#svg-shadow)"/> -->
								</svg>
							</div>
						</div>
					</section>