<?php
if(get_field('show_header')) :
	$color = (get_field('color') ? get_field('color') : '#be202e');
	if(has_post_thumbnail()){
		$image = get_the_post_thumbnail_url( get_the_id(), 'page-header');
		$background_str = 'background-image: url(' . $image . ')';
		$color = '#fff';
		$fill = 'transparent';
		$stroke = '#fff';
	} else {
		$background_str = 'background-color:' . $color;
		$fill = 'rgba(1,1,1,.1)';
		$stroke = 'rgba(255,255,255,.3)';
	}

	?>
	<style>
		#header-logo-holder, #intro-logo-holder {
			background: <?php echo $color; ?>; 
			background: radial-gradient(circle, <?php echo $color; ?> 0%, rgba(50,50,50,1) 100%);
		}
	</style>
	<header class="page-header container-fluid px-0" style="<?php echo $background_str; ?>">
	  <div class="header-padding">
	    <div id="intro-logo-holder">
	      <svg id="intro-logo-load" width="100%" height="100%" ></svg>
	    </div>
	  </div>
	</header>
	<?php
endif;


