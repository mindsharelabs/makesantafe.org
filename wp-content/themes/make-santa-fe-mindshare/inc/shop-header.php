<?php

echo '<div class="row">';
  echo '<div class="col">';
    echo '<h5>Filter by Category</h5>';
    echo facetwp_display( 'facet', 'shop_categories' );
  echo '</div>';


  echo '<div class="col">';
    echo '<h5>Search Products</h5>';
    echo facetwp_display( 'facet', 'product_search' );
  echo '</div>';
echo '</div>';
