<?php get_header();
	  $author = get_user_by( 'slug', get_query_var( 'author_name' ) ); ?>
<div class="row">
<div class="col-md-8 col-md-push-4 has-sidebar">
<div class="content">

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<h1 class="page-title">Maker Profile</h1>
	</header><!-- .entry-header -->

	<div class="entry-content">

          <div class="row"  style=" padding-top:30px;padding-bottom:30px;">
			<div class="col-md-4 text-center">
					<img src="<?php echo get_wp_user_avatar_src( $author->ID, 'thumbnail' ); ?>"   class="img-thumbnail img-responsive img-circle avatar avatar-original" style="-webkit-user-select:none;display:block; margin:auto;"  />

            </div>
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-12">
                  <h3 class="only-bottom-margin"><?php echo get_the_author_meta( 'display_name', $author->ID); ?></h3>
                  <div><?php echo get_the_author_meta( 'title', $author->ID ); ?></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">

                  <?php if(get_the_author_meta( 'url', $author->ID )){ ?><span class="text-muted">Website:</span> <a href="<?php echo get_the_author_meta( 'url', $author->ID ); ?>" target="_blank"><i class="fa fa-globe fa-fw"></i> <?php echo get_the_author_meta( 'url', $author->ID ); ?></a><br><?php } ?>

<?php if(get_the_author_meta( 'facebook', $author->ID )){ ?><span class="text-muted">Facebook:</span> <a href="https://facebook.com/<?php echo get_the_author_meta( 'facebook', $author->ID ); ?>" target="_blank"><i class="fa fa-facebook fa-fw"></i> <?php echo get_the_author_meta( 'facebook', $author->ID ); ?></a><br/><?php } ?>
<?php if(get_the_author_meta( 'twitter', $author->ID )){ ?><a href="http://twitter.com/<?php echo get_the_author_meta( 'twitter', $author->ID ); ?>" target="_blank"><i class="fa fa-twitter-square fa-fw"></i> <?php echo get_the_author_meta( 'twitter', $author->ID ); ?></a><br/><?php } ?>
<?php if(get_the_author_meta( 'instagram', $author->ID )){ ?><span class="text-muted">Instagram:</span> <a href="https://instagram.com/<?php echo get_the_author_meta( 'instagram', $author->ID ); ?>" target="_blank"><i class="fa fa-instagram fa-fw"></i> <?php echo get_the_author_meta( 'linkedin', $author->ID ); ?></a><br/><?php } ?>
<?php if(get_the_author_meta( 'linkedin', $author->ID )){ ?><span class="text-muted">Linkedin:</span> <a href="http://www.linkedin.com/in/<?php echo get_the_author_meta( 'linkedin', $author->ID ); ?>" target="_blank"><i class="fa fa-linkedin fa-fw"></i> <?php echo get_the_author_meta( 'linkedin', $author->ID ); ?></a><br/><?php } ?>

<!--
                  <span class="text-muted">Birth date:</span> 01.01.2001<br>
                  <span class="text-muted">Gender:</span> male<br><br>
                  <small class="text-muted">Created: 01.01.2015</small>
-->
<?php if(get_the_author_meta( 'description', $author->ID )){ ?> <br/>
 <?php echo get_the_author_meta( 'description', $author->ID ); ?>
<?php } ?>
                </div>
<!--
                <div class="col-md-6">
                  <div class="activity-mini">
                    <i class="fa fa-commenting-o"></i> 500
                  </div>
                  <div class="activity-mini">
                    <i class="glyphicon glyphicon-thumbs-up text-muted"></i> 1500
                  </div>
                </div>
