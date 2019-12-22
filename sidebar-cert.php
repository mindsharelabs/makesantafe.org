<?php
$associated_products = new WP_Query(array(
  'post_type' => 'product',
	'posts_per_page' => 3,
  'meta_query' => array(
		array(
			'key' => 'certification_provided', // name of custom field
			'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
			'compare' => 'LIKE'
		)
	)
));

?>
<!-- sidebar -->
<aside class="sidebar col-md-4 col-12 order-last order-md-first" role="complementary">
	<div class="sidebar-cont">
		<?php
		if($associated_products->have_posts()) :
			$products = array();
			while ($associated_products->have_posts()) :
				$associated_products->the_post();
				$products[] = get_the_ID();
			endwhile;
			if(count($products) > 0) :
				echo '<div class="sidebar-widget certifications mb-4">';
					echo '<h3 class="fancy">Get this Badge</h3>';
					ob_start();
						include get_template_directory() . '/inc/header-back.php';
					echo ob_get_clean();
					echo '<div class="certification-products pb-3">';
						echo do_shortcode('[products columns=1 ids=' . implode($products, ',') . ']');
					echo '</div>';
				echo '</div>';
			endif;
		endif;
		wp_reset_query();
		?>
		<div class="sidebar-widget mb-4">
			<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-1')) ?>
		</div>
	</div>
</aside>
<!-- /sidebar -->
