<?php get_header();

include 'layout/page-header.php';
include 'layout/notice.php';
?>
    <main role="main" aria-label="Content" class="container">
      <div class="row">
        <div class="col-xs-12 col-md-8">
          <div class="row pl-2 pr-2">
            <div class="col-12">
              <h2 class="section-title">
              <?php
              echo sprintf(__('%s Search Results for ', 'mindblank'), $wp_query->found_posts);
                echo get_search_query(); ?>
              </h2>
            </div>
            <?php
            if (have_posts()):
              while (have_posts()) : the_post();
                get_template_part('loop');
              endwhile;
            else :
              echo '<h3 align="center">You didn\'t find anything.</h3>';
              echo '<hr>';
              get_search_form();
            endif;
            ?>
          </div>
        </div>
        <?php get_sidebar(); ?>
      </div>
      <div class="row">
        <div class="col-12">
          <?php get_template_part('pagination'); ?>
        </div>
      </div>
    </main>
<?php include 'layout/top-footer.php';
get_footer();
