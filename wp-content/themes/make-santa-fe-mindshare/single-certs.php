<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';


$tools = get_field('allowed_tools');
$associated_products = new WP_Query(array(
  'post_type' => 'product',
  'meta_query' => array(
		array(
			'key' => 'certification_provided', // name of custom field
			'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
			'compare' => 'LIKE'
		)
	)
));

?>
<main role="main" aria-label="Content" class="container-fluid">
    <div class="row">
      <?php get_sidebar('tool'); ?>
        <div class="col-xs-12 col-md-8 has-sidebar">
            <!-- section -->
            <section class="mt-4">
              <article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
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

               if (have_posts()): while (have_posts()) : the_post();

                 if(has_post_thumbnail()){
                   $thumb = get_the_post_thumbnail_url( get_the_id(), 'full');
                   $image = aq_resize($thumb, 400, 400);
                   echo '<div class="col">';
                    echo '<img class="rounded-circle" src="' . $image . '/>';
                   echo '</div>';
                 }

                  echo '<div class="col-12 col-md-8">';
                    the_content();
                  echo '</div>';

                  if($tools) :
                    echo '<div class="col-12 mt-5 pt-3">';
                      echo '<div class="row">';
                        echo '<div class="col-12">';
                          echo '<h4>With this badge you gain access to: </h3>';
                        echo '</div>';
                        foreach($tools as $tool) :
                          $thumb = get_the_post_thumbnail_url( $tool->ID, 'full');
                          $image = aq_resize($thumb, 400, 200);
                          echo '<div class="col-12 col-md-4">';
                            echo '<div class="card  mb-3">';
                              echo '<img class="card-img-top" src="' . $image . '">';
                              echo '<div class="card-body">';
                                echo '<h5>' . $tool->post_title . '</h5>';
                                the_field('short_description', $tool->ID);
                              echo '</div>';
                              echo '<div class="card-body">';
                                echo '<a href="' . get_permalink($tool->ID) . '" class="btn btn-primary btn-block btn-sm">Read More</a>';
                              echo '</div>';
                              // mapi_var_dump($tool);

                            echo '</div>';
                          echo '</div>';
                        endforeach;
                      echo '</div>';
                    echo '</div>';
                  endif;



                endwhile; endif;

                ?>
              </article>
            </section>
        </div>

    </div>

      <?php
      if($associated_products->have_posts()) :
        $products = array();
        while ($associated_products->have_posts()) :
          $associated_products->the_post();
          $products[] = get_the_ID();
        endwhile;
        echo '<section class="row certifications">';
          echo '<div class="container certification-products p-0 pt-5 pb-5">';
            echo '<h3 class="text-center">Get this Badge</h3>';
            echo do_shortcode('[products ids=' . implode($products, ',') . ']');
          echo '</div>';
        echo '</section>';
        wp_reset_query();
      endif;
      ?>

</main>
<?php
include 'layout/top-footer.php';
get_footer();
