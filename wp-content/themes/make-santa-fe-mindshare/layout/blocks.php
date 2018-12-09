<?php if($blocks = get_field('home_page_blocks', 'options')) : ?>
<section class="blocks background mb-5">
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
          echo '<div class="card">';
            echo '<div class="image">';
              echo '<img class="card-img-top" src="' . $block['image']['url'] . '"/>';
            echo '</div>';
            echo '<div class="card-body text">';
              echo '<h3>' . $block['title'] . '</h3>';
              echo '<span class="content">' . $block['content'] . '</span>';
            echo '</div>';
            echo '<div class="card-body block-button">';
              echo '<a href="' . $block['link'] . '" class="btn btn-primary float-right" title="' . $block['title'] . '">Learn More</a>';
            echo '</div>';
          echo '</div>';
        echo '</div>';
    endforeach;
    ?>
    </div>
  </div>
</section>
<?php endif;
