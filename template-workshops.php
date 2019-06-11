<?php
//Template Name: Workshop List
get_header();

include 'layout/page-header.php';
include 'layout/notice.php';
$today = new DateTime();
$today_timestamp = $today->format('U');
$workshops = new WP_Query(array (
  'post_type' => 'product',
  'posts_per_page' => -1,
  'meta_query' => array (
    'relation' => 'AND',
    array (
      'key' => 'WooCommerceEventsEvent',
      'value' => 'Event',
      'compare' => '=',
      ),
    array(
      'key' => 'make_event_date_timestamp',
      'value' => $today_timestamp,
      'compare' => '>=',
      ),
    ),
   'order' => 'ASC',
   'orderby'   => 'meta_value_num',
	 'meta_key'  => 'make_event_date_timestamp',
  )
);


?>
<main role="main" aria-label="Content" class="container-fluid">
    <div class="row">
      <?php get_sidebar('workshops'); ?>
        <div class="col-xs-12 col-md-8 has-sidebar">
            <!-- section -->
            <section class="mt-4">
              <?php
              echo '<header class="fancy-header d-flex">';
                echo '<div class="header-flex-item">';
            			echo '<h1 class="page-title ">';
                    the_title();
                  echo '</h1>';
            		echo '</div>';
            		echo '<div class="header-flex-svg">';
            			include get_template_directory() . '/inc/svgheader.php';
            		echo '</div>';
              echo '</header>';
              echo '<hr class="clear">';
              if ($workshops->have_posts()):
                echo '<div class="facetwp-template row">';
                while ($workshops->have_posts()) : $workshops->the_post();
                  get_template_part( 'loop-events');
                endwhile;
                echo '</div>';
              endif; ?>
            </section>
        </div>

    </div>
            <!-- /section -->
</main>

<?php include 'layout/top-footer.php';
get_footer();
