<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title><?php wp_title( ); ?></title>
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/ie/html5.js" type="text/javascript"></script>
<![endif]-->
<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.png" type="image/png" />
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
   	<header class="kiosk-header">
		<div id="kiosk-logo">

					<svg id="header-logo-load" width="100%" height="100%" viewBox="0 0 370 240"></svg>

		</div>
   	</header>
	<div class="container-fluid">
		<div class="row">
			<div id="content" class="main-content-inner">
