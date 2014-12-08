<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>

	<!-- General -->
	<meta charset="<?php echo strtolower( get_option('blog_charset') ); ?>">
	<title><?php bloginfo('name'); ?> <?php is_single() ? wp_title('|') : print '| '.get_bloginfo('description'); ?></title>

	<!-- Viewport setup -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Pingback -->
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<!-- Favicons -->
	<link rel="icon" href="<?php echo STARTER_URI; ?>/_images/favicons/favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo STARTER_URI; ?>/_images/favicons/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo STARTER_URI; ?>/_images/favicons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo STARTER_URI; ?>/_images/favicons/apple-touch-icon-114x114.png">

	<!-- DNS Prefetch -->
	<meta http-equiv="x-dns-prefetch-control" content="on">
	<link rel="dns-prefetch" href="//fonts.googleapis.com">
	<link rel="dns-prefetch" href="//s0.wp.com">
	<link rel="dns-prefetch" href="//stats.wp.com">
	<link rel="dns-prefetch" href="//www.google-analytics.com">
	<link rel="dns-prefetch" href="//pixel.wp.com">

	<!-- Conditional JavaScript -->
	<!--[if lt IE 9]>
		<link rel="dns-prefetch" href="//html5shim.googlecode.com">
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Generated -->
	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<div class="bg header">
<div class="container">
	<header class="sixteen columns" id="header" role="banner">
		<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<p class="site-description"><?php bloginfo('description'); ?></p>
	</header><!-- end #header -->
</div>
</div><!-- end .bg.header -->

<div class="bg nav">
	<div class="container" id="nav">
		<nav id="menu" class="sixteen columns" role="navigation">
			<?php starter_menu(); ?>
		</nav><!-- end #menu -->
		<nav class="sixteen columns" id="menu-mobile" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation">
		</nav><!-- end #menu-mobile -->
	</div><!-- end #nav -->
</div><!-- end .bg.nav -->

<div class="bg content">