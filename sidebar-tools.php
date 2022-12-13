<?php
$sidebar_content = get_field('sidebar_blocks', get_the_id());
$social_media = get_field('social_media', get_the_ID());
?>
<!-- sidebar -->
<aside class="sidebar col-md-4 col-12 order-last order-md-first" role="complementary">
	<div class="sidebar-cont">
		<?php
		echo '<div class="sidebar-content">';


      echo '<h3 class="fancy">Filter Tools</h3>';
      ob_start();
        include get_template_directory() . '/inc/header-back.php';
      echo ob_get_clean();

      echo '<div class="clear related_content">';
        echo '<h5>Filter by Type</h5>';
        echo facetwp_display( 'facet', 'tool_type' );
      echo '</div>';



    echo '</div>';

		?>
		<div class="sidebar-widget mb-4">
			<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-1')) ?>
		</div>

	</div>

</aside>
<!-- /sidebar -->
