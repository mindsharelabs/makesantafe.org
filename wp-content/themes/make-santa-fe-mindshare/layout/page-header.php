<?php $color = get_field('color'); ?>
<style>
	.header-container {
    background: <?php echo $color; ?>;
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
<header class="page-header container-fluid" style="background-color:<?php the_field('color'); ?>">
  <div class="header-padding">
    <div id="intro-logo-holder">
      <svg id="intro-logo-load" width="100%" height="100%" ></svg>
    </div>
  </div>
</header>
