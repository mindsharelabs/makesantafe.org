<?php get_header();?>
<main role="main" aria-label="Content" class="container-fluid">
    <div class="row">
     
      <?php
      echo '<article id="post-' . get_the_ID() . '" class="' . implode(' ', get_post_class('col-12 col-md-10 offset-0 offset-md-1 mt-5')) . '">';

        if (have_posts()):
          while (have_posts()) : the_post();
            the_content();
          endwhile;
        endif;
      echo '</article>';
      ?>
    </div>
</main>
<?php
get_footer();
