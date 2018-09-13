<?php
	/*
		Template Name: No Sidebar
		*/ get_header(); ?>
		<div class="content">
	<?php while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
					<?php if ( has_post_thumbnail() ) { ?>
		<?php echo anagram_resize_image(array('width'=>877, 'height'=>360, 'crop'=>true)); ?>
		<?php //be_display_image_and_caption('large');
			//the_post_thumbnail('large'); ?>
	<?php } ?>
		<?php the_content(); ?>

	</div><!-- .entry-content -->
</article><!-- #post-## -->
	<?php endwhile; // end of the loop. ?>



			<?php include('content/sub-content.php'); ?>
		</div>
<?php get_footer(); ?>