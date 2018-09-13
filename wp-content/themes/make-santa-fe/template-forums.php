<?php /*Template Name: Forums

*/
get_header(); ?>
		<div class="content">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="page-header">
				<h1 class="page-title"><?php the_title(); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">


				<?php the_content(); ?>


			</div><!-- .entry-content -->
		</article><!-- #post-## -->
	<?php endwhile; // end of the loop. ?>



			<?php include('content/sub-content.php'); ?>
		</div>
<?php get_footer(); ?>