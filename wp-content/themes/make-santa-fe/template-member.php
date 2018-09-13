<?php /*Template Name: Member Login

*/
get_header(); ?>
		<div class="content">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="page-header">
				<h1 class="page-title"><?php the_title(); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">

					<?php if ( is_user_logged_in() && anagram_is_member() ) { ?>
							<?php if ( has_post_thumbnail() ) { ?>
							<?php echo anagram_resize_image(array('width'=>877, 'height'=>360, 'crop'=>true)); ?>
							<?php //be_display_image_and_caption('large');
								//the_post_thumbnail('large'); ?>
						<?php } ?>
				<?php the_content(); ?>
					<?php }else{ ?>
						<?php if ( is_user_logged_in() && !current_user_can('edit_posts') ) { ?>
								<div class="text-center"><a href="<?php echo get_the_permalink(118); ?>" class="btn btn-default">Become a member today!</a></div>
						<?php }else{ ?>
						<div class="text-center">Not a member of MAKE Santa Fe?<br/><a href="<?php echo get_the_permalink(118); ?>" class="btn btn-default">Become a member today!</a></div>
							<?php echo do_shortcode("[theme-my-login default_action='login' logged_in_widget='true' 'show_title'='false' before_title='<h5 class=\"login-header\">' after_title='</h5>']"); ?>

							<?php } ?>
					<?php } ?>

			</div><!-- .entry-content -->
		</article><!-- #post-## -->
	<?php endwhile; // end of the loop. ?>



			<?php include('content/sub-content.php'); ?>
		</div>
<?php get_footer(); ?>