<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}
?>
<div class="col-12 col-md-3 mb-4">
    <div <?php wc_product_class( 'h-100 card', $product ); ?>>
        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         */
        do_action( 'woocommerce_before_shop_loop_item' );

        echo get_the_post_thumbnail( $product->get_id(), 'medium', array( 'class' => 'card-img-top mx-auto' ) );;
        echo '<div class="card-header text-center">';

            /**
             * Hook: woocommerce_shop_loop_item_title.
             *
             * @hooked woocommerce_template_loop_product_title - 10
             */
            echo '<a href="' . get_permalink() . '">';
             echo '<h2 class="text-center h3 my-2">' . get_the_title() . '</h2>';
            echo '</a>';//not sure why this a tag needs to be here...
            /**
             * Hook: woocommerce_after_shop_loop_item_title.
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             */
            do_action( 'woocommerce_after_shop_loop_item_title' );


        echo '</div>';
        
        echo '<div class="card-body text-center">';
            echo '<div class="shop-loop-excerpt lh-sm mb-4">';
                // product short description
                the_excerpt();
            echo '</div>';
        echo '</div>';

         echo '<div class="card-footer text-center">';
            /**
             * Hook: woocommerce_after_shop_loop_item.
             *
             * @hooked woocommerce_template_loop_product_link_close - 5
             * @hooked woocommerce_template_loop_add_to_cart - 10
             */
            do_action( 'woocommerce_after_shop_loop_item' );
        echo '</div>';
        ?>
</div>
</div>
