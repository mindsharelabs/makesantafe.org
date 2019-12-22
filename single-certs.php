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
      <?php get_sidebar('cert'); ?>
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

                 $color = get_field('cert_color');
                 $icon = get_field('cert_icon');
                 $icon_back = get_field('cert_icon_back');

                 echo '<div class="cert-holder m-1">';
                   echo '<a href="' . get_permalink() . '" class="fa-stack fa-3x">';
                     echo '<i class="' . $icon_back . ' fa-stack-2x" style="color:' . $color . '"></i>';
                     echo '<i class="' . $icon . ' fa-stack-1x fa-inverse"></i>';
                   echo '</a>';
                   //echo '<span class="cert-name text-center d-block">' . get_the_title($cert) . '</span>';
                 echo '</div>';


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
                          echo '<div class="col-12 col-md-4 mb-3">';
                            echo '<div class="card mb-3 h-100">';
                              echo '<img class="card-img-top" src="' . $image . '">';
                              echo '<div class="card-body d-flex flex-column">';
                                echo '<h5>' . $tool->post_title . '</h5>';
                                echo '<p>' . get_field('short_description', $tool->ID) . '</p>';
                                echo '<a href="' . get_permalink($tool->ID) . '" class="btn btn-primary btn-block btn-sm mt-auto">Read More</a>';
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
