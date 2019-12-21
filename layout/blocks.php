<?php if($blocks = get_field('home_page_blocks', 'options')) : ?>
<section class="blocks background mb-5">
  <div class="container">
	  <div class="row">

      <div class="col-12 text-center">
        <h2 class="h1 text-center pt-2 pb-2 text-primary"><?php the_field('home_block_header', 'options'); ?></h2>

      </div>
    </div>
	  <div class="row">
    <?php
    foreach ($blocks as $key => $block) :
      echo '<div class="col-12 col-md-4 mb-4">';
        echo '<div class="card h-100">';
          if($block['image']['url']) :
            $image_url = make_get_image_html($block['image'], 310, 200, false, 'w-100');
            echo '<div class="image">';
              echo '<a href="' . $block['link'] . '" title="' . $block['title'] . '">';
                echo $image_url;
              echo '</a>';
            echo '</div>';
          endif;
          echo '<div class="card-body text">';
            echo '<h3 class="text-center">' . $block['title'] . '</h3>';
            echo '<div class="content text-center">' . $block['content'] . '</div>';
            echo '<a href="' . $block['link'] . '" class="btn btn-primary btn-block mt-1 mb-1" title="' . $block['title'] . '">Learn More</a>';
          echo '</div>';
        echo '</div>';
      echo '</div>';
    endforeach;
    ?>
    </div>
  </div>
</section>
<?php endif;
