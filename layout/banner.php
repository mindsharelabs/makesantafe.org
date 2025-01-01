<?php $color = (get_field('color') ? get_field('color') : '#be202e'); ?>
<style>
		#header-logo-holder, #intro-logo-holder {
			background: <?php echo $color; ?>; 
  		background: radial-gradient(circle, <?php echo $color; ?> 0%, rgba(50,50,50,1) 100%);
		}
	</style>

<div id="cd-logo" class="container-fluid px-0">
  <div class="header-padding">
    <div id="header-logo-holder">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
        <svg id="intro-logo-load" width="100%" height="100%" ></svg>
      </a>
    </div>
  </div>
</div>
