<?php get_header(); ?>
<div class="row">
<div class="col-sm-4 left-bg hidden-xs">
<?php get_sidebar(); ?>
</div>
<div class="col-sm-8 has-sidebar">
<div class="content">
	<?php if ( have_posts() ) : ?>

	<header class="page-header">
		<h1 class="page-title">Search Results for:</span> <?php the_search_query(); ?></h1>
	</header><!-- .entry-header -->

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" class="clearfix">

<!--
<div  class="row event-summery">
	<div class="col-sm-3 event-date">
		<div><strong><?php the_time('F jS, Y') ?></strong></div>
			<?php echo anagram_resize_image(array('width'=>100, 'height'=>100, 'crop'=>true, 'img_class'=>"img-thumbnail img-responsive img-circle")); ?>

	</div>
<div class="col-sm-9">
-->

	<div class="event-cat"><h5><?php echo get_post_type(); ?></h5></div>
	<div class="event-cat"><?php the_category(', '); ?> <?php echo get_custom_taxonomy('event_cat',', ','name'); ?></div>
	<div class="event-title"><h4><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h4></div>
	<div class="event-excerpt"><?php echo clean_excerpt(get_the_content(), '...' , 20 );?></div>
	<hr>
<!--
</div>
</div>
-->


</article><!-- #post-## -->
		<?php endwhile; ?>
		<ul class="pager">
			<?php if ( get_next_posts_link() ) : ?>
			<li class="nav-previous previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'anagram_coal' ) ); ?></li>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<li class="nav-next next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'anagram_coal' ) ); ?></li>
			<?php endif; ?>
		</ul>
	<?php else : ?>

		<section class="no-results not-found">
			<header class="page-header">
				<h1 class="page-title"><?php _e( 'Nothing Found', 'anagram_coal' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">


					<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'anagram_coal' ); ?></p>
					<?php get_search_form(); ?>


			</div><!-- .page-content -->
		</section><!-- .no-results -->


	<?php endif; ?>
</div>
</div>
</div>
<?php get_footer(); ?>