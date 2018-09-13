<?php get_header(); ?>
<div class="row">
<div class="col-md-8 col-md-push-4 has-sidebar">
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
		<div class="row" id="userList" style="display: block;">
			<?php

					$args = array(
						'orderby' => 'display_name',
						'role__in' => array( 'volunteer','member','member-other', 'administrator','shop_manager','editor' ),
					);
					// The Query
					$user_query = new WP_User_Query( $args );

					// User Loop
					if ( ! empty( $user_query->results ) ) {
						foreach ( $user_query->results as $user ):
						//mapi_var_dump(!current_user_can('edit_others_pages'));
							if( !get_field('show_me', 'user_'. $user->ID) && !current_user_can('edit_others_pages')  ) continue; ?>

							<div ng-repeat="u in users" class="col-xs-4 col-sm-2 ng-scope <?php if( !get_field('show_me', 'user_'. $user->ID) ) echo 'hidden-member'; ?>">
					<a href="<?php echo get_author_posts_url( $user->ID ); ?>"><img src="<?php echo get_wp_user_avatar_src( $user->ID, 'thumbnail' ); ?>" width="130" height="130" class="img-thumbnail img-responsive img-circle" /></a>
					<h4 class="text-center ng-binding" style="white-space: nowrap;"><a href="<?php echo get_author_posts_url( $user->ID ); ?>"><?php echo $user->first_name; ?></a></h4>
		      <hr>
		    </div><!-- end ngRepeat: u in users -->


					<?php	endforeach; //users
					 };
		 ?>



		</div>
			</div><!-- .entry-content -->
		</article><!-- #post-## -->
			<?php endwhile; // end of the loop. ?>



					<?php include('content/sub-content.php'); ?>
		</div>
</div>
	<div class="col-md-4 col-md-pull-8 left-bg">
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>