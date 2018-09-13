<?php get_header(); ?>
<div class="row">
<div class="col-sm-4 left-bg hidden-xs">
<?php get_sidebar(); ?>
</div>
<div class="col-sm-8 has-sidebar">
<div class="content">
	<?php if ( have_posts() ) : ?>

	<header class="page-header">
		<h1 class="page-title"><?php the_archive_title(); ?></h1>
	</header><!-- .entry-header -->
	<div class="the-tools">
		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>


				<div class="tools" style="padding: 30px 0 0; overflow:auto;">
				<?php echo anagram_resize_image(array('width'=>75, 'height'=>75, 'crop'=>true, 'img_class'=>"img-thumbnail img-responsive img-circle pull-left")); ?>
					<div class="tool-info" style="padding-left:85px;">
												<div class="event-cat"><?php echo get_custom_taxonomy('tool_type',', ','slug'); ?></div>
												<div class="event-title"><h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4></div>
												<div class="event-excerpt"><?php echo get_field('short_description');?></div>
												<hr/>
					</div>


				</div>

		<?php endwhile; ?>

		</div>


	<?php endif; ?>
</div>
</div>
</div>
<?php get_footer(); ?>