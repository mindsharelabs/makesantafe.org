<?php
$id = get_the_id();
$image = get_the_post_thumbnail_url( get_the_id(),'full');
$image_url = aq_resize($image, 300, 200);

$event_date = get_post_meta( $id, 'make_event_date', true );
update_post_meta( $id, 'make_event_date_timestamp', $event_date->format('U') );
// mapi_var_dump(get_post_meta( $id));


$title_attr = the_title_attribute(array('echo' => false));
echo '<div class="col-12 col-sm-6 col-md-4">';
  echo '<div class="card">';
    if($image_url):
      echo '<a href="' . get_permalink() . '" title="' . $title_attr . '">';
        echo '<img class="card-top-image" src="' . $image_url . '" title="' . $title_attr . '" />';
      echo '</a>';
    endif;
    echo '<div class="card-body">';
      echo '<a href="' . get_permalink() . '" title="' . $title_attr . '">';
        echo '<h4 class="workshop-title">' . get_the_title() . '</h4>';
      echo '</a>';
      echo '<div class="event-date">' . $event_date->format('D, M j') . ' at ' . $event_date->format('g:i a') . '</div>';
    echo '</div>';
  echo '</div>';
echo '</div>';
