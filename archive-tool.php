<?php get_header();?>
<main role="main" aria-label="Content" <?php post_class('container'); ?>>
  <div class="row">
      <div class="col-12">
        <?php
      

        
            if(have_posts()) :
              echo '<section class="row mt-4 tools">';
              foreach($terms as $term) :
                echo make_output_shop_space($term);
              endforeach;
              echo '</section>';
            endif;

        
        ?>
      </div>
    </div>
  </main>
<?php
get_footer();
