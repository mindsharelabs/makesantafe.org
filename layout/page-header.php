<?php
if(get_field('show_header')) :
	$color = get_field('color');
	if(has_post_thumbnail()){
		$image = get_the_post_thumbnail_url( get_the_id(), 'page-header');
		$background_str = 'background-image: url(' . $image . ')';
		$color = '#fff';
		$fill = 'transparent';
		$stroke = '#fff';
	} else {
		$background_str = 'background-color:' . $color;
		$fill = shadeColor ($color, 20);
		$stroke = '#000';
	}

	?>
	<style>
		.header-container {
	    <?php echo $background_str; ?>;
	  }
	  #header-logo-holder .bigtext, #intro-logo-holder .bigtext {
	    fill: #fff;
	    color: #fff;
			font-family: 'Courier Prime', monospace;
    	font-size: 3em;
	  }
		#intro-logo-load .dot {
	    stroke: #fff;
	  }
	  #intro-logo-load .fills {
	    fill: <?php echo $fill; ?>;
	  }
	  #intro-logo-load .lines {
	    stroke: #fff;
	  }
	  #intro-logo-load .circle {
	    fill: #fff;
	    stroke: #fff;
	  }
	  .sidebar-cont a {
	    color: <?php echo $color; ?>;
	  }
	  .color-back {
	    background-color: <?php echo $color; ?>;
	    color: #fff;
	  }
		#intro-logo-load #banner .lines, #intro-logo-load .fills {
			stroke: <?php echo $stroke; ?>
		}
		#circuits .lines{
			stroke: #fff !important;
		}
		#circuits .circles {
			fill: #fff !important;
			stroke: #fff !important;
		}
	</style>
	<header class="page-header container-fluid" style="<?php echo $background_str; ?>">
	  <div class="header-padding">
	    <div id="intro-logo-holder">
	      <svg id="intro-logo-load" width="100%" height="100%" ></svg>
	    </div>
	  </div>
	</header>
	<?php
	if(is_woocommerce_activated()) :
		if(is_product()) :
			echo '<header class="shop-header">';
				echo '<div class="header-padding">';
					echo '<div id="intro-logo-holder">';
						echo '<svg id="intro-logo-load" width="100%" height="100%" ></svg>';
					echo '</div>';
				echo '</div>';
			echo '</header>';
		elseif(is_product_category()) :
			echo '<header class="shop-header">';
				echo '<div class="header-padding">';
					echo '<div id="intro-logo-holder">';
						echo '<svg id="intro-logo-load" width="100%" height="100%" ></svg>';
					echo '</div>';
				echo '</div>';
			echo '</header>';
		endif;
	else :
		echo '<header class="header-padding>';
			echo '<div class="row">';
				echo '<div class="col-12">';

				echo '</div>';
			echo '</div>';
		echo '</header>';
	endif;
endif;


