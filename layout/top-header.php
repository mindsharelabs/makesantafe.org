<header class="header top-header" role="banner">
  <div class="container pt-2">
    <div class="row justify-content-between">
        <div class="col-2 my-1 make-logo">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
            <img src="<?php echo get_template_directory_uri() . '/img/logo.svg';?>" class="logo-img"/>
          </a>
        </div>


        <div class="col-10 offset-0 offset-md-6 col-md-3 text-end my-auto">
            <?php
            if($icons = get_field('header_icons', 'options')) :
              foreach ($icons as $icon) :
                echo '<a href="' . $icon['link'] . '" class="icon">';
                  echo '<i class="' . $icon['icon'] . '"></i>';
                echo '</a>';
              endforeach;

              if(class_exists('woocommerce')) :
                $cart_count = WC()->cart->cart_contents_count; // Set variable for cart item count
                $cart_url = wc_get_cart_url(); 
                echo '<a href="' . $cart_url . '" class="ms-3 icon cart-icon" style="vertical-align: top;" title="Shopping Cart">';
                  echo '<i class="fa-solid fa-shopping-cart fa-sm"></i>';
                  if($cart_count > 0) :
                    echo '<span class="cart-contents-count"><i class="text-success fa-xs fa fa-inverse fa-circle-' . $cart_count . '"></i></span>';
                  endif;
                echo '</a>';


                echo '<a href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . '" class="ms-3 icon account-icon" style="vertical-align: top;" title="My Account">';
                  echo '<i class="fa-solid fa-user"></i>';
                echo '</a>';


              endif;

              


            endif;
            ?>
          </div>

    </div>
    <div class="row">

    </div>
  </div>

    <nav class="header-menu desktop text-center">
      <div class="container">
        <div class="row">
          <div class="col-12 my-auto d-none d-md-block">
              <?php mindblank_nav('header-menu'); ?>
          </div>
        </div>
      </div>
    </nav>

</header>
