<header class="header top-header" role="banner">
  <div class="container">
    <div class="row">
        <div class="col-1">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
            <svg id="header-logo-load" width="100%" height="100%" viewBox="0 0 370 240"></svg>
          </a>
        </div>

        <div class="col my-auto">
          <nav class="desktop d-none d-md-block text-right">
            <?php
            if(is_user_logged_in()) :
              mindblank_nav('member-menu');
            else :
              mindblank_nav('header-menu');
            endif;
            ?>
          </nav>
        </div>
        <div class="col-2 text-right my-auto">
            <?php
            if($icons = get_field('header_icons', 'options')) :
              foreach ($icons as $icon) :
                echo '<a href="' . $icon['link'] . '" class="icon">';
                  echo '<i class="' . $icon['icon'] . '"></i>';
                echo '</a>';
              endforeach;
            endif;
            ?>
            <span class="menu-toggle"><i class="fas fa-bars"></i></span>
          </div>

    </div>
  </div>
</header>
