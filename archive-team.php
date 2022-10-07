<?php get_header();
include 'layout/page-header.php';
include 'layout/notice.php';
$sections = array();
$terms = get_terms( array(
    'taxonomy' => 'role',
    'hide_empty' => true,
) );
foreach ($terms as $key => $term) :
  $sections[$term->slug] = array(
    'name' => $term->name
  );
endforeach;
if(have_posts()):
  while (have_posts()) : the_post();

    $post_terms = wp_get_post_terms( get_the_id(), 'role');
    foreach($post_terms as $post_term) :
      if(has_post_thumbnail()){
        $image = get_the_post_thumbnail_url( get_the_id(), 'small-square');
      } else {
        $image = get_template_directory_uri() . '/img/nophoto.svg';
      }
      $name = get_the_title();
      $title = get_field('title');
      $sections[$post_term->slug]['posts'][] = array(
        'image' => $image,
        'name' => $name,
        'title' => $title,
      );


    endforeach;;

  endwhile;
endif;

?>
<main role="main" aria-label="Content" class="container">
  <section <?php post_class('blog team'); ?>>
    <div class="row">
      <?php get_sidebar(); ?>
      <div class="col-12 col-md-8">

        <div class="row">
          <?php
          foreach ($sections as $key => $section) :
            $people = $section['posts'];
            echo '<header class="col-12 fancy-header d-flex">';
              echo '<div class="header-flex-item">';
                echo '<h1 class="page-title ">';
                  echo $section['name'];
                echo '</h1>';
              echo '</div>';
              echo '<div class="header-flex-svg">';
                include get_template_directory() . '/inc/svgheader.php';
              echo '</div>';
            echo '</header>';
            foreach ($people as $key => $person) :
              echo '<div class="col-12 col-md-3">';
                echo '<div class="team-photo p-2">';
                  echo '<img src="' . $person['image'] . '" class="rounded-circle"/>';
                echo '</div>';
                echo '<div class="content">';
                  echo '<h3 class="text-center">' . $person['name'] . '</h3>';
                  echo '<h4 class="text-center">' . $person['title'] . '</h4>';
                echo '</div>';
              echo '</div>';
            endforeach;
          endforeach;
          ?>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <?php get_template_part('pagination'); ?>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
