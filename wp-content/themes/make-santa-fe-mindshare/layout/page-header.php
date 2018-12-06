<?php

$color = get_field('color');
if(has_post_thumbnail()){
	$thumb = get_the_post_thumbnail_url( get_the_id(), 'full');
	$image = aq_resize($thumb, 1500, 300);
	$background_str = 'background-image: url(' . $image . ')';
} else {
	$background_str = 'background-color:' . $color;
}

?>
<style>
	.header-container {
    <?php echo $background_str; ?>;
  }
  #header-logo-holder .bigtext, #intro-logo-holder .bigtext {
    fill: #fff;
    color: #fff;
  }
	#intro-logo-load .dot {
    stroke: #fff;
  }
  #intro-logo-load .fills {
    fill: <?php echo shadeColor ($color, 20); ?>;
  }
  #intro-logo-load .lines {
    stroke: #fff;
  }
  #intro-logo-load .circle {
    fill: transparent;
    stroke: #fff;
  }
  .sidebar-cont a {
    color: <?php echo $color; ?>;
  }
  .color-back {
    background-color: <?php echo $color; ?>;
    color: #fff;
  }

</style>
<header class="page-header container-fluid" style="<?php echo $background_str; ?>">
  <div class="header-padding">
    <div id="intro-logo-holder">
      <svg id="intro-logo-load" width="100%" height="100%" ></svg>
    </div>
  </div>
</header>
