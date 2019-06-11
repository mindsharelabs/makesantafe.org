<?php

$color = get_field('cert_color');
$icon = get_field('cert_icon');
$icon_back = get_field('cert_icon_back')
?>
<!-- article -->
<article id="post-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>
    <div class="row">
        <div class="col-4 col-md-2 pl-0">
          <!-- post image -->
          <?php
          echo '<div class="cert-holder m-1">';
            echo '<span class="fa-stack fa-3x">';
              echo '<i class="' . $icon_back . ' fa-stack-2x" style="color:' . $color . '"></i>';
              echo '<i class="' . $icon . ' fa-stack-1x fa-inverse"></i>';
            echo '</span>';
          echo '</div>';
          ?>
          <!-- /post image -->
        </div>
          <div class="col-8 col-md-10">
            <!-- post title -->
            <h5 class="post-title">
              <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_title(); ?>
              </a>
            </h5>
            <?php
            $short_desc = get_field('short_description');
            if($short_desc) {
              echo $short_desc;
            };
            ?>
            <!-- /post title -->
          </div>
        </div>
    <hr/>
</article>
<!-- /article -->
