<?php
$sidebar_content = get_field('sidebar_blocks', get_the_id());
$social_media = get_field('social_media', get_the_ID());
?>
<!-- sidebar -->
<aside class="sidebar col-md-4 col-12 order-last order-md-first" role="complementary">
	<div class="sidebar-cont">
		<?php
		if($sidebar_content) :
			echo '<div class="sidebar-content">';
				foreach($sidebar_content as $s_content) :
					echo '<h3 class="fancy">' . $s_content['title'] . '</h3>';
					ob_start();
						include get_template_directory() . '/inc/header-back.php';
					echo ob_get_clean();
					if($s_content['acf_fc_layout'] == 'related_content'):

						foreach($s_content['related_content'] as $c_post) :
							$thumb = get_the_post_thumbnail_url( $c_post->ID, 'full');
							$image = aq_resize($thumb, 200, 200);
							echo '<div class="row ' . $s_content['acf_fc_layout'] . ' clear">';
								if($image) :
									echo '<div class="col-3 p-1">';
										echo '<img src="' . $image . '" class="rounded-circle" alt="' . $c_post->post_title . '">';
									echo '</div>';
								endif;
								echo '<div class="col-9 my-auto">';
									echo '<a href="' . get_permalink( $c_post ) . '">';
										echo '<h4>' . $c_post->post_title . '</h4>';
									echo '</a>';
									echo '<h5>' . get_field('title', $c_post->ID) . '</h5>';
								echo '</div>';
							echo '</div>';
						endforeach;
					elseif($s_content['acf_fc_layout'] == 'general_content'):
						echo '<div class="sub-content">';
							echo $s_content['text'];
						echo '</div>';
					endif;
				endforeach;
			echo '</div>';
		endif;

		if($social_media) :
			echo '<div class="sidebar-content">';
				echo '<h3 class="fancy">Links</h3>';
				ob_start();
					include get_template_directory() . '/inc/header-back.php';
				echo ob_get_clean();


				echo '<div class="row related-contant pl-5 mb-4">';
				foreach($social_media as $icon) :
					echo '<div class="col">';
						echo '<a href="' . $icon['link'] . '" target="_blank">';
							echo '<i class="' . $icon['icon'] . ' fa-2x"></i>';
						echo '</a>';
					echo '</div>';
				endforeach;
				echo '</div>';
			echo '</div>';


		endif;

		?>
		<div class="sidebar-widget mb-4">
			<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-1')) ?>
		</div>

	</div>

</aside>
<!-- /sidebar -->