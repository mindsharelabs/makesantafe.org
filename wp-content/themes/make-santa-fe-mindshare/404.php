<?php get_header();

include 'layout/page-header.php';
include 'layout/notice.php';
?>
<main role="main" aria-label="Content" class="container">
  <div class="row">
    <div class="col-8 offset-2">
      <article class="mb-5 " id="post-404">
        <h1 class="text-center mt-5 mb-5"><?php _e('Page not found', 'mindblank'); ?></h1>
        <h3 class="text-center"><?php _e('Try Searching?', 'mindblank'); ?></h3>
        <hr>
        <?php get_search_form(); ?>
        <a href="<?php echo home_url(); ?>" class="btn btn-primary btn-block mt-5"><?php _e('Return home?', 'mindblank'); ?></a>
      </article>
      <!-- /article -->
    </div>
  </div>
</main>

<?php include 'layout/top-footer.php';
get_footer();
