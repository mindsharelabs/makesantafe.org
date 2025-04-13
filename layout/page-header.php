<?php

	$color = (get_field('color') ? get_field('color') : '#be202e');
	$background_str = 'background-color:' . $color;
	echo '<style>
		#header-logo-holder, #intro-logo-holder {
			background: ' . $color . '; 
			background: radial-gradient(circle, ' . $color . ' 0%, rgba(50,50,50,1) 100%);
		}
	</style>';

if(is_front_page(  )) :
	echo '<header class="page-header container-fluid px-0" style="' . $background_str . '">';
	  echo '<div class="header-padding">';
	    echo '<div id="intro-logo-holder">';
	      echo '<svg id="intro-logo-load" width="100%" height="100%" ></svg>';
	    echo '</div>';
	  echo '</div>';
	echo '</header>';
else :
	echo '<header class="page-header container-fluid px-0" style="' . $background_str . '">';
	  echo '<div class="header-padding">';
	  	echo '<div class="title-container">';
			if($image = get_field('badge_image')) :
				echo '<div class="badge-image-holder">';
					echo wp_get_attachment_image($image);
				echo '</div>';
			endif;

			if(is_archive() || is_post_type_archive()) :
				echo '<h1 class="page-title">' . post_type_archive_title('', false) . '</h1>';
			elseif(is_tax()) :
				$term = get_queried_object();
				echo '<h1 class="page-title">' . $term->name . '</h1>';
			elseif(is_single()) :
				echo '<h1 class="page-title">' . get_the_title() . '</h1>';
			elseif(is_page()) :
				echo '<h1 class="page-title">' . get_the_title() . '</h1>';
			endif;

			
		echo '</div>';
		




	    echo '<div id="intro-logo-holder">';
	      echo '<svg id="sub-page-header" width="100%" height="100%" ></svg>';
	    echo '</div>';
	  echo '</div>';
	echo '</header>';
endif;