-->
              </div>
            </div>
          </div>


	<?php
	$args = array(
           'post_type' => 'attachment',
           'numberposts' => -1,
           'post_status' => null,
           'post_parent' => 4894,
           'order'=> 'ASC',
           'author'        =>  $author->ID,

          );

          $attachments = get_posts( $args );




             if ( $attachments ) {
	             echo '<div class=" clear">';
	             echo '<h2>Member Photos</h2>';
			 	echo do_shortcode('[gallery include="'. implode(',',wp_list_pluck( $attachments, 'ID' )).'"  columns="3" size="post-thumbnail"]');
			 	echo '</div>';
             }
             ?>

		  				<?php


						$tools = get_posts(array(
							'post_type' => 'tool',
							'meta_query' => array(
								array(
									'key' => 'proficient_makers', // name of custom field
									'value' => '"' .  $author->ID . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
									'compare' => 'LIKE'
								)
							)
						));

						?>
						<?php if( $tools ): ?>
<div class=" clear">
	<h4><?php echo get_the_author_meta( 'display_name', $author->ID); ?> is proficient with...</h4>


					<ul class="list-unstyled">
							<?php foreach( $tools as $tool ): ?>

								<li>
									<a href="<?php echo get_permalink( $tool->ID ); ?>">

										<?php echo get_the_title( $tool->ID ); ?>
									</a>
									</li>
							<?php endforeach; ?>
</ul>

		 </div>



<?php endif; ?>

<?php if( current_user_can('edit_others_pages') ) { ?>
<div class="panel panel-default clear">
	<div class="panel-heading"><strong>Makers Certifications</strong></div>
 <div class="panel-body"> <p>This list is only visible to Admins and Editors</p> </div>
          		<?php
/*

			$categories = get_categories( array(
			    'orderby' => 'name',
			    'child_of'  => 87,
			    'order'   => 'ASC'
			) );

foreach( $categories as $category ) {

    // display current term name
    echo $category->name;

    // display current term description, if there is one
    echo $category->description;

    // get the current term_id, we use this later in the get_posts query
    $term_id = $category->term_id;

    $args = array(
        'post_type' => 'guides', // add our custom post type
        'tax_query' => array(
            array(
                'taxonomy' => 'category', // the taxonomy we want to use (it seems you are using the default "category" )
                'field' => 'term_id', // we want to use "term_id" so we can insert the ID from above in the next line
                'terms' => $term_id // use the current term_id to display only posts with this term
            )
        )
    );
    $posts = get_posts( $args );

    foreach ($posts as $post) {

        // display post title
        echo $post->post_title;

        // display post excerpt
        echo $post->post_excerpt;

        // or maybe you want to show the content instead use ...
        #echo $post->post_content;

    }

}
*/

	$certifications = get_field('certification_levels', 'user_'.$author->ID );

		?>
			<div id="no-more-tables">
		<table class="table">
			<thead>
				<tr>
					<th>Certification</th>
					<th>Paid?</th>
					<th>Status</th>
					<th>Skill Level 1</th>
					<th>Skill Level 2</th>
					<th>Notes</th>
				</tr>
			</thead>
			<tbody>
				<?php if ( ! empty( $certifications ) ) : ?>
					<?php foreach ( $certifications as $certification ) :

					?>
						<tr>
							<td data-title="Purchase"><?php echo $certification["certification"]->name; ?></td>
							<td data-title="Paid">
								 <?php echo $certification["paid"]; ?>
							</td>
							<td data-title="Status">
								 <?php echo $certification["instructor"]["display_name"]; ?>
							</td>
							<td data-title="Skill Level 1">
								 <?php echo $certification["skill_level_1"]; ?>
							</td>
							<td data-title="Skill Level 2">
								 <?php echo $certification["skill_level_2"]; ?>
							</td>
							<td data-title="Notes">
								 <?php echo $certification["notes"]; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr><td colspan="2"><?php printf( __( 'No %s Found', 'easy-digital-downloads' ), edd_get_label_plural() ); ?></td></tr>
				<?php endif; ?>
			</tbody>
		</table>
			</div>
		 </div>



<?php }; ?>


    <?php if( current_user_can('edit_others_pages') ) { ?>
<div class="panel panel-default clear">
	<div class="panel-heading"><strong>Makers Purchases</strong> - This list is only visible to Admins and Editors</div>
<!-- 	<div class="panel-body"> <p>This list is only visible to Admins and Editors</p> </div> -->
          		<?php
			$downloads = edd_get_users_purchased_products( $author->user_email );
		?>
			<div id="no-more-tables">
		<table class="table">
			<thead>
				<tr>
					<th>Purchases</th>
					<th>Links</th>
				</tr>
			</thead>
			<tbody>
				<?php if ( ! empty( $downloads ) ) : ?>
					<?php foreach ( $downloads as $download ) : ?>
						<tr>
							<td data-title="Purchase"><?php echo $download->post_title; ?></td>
							<td data-title="Links">
								<a title="<?php echo esc_attr( sprintf( __( 'View %s', 'easy-digital-downloads' ), $download->post_title ) ); ?>" href="<?php echo esc_url( admin_url( 'post.php?action=edit&post=' . $download->ID ) ); ?>">
									<?php printf( __( 'View %s', 'easy-digital-downloads' ), edd_get_label_singular() ); ?>
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr><td colspan="2"><?php printf( __( 'No %s Found', 'easy-digital-downloads' ), edd_get_label_plural() ); ?></td></tr>
				<?php endif; ?>
			</tbody>
		</table>
			</div>
		 </div>



<?php }; ?>
<!--
          <div class="row">
            <div class="col-md-12">
              <hr><?php echo nl2br( get_the_author_meta( 'description', $author->ID ) ); ?>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <h4>Posts by <?php echo get_the_author_meta( 'display_name', $author->ID); ?></h4>
	<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>

								<div class="clearfix">
									<?php if ( has_post_thumbnail() ) { ?>
									<div class="alignleft " style="width: 80px;">
								<?php echo anagram_resize_image(array('width'=>80, 'height'=>80, 'crop'=>true, 'img_class'=>"img-thumbnail img-responsive img-circle")); ?>
									</div>
									<?php } ?>
											<div class="event-cat nomargin-top"><?php echo get_the_category_list(); ?></div>
									<h5 class="nomargin"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h5>

										<em class="gray "><?php the_time('M d, Y');  ?></em>
										<?php //echo clean_excerpt(get_the_content(), '' ,50 );?>


					 				</div>




				<?php endwhile; // end of the loop. ?>
				<?php else : ?>

			<p><?php echo get_the_author_meta( 'display_name', $author->ID); ?> has not published any news yet.</p>


		<?php endif; ?>
		<?php	wp_reset_postdata();?>

            </div>

            <div class="col-md-6">
             <h4>Events & Workshops</h4>
