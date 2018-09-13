
		<?php // add the class "panel" below here to wrap the sidebar in Bootstrap style ;) ?>
		<div class="sidebar">




<?php if(anagram_is_member() && is_page(array(4894) )   ) { ?>

		<aside class="widget"><div class="widget-header"><h3 class="widget-title">Add Images</h3>
		<?php echo file_get_contents(get_template_directory_uri()."/img/title-side-bg.svg"); ?></div>

		<div class="widget-content"><?php echo do_shortcode('[gravityform id="18" title="true" description="true"]'); ?></div>
		</aside>

	<?php }elseif( is_page(array(4894)) ){ ?>

		<aside class="widget"><div class="widget-header"><h3 class="widget-title">Become a Member</h3>
		<?php echo file_get_contents(get_template_directory_uri()."/img/title-side-bg.svg"); ?></div>

		<div class="widget-content"><a class="btn btn-default" href="<?php echo get_the_permalink(118); ?>">Join Now!</a></div>
		</aside>


<?php	}; ?>
	<?php if( is_singular(array('tool'))  ) { ?>
			<aside class="widget">
					<div class="widget-header">
		</div>
			<div class="widget-content"><div class="widget-link"><a href="https://makesantafe.org/tools-and-equipment/" class="btn btn-default">Back to Tool List</a></div></div>
	</aside>


		<div class="widget-content">
		<?php  $the_staff = get_field('proficient_makers');
				if($the_staff){ ?>
			<aside class="widget">
		<div class="widget-header">
			<h3 class="widget-title">Proficient Members</h3>
			 <?php echo file_get_contents(get_template_directory_uri()."/img/title-side-bg.svg"); ?></div>
				<div class="widget-content">
		<?php
			foreach($the_staff as $person):
			//var_dump($person); ?>
			<div class="person clearfix">
						<a href="<?php echo get_author_posts_url( $person['ID'] ); ?>"><img src="<?php echo get_wp_user_avatar_src( $person['ID'], 'thumbnail' ); ?>" width="65" height="65" class="alignleft img-thumbnail img-responsive img-circle" /></a>
							<h5 class="nomargin-bottom"><a href="<?php echo get_author_posts_url( $person['ID'] ); ?>"><?php echo $person["user_firstname"].' '.$person["user_lastname"]; ?></a></h5>
							<?php echo get_the_author_meta( 'title', $person['ID'] ); ?>

					</div>
		<?php endforeach; ?>
				</div>
			</aside>
		<?php } ?>

	<?php }; ?>

	<?php if( is_post_type_archive( 'tool' )   ) { ?>

		<aside class="widget"><div class="widget-header"><h3 class="widget-title">Wish List</h3>
		<?php echo file_get_contents(get_template_directory_uri()."/img/title-side-bg.svg"); ?></div>

		<div class="widget-content"><?php echo do_shortcode('[post_type_intro field="content" posttype="tool"]'); ?></div>
		</aside>

	<?php }; ?>

			<?php if(is_page('2'))include('content/staff-list.php'); ?>


<?php if(is_page( array('112','2','249') )){ ?>
	<aside class="widget"><div class="widget-header"><h3 class="widget-title">Find Us</h3>
		<?php echo file_get_contents(get_template_directory_uri()."/img/title-side-bg.svg"); ?></div>
		<div class="widget-content">
		<strong>Hours:</strong><br/><?php the_field('hours','options'); ?><br/>
		<strong>Location:</strong><br/><?php the_field('address','options'); ?><br/>
		<?php if(get_field('phone','options')){ ?><strong>Phone:</strong> <?php the_field('phone','options'); ?><br/><?php }; ?>
		<strong>Email:</strong><br/><a href="mailto:<?php echo antispambot( get_field('main_email','options') ); ?>" class="email"><?php echo antispambot( get_field('main_email','options') ); ?></a>
		</div>
	</aside>

<?php }; ?>

			<?php if( !is_author() &&  ( is_home() || is_singular(array('post')) || is_post_type_archive( 'post' ) )  ) dynamic_sidebar( 'sidebar' )  ?>


<?php if(  is_singular(array('post')) ):  ?>
		<aside class="widget">
			<div class="widget-header">
				<h3 class="widget-title">Share This</h3>
				 <?php echo file_get_contents(get_template_directory_uri()."/img/title-side-bg.svg"); ?></div>
					<div class="widget-content">
				<?php echo get_share_icons(get_permalink(), get_the_title(), ''); ?>
			</div>
		</aside>
			<?php endif; ?>


			<?php if( is_singular('event')   ) include('content/upcoming-events.php');  ?>

		<?php  //Remove links? other? ?>
		<?php if(get_field('sidebar_blocks') ):?>
		    		<?php while(has_sub_field('sidebar_blocks')): ?>
						<aside class="widget"><div class="widget-header"><h3 class="widget-title"><?php  echo get_sub_field('title')  ?></h3>
							 <?php echo file_get_contents(get_template_directory_uri()."/img/title-side-bg.svg"); ?></div>
								<div class="widget-content">
							<?php if( get_sub_field('image') ){
								$timthumb_url =  wp_get_attachment_image_src(  get_sub_field('image') , 'medium'); ?>
									<img src="<?php echo $timthumb_url[0] ?>"   alt="<?php //echo $timthumb_url[1]; ?>"  /></a>
									<?php } ?>
								<?php  echo get_sub_field('text')  ?>
								<?php if(get_sub_field('internal_link')){ ?>
									<div class="widget-link"><a href="<?php echo get_sub_field('internal_link'); ?>" class="btn btn-default btn-sm"><?php if(get_sub_field('link_title')) { echo get_sub_field('link_title');}else{ echo 'Click Here';}; ?></a></div>
								<?php }; ?>
								</div>
							</aside>
		   			<?php endwhile;?>
		<?php endif; ?>




	<?php if(is_user_logged_in() && ((is_page(array(565,543,93, 94, 358)) ||  $post->post_parent === 543 ) || is_author() || is_post_type_archive( 'tool' ) ) ) {
			 echo '<aside class="widget">';
			 echo do_shortcode("[theme-my-login default_action='login' logged_in_widget='true' before_title='<div class=\"widget-header\"><h3 class=\"widget-title\">' after_title='</h2>".file_get_contents(get_template_directory_uri()."/img/title-side-bg.svg")."</div>']");
			 echo '</aside>';
			 }; ?>


			<?php $cart  = edd_get_cart_contents();
				if( ! empty( $cart ) ):?>
						<aside class="widget"><div class="widget-header"><h3 class="widget-title">Your Cart</h3>
							 <?php echo file_get_contents(get_template_directory_uri()."/img/title-side-bg.svg"); ?></div>
								<div class="widget-content">

									<div class="widget-link"><a href="<?php echo edd_get_checkout_uri(); ?>">
	Cart (<span class="header-cart edd-cart-quantity"><?php echo edd_get_cart_quantity(); ?></span>)
</a></div>

								</div>
							</aside>
	<?php endif; ?>
		<?php
				if( is_user_logged_in() &&  ! get_field('show_me', 'user_'.get_current_user_id()) ):?>
			<aside class="widget"><div class="widget-header"><h3 class="widget-title">Show Profile Publicly?</h3>
							 <?php echo file_get_contents(get_template_directory_uri()."/img/title-side-bg.svg"); ?></div>
								<div class="widget-content">
Click link below and on your account page check the box to show publicly.
									<div class="widget-link"><a href="<?php echo get_permalink(543); ?>" class="btn btn-default btn-sm">Edit Account</a>
</div>

								</div>
							</aside>
	<?php endif; ?>



		</div><!-- close .sidebar-padder -->
