<?php get_header(); ?>

	<?php if ( is_user_logged_in()  ) { ?>
	<?php  muut_is_forum_page();
		muut_page_embed();
	?>
	<?php }else{ ?>


			<div class="entry-content" style="max-width:600px; padding:30px 0;margin:0 auto;">
						<div class="text-center">The forums are open for any logged in maker but even better is to become a full member! <br/><a href="<?php echo get_the_permalink(118); ?>" class="btn btn-default">Become a member today!</a></div>
							<?php echo do_shortcode("[theme-my-login default_action='login' logged_in_widget='true' 'show_title'='false' before_title='<h5 class=\"login-header\">' after_title='</h5>']"); ?>
			</div>
					<?php } ?>

<?php get_footer(); ?>