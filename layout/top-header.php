<header class="header top-header container-fluid" role="banner">
  <div class="container pt-2">
    <div class="row justify-content-between">
        <div class="col-2 my-1 make-logo">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
            <img src="<?php echo get_template_directory_uri() . '/img/logo.svg';?>" class="logo-img"/>
          </a>
        </div>

        <div class="col-8 my-auto d-none d-md-block">
          <nav class="header-menu desktop text-end">
            <?php mindblank_nav('header-menu'); ?>
          </nav>
        </div>
        <div class="col-10 col-md-2 text-end my-auto">
            <?php
            if($icons = get_field('header_icons', 'options')) :
              foreach ($icons as $icon) :
                echo '<a href="' . $icon['link'] . '" class="icon">';
                  echo '<i class="' . $icon['icon'] . '"></i>';
                echo '</a>';
              endforeach;
            endif;
            ?>
          </div>

    </div>
  </div>
</header>
