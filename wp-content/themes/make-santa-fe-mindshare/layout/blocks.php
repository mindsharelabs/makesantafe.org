<?php if($blocks = get_field('other_details', 'options')) : ?>
<section class="blocks background">
  <div class="container">
    <div class="row">
      <div class="col">
        <h2 class="fancy"><?php the_field('home_block_header', 'options'); ?></h2>
      </div>

    </div>
    <div class="row">
    <?php
    foreach ($blocks as $key => $block) :
        echo '<div class="col-12 col-md-4">';
          echo '<div class="block">';
            echo '<div class="image">';
              echo '<img src="' . $block['image'] . '"/>';
            echo '</div>';
            echo '<div class="text">';
              echo '<h3>' . $block['title'] . '</h3>';
              echo '<span class="content">' . $block['content'] . '</span>';
            echo '</div>';
            echo '<div class="block-button">';
              echo '<a href="' . $block['link_to'] . '" class="btn btn-primary float-right" title="' . $block['title'] . '">Learn More</a>';
            echo '</div>';
          echo '</div>';
        echo '</div>';
    endforeach;
    ?>
    </div>
  </div>
</section>
<?php endif;
