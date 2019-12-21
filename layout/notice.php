<?php

$notice = get_field('notice_text', 'options');
if($notice):
  echo '<div class="container mt-3 mb-3">';
    echo '<div class="row">';
      echo '<div class="col-12">';
        echo '<div class="alert mb-0 alert-primary" role="alert">';
          echo $notice;
        echo '</div>';
      echo '</div>';
    echo '</div>';
  echo '</div>';
endif;
