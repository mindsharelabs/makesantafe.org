<?php
if(has_post_thumbnail()){
  $thumb = get_the_post_thumbnail_url( get_the_id(), 'full');
  $image = aq_resize($thumb, 300, 300);
} else {
  $image = get_template_directory_uri() . '/img/nophoto.svg';
}
echo '<div class="col-12 col-md-3">';
  echo '<div class="team-photo p-2">';
    echo '<img src="' . $image . '" class="rounded-circle"/>';
  echo '</div>';
  echo '<div class="team-content">';
    echo '<h3 class="text-center">' . get_the_title() . '</h3>';
    echo '<h4 class="text-center">' . get_field('title') . '</h4>';
  echo '</div>';
echo '</div>';
