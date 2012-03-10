<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> itemscope itemtype="http://schema.org/LocalBusiness" manifest="<?php bloginfo('template_directory'); ?>/offline.appcache">

<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="keywords" content="<?php echo get_option('sa_keywords'); ?>" />
<meta name="description" content="<?php echo get_option('sa_description'); ?>" />

<meta itemprop="name" content="<?php echo get_option('sa_google_keywords'); ?>" />
<meta itemprop="description" content="<?php echo get_option('sa_google_description'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/jquery.fancybox.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/fonts.css" />

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.slides.js"></script>

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_get_archives('type=monthly&format=link'); ?>
<?php wp_head(); ?>
</head>

<body>
<article id="wrapper">
	<header>
		<div id="logo">
			<a href="<?php bloginfo('url'); ?>/"><img src="<?php echo get_option('sa_logo_img'); ?>" alt="<?php echo get_option('sa_logo_alt'); ?>" /></a>
		</div>

		<nav id="menu">
			<ul>
			<li class="menuItem"><a href=""><p>Inicio</p></a></li>
			<li class="menuItem"><a href=""><p>Galeria</p></a></li>
			<li class="menuItem"><a href=""><p>Autor</p></a></li>
			<li class="menuItem"><a href=""><p>Contacto</p></a></li>
			</ul>
		</nav>

		<div id="lang">
		</div>

		<div class="clear"></div>
       </header>