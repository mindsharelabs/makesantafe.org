<?php get_header();

include 'layout/page-header.php';
?>
<main role="main" aria-label="Content" class="container-fluid">
    <div class="row">
      <?php get_sidebar(); ?>
        <div class="col-xs-12 col-md-8 has-sidebar">
            <!-- section -->
            <section>
                <h1><?php the_title(); ?></h1>

                <?php if (have_posts()): while (have_posts()) : the_post(); ?>

                    <!-- article -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php the_content();

                            $variable_content = get_field('variable_content');
                            if ($variable_content):
                                    foreach ($variable_content as $content) :
                                        echo '<div class="row variable-content">';
                                        if($content["acf_fc_layout"] === 'wysiwyg'):
                                            echo '<div class="col-12 ' . $content['acf_fc_layout'] . '">' . $content['content'] . '</div>';
                                        elseif ($content['acf_fc_layout'] === 'image_with_text') :
                                            $image = $content['image']['url'];
                                            $image_url = aq_resize($content['image']['url'], 1300);

                                            echo '<div class="col-12 ' . $content['acf_fc_layout'] . '">';
                                                echo '<div class="image-background" style="background-image: url(' . $image_url . ')">';
                                                    echo '<a href="' . $content['link'] . '">';
                                                        echo '<h2 class="text-overlay">' . $content['text'] . '</h2>';
                                                    echo '</a>';
                                                echo '</div>';
                                            echo '</div>';

                                        elseif ($content['acf_fc_layout'] === 'column_content') :
                                            foreach ($content['column'] as $column) :
                                                echo '<div class="col color-back ' . $content['acf_fc_layout'] . '">';
                                                    echo $column['content'];
                                                echo '</div>';
                                            endforeach;
                                        elseif ($content['acf_fc_layout'] === 'heading') :
                                            echo '<div class="col ' . $content['acf_fc_layout'] . '">';
                                                echo '<' . $content['heading_level'] . '>';
                                                    echo $content['heading_text'];
                                                echo '</' . $content['heading_level'] . '>';
                                            echo '</div>';
                                        elseif ($content['acf_fc_layout'] === 'call_to_action') :
                                            echo '<div class="col-12 col-md-8 offset-md-2 text-center ' . $content['acf_fc_layout'] . '">';
                                                echo '<h2>';
                                                    echo $content['header'];
                                                echo '</h2>';
                                                echo '<hr>';
                                                echo '<div class="description text-center">';
                                                    echo $content['description'];
                                                echo '</div>';
                                                if($content['button_label'] && $content['url']) :
                                                  echo '<a class="btn btn-lrg btn-primary mt-4" href="' . $content['url'] . '">' . $content['button_label'] . '</a>';
                                                endif;
                                            echo '</div>';
                                        else :
                                            mapi_var_dump($content);
                                        endif;

                                        echo '</div>';
                                    endforeach;

                            endif;
                            ?>

                        <?php edit_post_link(); ?>

                    </article>
                    <!-- /article -->

                <?php endwhile; ?>


                <?php endif; ?>

            </section>
        </div>

    </div>
            <!-- /section -->
</main>

<?php include 'layout/top-footer.php';
get_footer();
