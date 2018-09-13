<?php get_header();
include 'layout/top-header.php';
include 'layout/brand.php';?>

    <main role="main" aria-label="Content" <?php post_class('container'); ?>>
        <div class="row">
            <div class="col-12">
                <!-- section -->
                <section class="container blog">
                    <?php rewind_posts(); ?>
                    <div class="row">
                        <div class="col">
                            <h2 class="section-title"><?php the_archive_title(); ?></h2>
                            <div class="row">
                                <?php while (have_posts()) : the_post(); ?>
                                    <?php get_template_part('loop'); ?>
                                <?php endwhile; ?>

                            </div>
                        </div>
                    </div>
                    <?php get_template_part('pagination'); ?>
                </section>
            </div>
        </div>
        <!-- /section -->
    </main>
<?php include 'layout/top-footer.php';
get_footer();
