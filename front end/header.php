<?php


if( isset($_POST['email'],$_POST['suburb'],$_POST['action']) && $_POST['action']=='Subscribe' ){

	try{
		$data_email = mysqli_real_escape_string($mysqli_connect, $_POST['email']);
		$data_suburb = mysqli_real_escape_string($mysqli_connect, $_POST['suburb']);
		$data_create_time = gmdate('Y-m-d H:i:s');
		//$query = mysqli_query( $mysqli_connect, "INSERT INTO `subscriptions` (`email`, `suburb`, `status`, `create_time`) VALUES ('$data_email', '$data_suburb', 'active', '$data_create_time')");
		//$subscribe_notice_text = $query ? 'Subscription has recorded successfully' : 'Subscription has recorded fail!';

		$query = mysqli_query( $mysqli_connect, "INSERT INTO `subscriptions` (`email`, `suburb`, `status`, `create_time`)
		SELECT '$data_email' AS `t_email`, '$data_suburb' AS `t_suburb`, 'active' AS `t_status`, '$data_create_time' as `t_time`
		WHERE NOT EXISTS (SELECT * FROM `subscriptions` WHERE `email`='$data_email')");

		if( mysqli_insert_id( $mysqli_connect ) ){
			$subscribe_notice_text = 'Subscription has recorded successfully';
		}else{
			$subscribe_notice_text = 'Subscription has recorded fail!';
		}
		
	}catch(Exception $err){
		$subscribe_notice_text = 'Subscription has recorded fail! Error:' . $err->getMessage();
	}

	/*
	// redirect to redirect URL
	if( isset($_POST['redirect']) && $_POST['redirect'] != $_SERVER['REQUEST_URI'] ){
		header('location: ' . $_POST['redirect']); exit;
	}
	*/
}

?>

	<header id="header" class="header">
		<div class="container container-header">
			<a href="/" class="branding">
				<img class="logo-img" src="/assets/icons/logo.png" width="64" height="34" alt="" class="logo">
				<div class="logo-type">
					<h1 class="site-title">Hongkong Flood Hub</h1>
					<small class="site-description">Flood Intelligence Dashboard</small>
				</div>
			</a>
			<!-- Default snippet for navigation -->
			<div id="main-navigation" class="main-navigation">
				<button type="button" id="menu-toggle" class="menu-toggle"><i class="fa fa-bars"></i></button>
				<ul id="main-navigation-menu" class="menu">
					<li class="menu-item<?php echo in_array( $path, array('/', '') ) ? ' current-menu-item' : ''; ?>"><a href="/">Home</a></li>
					<li class="menu-item<?php echo in_array( $path, array( '/predictions', '/predictions/' ) ) ? ' current-menu-item' : ''; ?>"><a href="/predictions">Predictions</a></li>
					<li class="menu-item<?php echo in_array( $path, array('/admin', '/admin/') ) ? ' current-menu-item' : ''; ?>"><a href="/admin">Admin</a></li>
					<li class="menu-item<?php echo in_array( $path, array( '/subscribe', '/subscribe/' ) ) ? ' current-menu-item' : ''; ?>"><a href="/subscribe">Subscribe</a></li>
					<li class="menu-item<?php echo in_array( $path, array( '/contact', '/contact/') ) ? ' current-menu-item' : ''; ?>"><a href="/contact">Contact</a></li>
				</ul> <!-- .menu -->
			</div> <!-- .main-navigation -->
		</div>
	</header>

	<main id="main" class="main">
		