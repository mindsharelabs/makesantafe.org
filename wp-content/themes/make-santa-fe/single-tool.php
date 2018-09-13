<?php get_header(); ?>
<div class="row">
	<div class="col-md-8 col-md-push-4 has-sidebar">
		<div class="content">

			<?php
				while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="page-header">
						<h1 class="page-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
					<div class="row clearfix">
					<?php if ( has_post_thumbnail() ) { ?>
							<div class="col-sm-5 col-sm-push-7">
							<?php echo anagram_resize_image(array('width'=>740, 'height'=>740, 'crop' => true, 'upscale'=>true, 'img_class' => 'img-circle img-thumbnail')); ?>
							<?php //be_display_image_and_caption('large'); ?>
							</div>
							<div class="col-sm-7 col-sm-pull-5">
							<?php the_content(); ?>
							</div>

					<?php }else{ ?>
						<div class=" col-md-12">

						<?php the_content(); ?>
							</div>
					<?php }; ?>
					</div>


					</div><!-- .entry-content -->
				</article><!-- #post-## -->

	<?php  if( get_field('tool_gallery') ): ?>
	<h4>Tool Images</h4>
				<?php   echo do_shortcode('[gallery include="'. implode(',',wp_list_pluck( get_field('tool_gallery'), 'ID' )).'"  columns="3" size="post-thumbnail"]'); ?>
	<?php endif; ?>


		<?php  if( get_field('tool_video') ): ?>
	<h4>Video</h4>
								<div class="embed-container"><?php   the_field('tool_video'); ?></div>
	<?php endif; ?>


			<?php endwhile; // end of the loop. ?>

			<?php include('content/sub-content.php'); ?>

			<div class="other-details columns row">

			 					<div class="col-sm-6">
					<h2> Reserve machine time</h2>
					 <p>Here you can reserve a machine, enjoy!
					 <br/<br/><a class="btn btn-default" href="<?php echo get_the_permalink(1467); ?>">Reserve now!</a></p>

				</div>
			 				<div class="col-sm-6">
					<h2> Become a Member</h2>
					 <p><a class="btn btn-default" href="<?php echo get_the_permalink(118); ?>">Join Now!</a></p>

				</div>
			 </div>


		</div>
	</div>
	<div class="col-md-4 col-md-pull-8 left-bg">
		<?php get_sidebar(); ?>
	</div>
</div>
<style>

	.edd-bk-price,
	.other-details.columns .edd_download_quantity_wrapper{
		display: none;
	}

	div.edd-bk-session-options input[type="number"] {
    width: 80px;
    color: #000;
    text-align: center;
}

	</style>

<?php get_footer(); ?>