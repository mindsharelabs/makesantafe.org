<?php get_header();
include 'layout/top-header.php';
include 'layout/brand.php';
?>
    <main role="main" aria-label="Content" class="container">
        <div class="row">
            <div class="col-xs-12 col-md-9">
                <section class="container blog">
                    <div class="row">
                        <div class="col">
                            <h2 class="section-title">
                                <?php echo sprintf(__('%s Search Results for ', 'mindblank'), $wp_query->found_posts);
                                echo get_search_query(); ?>
                            </h2>
                            <div class="row">
                                <?php if (have_posts()):

                                    while (have_posts()) : the_post();
                                        get_template_part('loop');
                                    endwhile;


                                else :
                                    echo '<h3 align="center">You didn\'t find anything.</h3>';

                                endif; ?>

                            </div>
                        </div>
                    </div>
                    <?php get_template_part('pagination'); ?>
                </section>
            </div>
            <?php get_sidebar(); ?>
        </div>
        <!-- /section -->
    </main>


<?php include 'layout/top-footer.php';
get_footer();
