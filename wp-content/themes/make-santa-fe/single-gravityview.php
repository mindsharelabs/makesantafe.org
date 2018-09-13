<?php get_header(); ?>
<div class="container">
	<div class="row">
	 <div class="col-sm-12">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="page-header">
					<h1 class="page-title"><?php the_title(); ?></h1>

				</header><!-- .entry-header -->

				<div class="entry-content">
				<?php if (is_user_logged_in() && current_user_can('edit_posts')) { ?>

						<?php 	the_content(); ?>


						<?php }else{ ?>


						<?php echo do_shortcode("[theme-my-login default_action='login' instance='5' 'show_title'='false']"); ?>
					<?php } ?>

				</div><!-- .entry-content -->

				<?php endwhile; // end of the loop. ?>
			</article><!-- #post-## -->
	 </div>
	</div>
</div>
<?php get_footer(); ?>