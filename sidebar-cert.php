<?php
$p_makers = make_get_badged_members(get_the_id());
?>
<!-- sidebar -->
<aside class="sidebar col-md-4 col-12" role="complementary">
	<div class="sidebar-cont">
		<?php
		if($p_makers) :
			echo '<div class="sidebar-content">';
					echo '<h3 class="fancy">Makers with this Badge</h3>';
					ob_start();
						include get_template_directory() . '/inc/header-back.php';
					echo ob_get_clean();
						foreach($p_makers as $key => $maker) :
              $member = wc_memberships_is_user_active_member($maker->ID);
              $public = get_field('display_profile_publicly',  'user_' . $maker->ID);
              if($public && $member):
  							$thumb = get_field('photo', 'user_' . $maker->ID);

                $name = get_field('display_name', 'user_' . $maker->ID);
                $title = get_field('title', 'user_' . $maker->ID);
                $link = get_author_posts_url($maker->ID);
                if(!$thumb){
                  $image = get_template_directory_uri() . '/img/no-photo_' . rand(1,5) . '.png';
                } else {
                  $image = aq_resize($thumb['url'], 200, 200);
                }

  							echo '<div class="row clear related_content">';
  								if($image) :
  									echo '<div class="col-3 p-1">';
                      echo '<a href="' . $link . '">';
  										  echo '<img src="' . $image . '" class="rounded-circle" alt="' . $name . '">';
                      echo '</a>';
  									echo '</div>';
  								endif;
  								echo '<div class="col-9 my-auto">';
  									echo '<a href="' . $link . '">';
  										echo '<h4>' . $name . '</h4>';
  									echo '</a>';
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
