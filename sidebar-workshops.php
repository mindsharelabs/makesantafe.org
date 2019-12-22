<!-- sidebar -->
<aside class="sidebar col-md-4 col-12 order-last order-md-first" role="complementary">
	<div class="sidebar-cont">
    <div class="sidebar-widget">
  		<?php
      echo '<h3 class="fancy">Filter Events</h3>';
      ob_start();
        include get_template_directory() . '/inc/header-back.php';
      echo ob_get_clean();
      echo '<div class="facet-options">';
  		  echo do_shortcode('[facetwp facet="p_categories"]');
      echo '</div>';
  		?>
    </div>
		<div class="sidebar-widget mb-4">
			<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-1')) ?>
		</div>

	</div>

</aside>
<!-- /sidebar -->
