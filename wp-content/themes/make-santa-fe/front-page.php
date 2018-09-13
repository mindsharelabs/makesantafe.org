<?php get_header(); ?>
<div class="content">
	<?php 

	while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<h1 class="page-title"><?php echo get_field('home_block_header'); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>


	<?php if(get_field("other_details")): ?>

		<div class="holder row">
		<?php while(has_sub_field("other_details")):
				$image_url = get_sub_field('image');

		 $cleantitle= sanitize_title( get_sub_field("title") ); ?>
			<div class="other-details col-sm-6 col-md-4">
			<div class="inner-block page">
				<div class="img-holder col-xs-4">
				<?php echo file_get_contents($image_url); ?>
				</div>



					<div class="inner-text col-xs-8">
					<h4><a href="<?php echo get_sub_field('link_to'); ?>"><?php echo  get_sub_field("title"); ?></a></h4>
					<?php the_sub_field('content'); ?>
					<div></div>
					</div>
<a href="<?php echo get_sub_field('link_to'); ?>" class="btn btn-default">learn more</a>
			</div>

			</div>
		<?php endwhile; ?>
		</div>
<?php endif; //end if other details ?>

		<div class="holder row">
<?php
	$args = array( 'numberposts' => '3', 'post_status' => 'publish', );
	$recent_posts = wp_get_recent_posts( $args );
	foreach( $recent_posts as $recent ){
		$post = get_post($recent['ID']);
		setup_postdata( $post );
	?>			<div class="other-details col-sm-6 col-md-4">
			<div class="inner-block post">
<div class="img-holder col-xs-4">
				<?php echo file_get_contents(get_template_directory_uri()."/img/news-outline.svg"); ?>
				</div>



					<div class="inner-text col-xs-8">
					<h4 class="nomargin-bottom"><a href="<?php echo get_the_permalink(); ?>"><?php echo $recent["post_title"]; ?></a></h4>
					<div><?php echo get_the_category_list(); ?></div>
						<p><?php echo clean_excerpt(get_the_excerpt(), '...' , 10 );?></p>

					</div>
<a href="<?php echo get_the_permalink(); ?>" class="btn btn-default">read more</a>
			</div>

			</div>


	<?php }
?>
</div>
	<?php wp_reset_postdata(); ?>





	<div class="newsletter">
					<?php gravity_form(6, false, false, false, null, true); ?>
				</div>

	</div><!-- .entry-content -->
</article><!-- #post-## -->
	<?php endwhile; // end of the loop. ?>
</div>
<?php get_footer(); ?>