<?php
			$args = array( 'post_type' => 'event', 'posts_per_page'=> 2 ,'orderby'=>'title', 'order'=>'ASC','meta_query' => array(
			      		 array(
				           'key' => 'people',
				            'value' => '"' . $author->ID . '"',
				            'compare' => 'LIKE'
			            )
			       )
			 );
				$loop = new WP_Query( $args );
				if ( $loop->have_posts() ) : ?>
				 <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
						<div class="event-block">
						<div class="event-cat nomargin-top"><?php echo get_custom_taxonomy('event_cat',', ','name'); ?></div>

							<h5 class=" nomargin"><a href="<?php the_permalink(); ?>">  <?php the_title(); ?></a></h5>
					 	</div>
					 	<?php echo anagram_get_event_dates(get_the_ID()); ?>

					<?php endwhile; ?>
		 <?php endif; ?>
<?php	wp_reset_postdata();?>
            </div>

          </div>
-->
          <div class="row">
            <div class="col-md-12">
            <?php if( is_user_logged_in() && (get_current_user_id() === $author->ID ) ) { ?>

					<hr><a  href="<?php echo get_the_permalink(543); ?>" class="btn btn-default pull-right"><i class="fa fa-pencil-square fa-fw"></i> Edit your Profile</a>
			<?php } ?>

            </div>
          </div>






	</div><!-- .entry-content -->
</article><!-- #post-## -->


</div>
</div>
	<div class="col-md-4 col-md-pull-8 left-bg">
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>