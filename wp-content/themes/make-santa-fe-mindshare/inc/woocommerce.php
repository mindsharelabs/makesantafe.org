<?php
add_theme_support('woocommerce');
add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-lightbox');
add_theme_support('wc-product-gallery-slider');

//remove function attached to woocommerce_before_main_content hook
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
add_action('woocommerce_before_main_content', 'make_woo_before_content_wrapper', 10);

function make_woo_before_content_wrapper() {
  echo '<div class="container mt-5">';
    echo '<div class="row">';
      get_sidebar('shop');
      echo '<div class="col-xs-12 col-md-8 has-sidebar mt-5">';

}

//remove function attached to woocommerce_after_main_content hook
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action('woocommerce_after_main_content', 'make_woo_after_content_wrapper', 10);

function make_woo_after_content_wrapper() {
      echo '</div>';
    echo '</div>';
  echo '</div>';

}
