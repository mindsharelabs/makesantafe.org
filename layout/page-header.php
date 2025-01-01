<?php
if(get_field('show_header')) :
	$color = (get_field('color') ? get_field('color') : '#be202e');
	$background_str = 'background-color:' . $color;
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


