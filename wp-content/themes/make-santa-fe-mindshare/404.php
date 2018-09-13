<?php
get_header();
include 'layout/top-header.php';
include 'layout/brand.php';
?>
    <main role="main" aria-label="Content" class="container">
        <div class="row">
            <div class="col-8 offset-2">
                <!-- section -->
                <section class="notfound-page">
                    <!-- article -->
                    <article id="post-404">

                        <h2><?php _e('Page not found', 'mindblank'); ?></h2>
                        <hr>
                            <a href="<?php echo home_url(); ?>"
                               class="btn btn-primary btn-block"><?php _e('Return home?', 'mindblank'); ?></a>


                    </article>
                    <!-- /article -->

                </section>
            </div>

        </div>
        <!-- /section -->
    </main>

<?php include 'layout/top-footer.php';
get_footer();
