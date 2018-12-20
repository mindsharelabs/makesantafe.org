<header class="header top-header container-fluid" role="banner">
  <div class="container">
    <div class="row">
        <div class="col-3 col-sm-2 col-md-2 col-lg-1 mt-2 mt-2">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
            <img src="<?php echo get_template_directory_uri() . '/img/logo.svg';?>"/>
          </a>
        </div>

        <div class="col-9 my-auto d-none d-md-block ">
          <nav class="desktop text-right">
            <?php mindblank_nav('header-menu'); ?>
          </nav>
        </div>
        <div class="col text-right my-auto">
            <?php
            if($icons = get_field('header_icons', 'options')) :
              foreach ($icons as $icon) :
                echo '<a href="' . $icon['link'] . '" class="icon">';
                  echo '<i class="' . $icon['icon'] . '"></i>';
                echo '</a>';
              endforeach;
            endif;
            ?>
            <span class="menu-toggle d-inline d-md-none"><i class="fas fa-bars"></i></span>
          </div>

    </div>
  </div>
</header>
