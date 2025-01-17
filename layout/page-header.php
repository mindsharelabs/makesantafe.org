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
	    echo '<div id="intro-logo-holder">';
	      echo '<svg id="sub-page-header" width="100%" height="100%" ></svg>';
	    echo '</div>';
	  echo '</div>';
	echo '</header>';
endif;


