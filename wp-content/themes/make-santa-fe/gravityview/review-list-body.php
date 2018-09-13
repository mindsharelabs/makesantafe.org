<?php
/**
 * The template for displaying review list body.
 *
 * The global post in current context refers to the post bridge.
 *
 * @package GravityView_Ratings_Reviews
 * @since 0.1.0
 */
global $post, $gravityview_view;

defined( 'ABSPATH' ) || exit;
?>
<div class="gv-review-voting-area">
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'gravityview-ratings-reviews' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'gravityview-ratings-reviews' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'gravityview-ratings-reviews' ) ); ?></div>
	</nav><!-- #comment-nav-below -->
	<?php endif; // Check for comment navigation. ?>

	<?php GravityView_Ratings_Reviews_Review::review_form(); ?>
</div><!-- /.gv-review-list-footer -->

<div class="gv-review-list-body">
	<ul id="comments" class="gv-review-list comment-list list-unstyled">
		<?php

			wp_list_comments(
				array(
					'style'       => 'ol',
					'avatar_size' => 34,
					'walker'      => new GravityView_Ratings_Reviews_Review_Walker( $gravityview_view ),
					'max_depth'   => 2,
					'type'        => 'all',
				),
				GravityView_Ratings_Reviews_Helper::get_reviews( $post )
			);
		?>
	</ul><!-- /.gv-review-list -->
</div><!-- /.gv-review-list-body -->
