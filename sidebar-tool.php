<?php
$p_makers = get_field('proficient_makers', get_the_id());
?>
<!-- sidebar -->
<aside class="sidebar col-md-4 col-12" role="complementary">
	<div class="sidebar-cont">
		<?php
		if($p_makers) :
			echo '<div class="sidebar-content">';
					echo '<h3 class="fancy">PROFICIENT MEMBERS</h3>';
					ob_start();
						include get_template_directory() . '/inc/header-back.php';
					echo ob_get_clean();
						foreach($p_makers as $key => $maker) :
              // mapi_var_dump($maker);
              $public = get_field('display_profile_publicly',  'user_' . $maker['ID']);
              if($public):
  							$thumb = get_field('photo', 'user_' . $maker['ID']);
  							$image = aq_resize($thumb['url'], 200, 200);
                $name = get_field('display_name', 'user_' . $maker['ID']);
                $title = get_field('title', 'user_' . $maker['ID']);
  							echo '<div class="row clear related_content">';
  								if($image) :
  									echo '<div class="col-3 p-1">';
  										echo '<img src="' . $image . '" class="rounded-circle" alt="' . $maker['display_name'] . '">';
  									echo '</div>';
  								endif;
  								echo '<div class="col-9 my-auto">';
  									// echo '<a href="' . get_permalink( $c_post ) . '">';
  										echo '<h4>' . $name . '</h4>';
  									// echo '</a>';
  									echo '<h5>' . $title . '</h5>';
  								echo '</div>';
  							echo '</div>';
              endif;
						endforeach;
			echo '</div>';
		endif;
		?>
		<div class="sidebar-widget mb-4">
			<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-1')) ?>
		</div>

	</div>

</aside>
<!-- /sidebar -->
