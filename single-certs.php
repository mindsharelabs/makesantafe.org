<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';

$p_makers = make_get_badged_members(get_the_id());


$tool_access = get_posts(array(
	'post_type' => 'tool',
  'posts_per_page' => -1,
	'meta_query' => array(
		array(
			'key' => 'required_badge', // name of custom field
			'value' => '"' . get_the_ID() . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
			'compare' => 'LIKE'
		)
	)
));


?>
<main role="main" aria-label="Content" class="container">
    <div class="row">
        <div class="col-12 text-center">
          <?php
          if($image = get_field('badge_image')) :
            echo '<div class="badge-image-holder m-1 w-50 w-md-25 mx-auto">';
              echo wp_get_attachment_image($image);
            echo '</div>';
          endif;
          echo '<h1 class="page-title text-center text-primary">';
            the_title();
          echo '</h1>';
          ?>
        </div>
        <div class="col-12 col-md-8 offset-0 offset-md-2">
            <!-- section -->
            <section class="mt-4">
              <article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
              <?php

               if (have_posts()): while (have_posts()) : the_post();
                  echo '<div class="col-12">';
                    the_content();
                  echo '</div>';
                endwhile;
              endif;
              ?>
              </article>
            </section>
        </div>

    </div>

</main>
<?php

    if($tool_access) :
      echo '<section class="tool-access">';
        echo '<div class="container">';
          echo '<div class="row pt-4 pb-2 mt-4">';
            echo '<div class="col-12 my-4">';
              echo '<h2 class="strong text-bold text-center">With this badge you gain access to these tools:</h2>';
            echo '</div>';
          echo '</div>';
          echo '<div class="row justify-content-center">';
            foreach($tool_access as $key => $tool) :
              echo make_output_tool_card($tool);
            endforeach;
            echo '</div>';
          echo '</div>';
        echo '</section>';
      endif;
      if($p_makers) :
        echo '<section class="badged-makers">';
          echo '<div class="container">';
            echo '<div class="row pt-4 pb-2 mt-4">';
              echo '<div class="col-12 my-4">';
                echo '<h2 class="strong text-bold text-center">Makers with this Badge</h2>';
              echo '</div>';
            echo '</div>';
            echo '<div class="row justify-content-center">';
              foreach($p_makers as $key => $maker) :
                echo make_output_member_card($maker);
              endforeach;
              echo '</div>';
            echo '</div>';
          echo '</section>';
        endif;


        
      ?>
<?php

get_footer();
