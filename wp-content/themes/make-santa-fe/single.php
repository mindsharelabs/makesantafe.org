<?php get_header(); ?>
	<div class="row">
<div class="col-md-8 col-md-push-4 has-sidebar">
<div class="content">
	<?php while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<h1 class="page-title"><?php the_title(); ?></h1>

		<p class="entry-meta">
				Posted in <?php the_category(', '); ?> on <?php the_time('F jS, Y') ?>
		</p><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( has_post_thumbnail() ) { ?>
		<?php echo anagram_resize_image(array('width'=>300 ,'align'=>'right','linked'=>'true')); ?>
		<?php //be_display_image_and_caption('large');
			//the_post_thumbnail('large'); ?>
	<?php } ?>
		<?php the_content(); ?>
		
		<?php if( function_exists( 'edd_di_display_images') ) {
		    edd_di_display_images();
		} ?>


	
	</div><!-- .entry-content -->

	<footer class="entry-meta">
			<div class="tags-links"><?php echo get_the_tag_list( 'Tags: ', ' | ' ); // Display the tags this post has, as links separated by spaces and pipes ?></div>
	</footer><!-- .entry-meta -->

		
	<?php endwhile; // end of the loop. ?>
</article><!-- #post-## -->
</div>
</div>
	<div class="col-md-4 col-md-pull-8 left-bg">
		<?php get_sidebar(); ?>

	</div>
	</div>
<?php get_footer(); ?>