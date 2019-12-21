<?php

$notice = get_field('notice_text', 'options');
if($notice):
  echo '<div class="container notice-container p-0 mt-1 mb-1">';
    echo '<div class="row">';
      echo '<div class="col-12">';
        echo '<div class="alert mb-0 alert-primary" role="alert">';
          echo $notice;
        echo '</div>';
      echo '</div>';
    echo '</div>';
  echo '</div>';
endif;
