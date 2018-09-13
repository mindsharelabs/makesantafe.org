<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="google-site-verification" content="DmGP6Vs89k64G8lsp-E_f-XixBMWjBaLweoVlzIqjdM" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link href="https://plus.google.com/116528284309870318031" rel="publisher" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/ie/html5.js" type="text/javascript"></script>
<![endif]-->
<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.png" type="image/png" />
<?php wp_head(); ?>



<?php
	$mainid = '';
	$homecolor = '';
	if(!get_field('color'))$homecolor = get_field('color',97);//use this to get home page color if no color data.
	if(is_singular('event'))$mainid = 106;


	$words = '';
	$color = '#36383E';
	if(get_field('color',$mainid)){
		$color = get_field('color',$mainid);
		$lightercolor = $linkcolor = shadeColor($color, 20);
		if(is_singular('event')||is_page('learn'))$linkcolor = get_field('color',97);
		//$linkcolor = shadeColor($color, -20);
	}else{
		$lightercolor = $linkcolor=$homecolor;
	};

	$home = false;

	if(is_front_page()){ $words = get_bloginfo('description');$home = true; }else{ $words = get_field('power_words'); };
	wp_localize_script( 'anagram-scripts', 'svgvars', array('words' => strtoupper($words),'color' => $color,'litcolor' => $lightercolor,'home' => $home, 'logo' => get_template_directory_uri()."/img/make-santa-fe.svg", 'intro' => get_template_directory_uri()."/img/banner.svg", 'circuit' => get_template_directory_uri()."/img/circuit.svg" ) );
	 ?>

<style>
	.header-container {background: <?php echo $color; ?>;}
	 h4{ color:<?php echo $color; ?>; }
	 #main-menu input, .btn, .edd-submit.button, .edd-submit.button {    background-color: <?php echo $color; ?>;background: <?php echo $color; ?>;}
    .page-header .page-title{color:<?php echo $color; ?>;}
     #header-flare  path{stroke:<?php echo $lightercolor; ?>;}
     #lines .circle{fill:<?php echo $color; ?>;}
     .home #lines .lines {stroke: <?php echo $color; ?>;}
     .home #lines .circle{fill:#FFF;stroke: <?php echo $color; ?>;}
     a { color: <?php echo $linkcolor; ?>;}
     .cd-main-nav .current-menu-item a { color: <?php echo $color; ?>; }
     .other-details.columns {background: <?php echo $color; ?>;}
     .bg-color {background: <?php echo $color; ?>;}
     .sidebar a {color:<?php echo $color; ?>;}
	 .gfield_label{ color:<?php echo $color; ?>; }
	 #footer-menu .current-menu-item a, #main-menu .current-menu-item a { color: <?php echo $lightercolor; ?>; }


</style>
<script type="text/javascript" async defer src="https://apis.google.com/js/platform.js?publisherid=116528284309870318031"></script>
</head>

<body <?php body_class(); ?>>
   	<header class="cd-header">
		<div id="cd-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
							<div id="header-logo-holder">

    <svg id="header-logo-load" width="100%" height="100%" viewBox="0 0 370 240"></svg>
</div>

							</a></div>

		<nav class="cd-main-nav">
		        <?php wp_nav_menu(
		                array(
		                    'theme_location' => 'header',
		                    'container' => 0,
		                    'menu_class' => '',
		                    'fallback_cb' => '',
		                    'menu_id' => 'header-menu',
		                    'walker' => new wp_bootstrap_navwalker()
		                )
		            ); ?>

		</nav> <!-- cd-main-nav -->
	</header>


<header class="container-fluid header-container">
	<div class="container">
		<div class="navbar" role="navigation">
			<div class="social-nav nav navbar navbar-left hidden-xs">
			<?php $values_social = get_field('social_links','options');
			if ($values_social) :
			foreach($values_social as $value){ ?>
			<a href="<?php echo $value['social_url']; ?>" target="_blank" class="social-link"><i class="fa <?php echo $value['icon']; ?> fa-lg"></i></a>
			<?php };endif;  ?>


	</div>
			<?php wp_nav_menu(
			                array(
			                    'theme_location' => 'primary',
			                    'container' => 0,
			                    'menu_class' => 'nav navbar-nav navbar-right',
			                    'fallback_cb' => '',
			                    'menu_id' => 'main-menu',
			                    'walker' => new wp_bootstrap_navwalker()
			                )
			            ); ?>

		</div>
	</div>
<?php if ( !empty($words) ) : ?>
	<div id="intro-logo-holder">
		<svg id="intro-logo-load" width="100%" height="100%" ></svg>
	</div>
<?php endif; ?>
	</div>
					<?php if ( get_field('site_wide_notice','options') && !muut_is_forum_page() ) {
        		 include('content/sitewide-notice.php');
		} ?>
		<?php if ( get_field('site_wide_notice_members','options') && current_user_can( 'manage_options' ) &&!muut_is_forum_page()  ) {
        		 include('content/sitewide-notice-members.php');
		} ?>
</header><!-- .container -->
<div class="main-content">
	<div class="container-fluid">
		<div class="row">
			<div id="content" class="main-content-inner <?php if(!muut_is_forum_page()){ ?>col-sm-12<?php }; ?>">
