<?php
echo '<div class="row">';
  echo '<div class="col-8 offset-2">';
    echo '<div class="pagination">';
    if(function_exists('facetwp_display')) :
      echo facetwp_display( 'facet', 'pagination' );
    else :
      mindwp_pagination();
    endif;
    echo '</div>';
  echo '</div>';
echo '</div>';
