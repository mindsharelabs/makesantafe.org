<?php if(is_user_logged_in()) : ?>
  <section class="member-menu">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="member-menu w-100 pt-2 pb-2">
            <?php
            wp_nav_menu(
                array(
                  'theme_location' => 'member-menu',
                  'menu' => '',
                  'container' => 'div',
                  'container_class' => 'menu-{menu slug}-container',
                  'container_id' => '',
                  'menu_class' => 'menu',
                  'menu_id' => '',
                  'echo' => true,
                  'fallback_cb' => 'wp_page_menu',
                  'before' => '',
                  'after' => '',
                  'link_before' => '',
                  'link_after' => '',
                  'items_wrap' => '<ul class="d-flex flex-column flex-md-row text-right">%3$s</ul>',
                  'depth' => 1,
                  'walker' => ''
                )
            ); ?>
          </nav>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>
<footer class="footer pt-3">
    <div class="container">
      <div class="row">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widgets')) ?>
      </div>
    </div>
</footer>
