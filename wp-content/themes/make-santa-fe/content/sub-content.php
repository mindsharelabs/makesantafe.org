<?php if( is_page(118) ): ?>

	<?php
$args = array(
'post_type' => 'download',
'posts_per_page' => -1,  //show all posts
'orderby' => 'menu_order',
'order' => 'ASC',
'tax_query' => array(
    array(
        'taxonomy' => 'download_category',
        'field' => 'id',
        'terms' => '9',
    )));
$posts = new WP_Query($args);

    if( $posts->have_posts() ):
    $i =1;

    $the_membership = get_term_by('id', 9, 'download_category');
   // mapi_var_dump($the_membership["name"]);
    ?>
        <section class="member-section">
            <h2><?php echo $the_membership->name; ?></h2>
                 <div class="member-description"><?php echo apply_filters('the_content',$the_membership->description); ?></div>

            <div class="pricing row">
			<?php while( $posts->have_posts() ) : $posts->the_post();
				$memID = get_the_ID();

			?>
                <div class="member-item col-sm-4">
                    <div class="icon"><?php echo file_get_contents(get_template_directory_uri()."/img/level-".$i.".svg"); ?></div>
                    <h3 class="pricing-title"><?php the_title(); ?></h3>
                    <p class="pricing-sentence"><?php echo get_field('sub_title'); ?></p>
<!--
                    <div class="pricing-price">
                        <span class="pricing__anim pricing-anim-1">
								<?php echo edd_price($memID); ?> <?php echo edd_price_range($memID); ?>
                        </span>
                        <span class="pricing-anim pricing-anim-2">
								<span class="pricing-period">per <?php echo get_post_meta( $memID, 'edd_period', true  ); ?></span>
                        </span>
                    </div>
-->

                    <?php //echo get_post_meta( $memID, 'signup_fee', true  ); ?>

	                    <?php $recurring_dates = get_field('feature_list');
					    if($recurring_dates){ ?>
					     <ul class="feature-list">
							<?php foreach($recurring_dates as $row){ ?>

							<li class="pricing-feature"><?php echo $row['feature'] ; ?></li>

							<?php } ?>
							 </ul>
						<?php }; ?>
                    </ul>
                    <?php
echo edd_get_purchase_link( array( 'download_id' => $memID,'price' => true, 'class'=> 'btn btn-default btn-lg', 'direct'=> false, 'text' => 'Choose plan') ); ?>

                </div>


			   <?php $i++; endwhile; ?>
			</div>
        </section>
	<?php endif; wp_reset_query(); ?>


<?php
$args = array(
'post_type' => 'download',
'posts_per_page' => -1,  //show all posts
'orderby' => 'title',
'order' => 'ASC',
'tax_query' => array(
    array(
        'taxonomy' => 'download_category',
        'field' => 'id',
        'terms' => '39',
    )));
$posts = new WP_Query($args);

    if( $posts->have_posts() ):
    $i =1;

    $the_membership = get_term_by('id', 39, 'download_category');
   // mapi_var_dump($the_membership["name"]);
    ?>
        <section class="member-section">
            <h2><?php echo $the_membership->name; ?></h2>
                 <div class="member-description"><?php echo apply_filters('the_content',$the_membership->description); ?></div>

            <div class="pricing row">
			<?php while( $posts->have_posts() ) : $posts->the_post();
				$memID = get_the_ID();

			?>
                <div class="member-item col-sm-6">
                    <div class="icon"><?php echo file_get_contents(get_template_directory_uri()."/img/level-".$i.".svg"); ?></div>
                    <h3 class="pricing-title"><?php the_title(); ?></h3>
                    <p class="pricing-sentence"><?php echo get_field('sub_title'); ?></p>
<!--
                    <div class="pricing-price">
                        <span class="pricing__anim pricing-anim-1">
								<?php echo edd_price($memID); ?> <?php echo edd_price_range($memID); ?>
                        </span>
                        <span class="pricing-anim pricing-anim-2">
								<span class="pricing-period">per <?php echo get_post_meta( $memID, 'edd_period', true  ); ?></span>
                        </span>
                    </div>
-->

                    <?php //echo get_post_meta( $memID, 'signup_fee', true  ); ?>

	                    <?php $recurring_dates = get_field('feature_list');
					    if($recurring_dates){ ?>
					     <ul class="feature-list">
							<?php foreach($recurring_dates as $row){ ?>

							<li class="pricing-feature"><?php echo $row['feature'] ; ?></li>

							<?php } ?>
							 </ul>
						<?php }; ?>
                    </ul>
                    <?php
echo edd_get_purchase_link( array( 'download_id' => $memID,'price' => true, 'class'=> 'btn btn-default btn-lg', 'direct'=> false, 'text' => 'Choose plan') ); ?>

                </div>


			   <?php $i++; endwhile; ?>
			</div>
        </section>
	<?php endif; wp_reset_query(); ?>





<?php endif; ?>

<?php if( is_page(2632) ): ?>
<?php
$args = array(
'post_type' => 'download',
'posts_per_page' => -1,  //show all posts
'orderby' => 'title',
'order' => 'ASC',
'tax_query' => array(
    array(
        'taxonomy' => 'download_category',
        'field' => 'id',
        'terms' => '40',
    )));
$posts = new WP_Query($args);

    if( $posts->have_posts() ):
    $i =1;

    $the_membership = get_term_by('id', 40, 'download_category');
   // mapi_var_dump($the_membership["name"]);
    ?>
        <section class="member-section">
            <h2><?php echo $the_membership->name; ?></h2>
                 <div class="member-description"><?php echo apply_filters('the_content',$the_membership->description); ?></div>

            <div class="pricing row">
			<?php while( $posts->have_posts() ) : $posts->the_post();
				$memID = get_the_ID();

			?>
                <div class="member-item col-sm-6">
                    <div class="icon"><?php echo file_get_contents(get_template_directory_uri()."/img/level-".$i.".svg"); ?></div>
                    <h3 class="pricing-title"><?php the_title(); ?></h3>
                    <p class="pricing-sentence"><?php echo get_field('sub_title'); ?></p>
<!--
                    <div class="pricing-price">
                        <span class="pricing__anim pricing-anim-1">
								<?php echo edd_price($memID); ?> <?php echo edd_price_range($memID); ?>
                        </span>
                        <span class="pricing-anim pricing-anim-2">
								<span class="pricing-period">per <?php echo get_post_meta( $memID, 'edd_period', true  ); ?></span>
                        </span>
                    </div>
-->

                    <?php //echo get_post_meta( $memID, 'signup_fee', true  ); ?>

	                    <?php $recurring_dates = get_field('feature_list');
					    if($recurring_dates){ ?>
					     <ul class="feature-list">
							<?php foreach($recurring_dates as $row){ ?>

							<li class="pricing-feature"><?php echo $row['feature'] ; ?></li>

							<?php } ?>
							 </ul>
						<?php }; ?>
                    </ul>
                    <?php
echo edd_get_purchase_link( array( 'download_id' => $memID,'price' => true, 'class'=> 'btn btn-default btn-lg', 'direct'=> false, 'text' => 'Choose plan') ); ?>

                </div>


			   <?php $i++; endwhile; ?>
			</div>
        </section>
	<?php endif; wp_reset_query(); ?>





<?php endif; ?>



<?php if( is_page(2748) ): ?>

	<?php
$args = array(
'post_type' => 'download',
'posts_per_page' => -1,  //show all posts
'orderby' => 'menu_order',
'order' => 'ASC',
'tax_query' => array(
    array(
        'taxonomy' => 'download_category',
        'field' => 'id',
        'terms' => '39',
    )));
$posts = new WP_Query($args);

    if( $posts->have_posts() ):
    $i =1;

    $the_membership = get_term_by('id', 39, 'download_category');
   // mapi_var_dump($the_membership["name"]);
    ?>
        <section class="member-section">
            <h2><?php echo $the_membership->name; ?></h2>
                 <div class="member-description"><?php echo apply_filters('the_content',$the_membership->description); ?></div>

            <div class="pricing row">
			<?php while( $posts->have_posts() ) : $posts->the_post();
				$memID = get_the_ID();

			?>
                <div class="member-item col-sm-4">
                    <div class="icon"><?php echo file_get_contents(get_template_directory_uri()."/img/level-".$i.".svg"); ?></div>
                    <h3 class="pricing-title"><?php the_title(); ?></h3>
                    <p class="pricing-sentence"><?php echo get_field('sub_title'); ?></p>
<!--
                    <div class="pricing-price">
                        <span class="pricing__anim pricing-anim-1">
								<?php echo edd_price($memID); ?> <?php echo edd_price_range($memID); ?>
                        </span>
                        <span class="pricing-anim pricing-anim-2">
								<span class="pricing-period">per <?php echo get_post_meta( $memID, 'edd_period', true  ); ?></span>
                        </span>
                    </div>
-->

                    <?php //echo get_post_meta( $memID, 'signup_fee', true  ); ?>

	                    <?php $recurring_dates = get_field('feature_list');
					    if($recurring_dates){ ?>
					     <ul class="feature-list">
							<?php foreach($recurring_dates as $row){ ?>

							<li class="pricing-feature"><?php echo $row['feature'] ; ?></li>

							<?php } ?>
							 </ul>
						<?php }; ?>
                    </ul>
                    <?php
echo edd_get_purchase_link( array( 'download_id' => $memID,'price' => true, 'class'=> 'btn btn-default btn-lg', 'direct'=> false, 'text' => 'Choose plan') ); ?>

                </div>


			   <?php $i++; endwhile; ?>
			</div>
        </section>
	<?php endif; wp_reset_query(); ?>


	<?php
/*
$args = array(
'post_type' => 'download',
'posts_per_page' => -1,  //show all posts
'tax_query' => array(
    array(
        'taxonomy' => 'download_category',
        'field' => 'id',
        'terms' => '21',
    )));
$posts = new WP_Query($args);

    if( $posts->have_posts() ):
        $the_membership = get_term_by('id', 21, 'download_category');
    $i =1; ?>
     <section class="member-section">
            <h2><?php echo $the_membership->name; ?></h2>
                 <div class="member-description"><?php echo apply_filters('the_content',$the_membership->description); ?></div>

            <div class="pricing row">
			<?php while( $posts->have_posts() ) : $posts->the_post();
				$memID = get_the_ID();

			?>
                <div class="member-item col-sm-12">
                    <div class="icon"><?php echo file_get_contents(get_template_directory_uri()."/img/level-".$i.".svg"); ?></div>
                    <h3 class="pricing-title"><?php the_title(); ?></h3>
                    <p class="pricing-sentence"><?php echo get_field('sub_title'); ?></p>
                    <div class="pricing-price">
                        <span class="pricing__anim pricing-anim-1">
								<?php echo edd_price($memID); ?>
                        </span>
                        <span class="pricing-anim pricing-anim-2">
								<span class="pricing-period">per <?php echo get_post_meta( $memID, 'edd_period', true  ); ?></span>
                        </span>
                    </div>

	                    <?php $recurring_dates = get_field('feature_list');
					    if($recurring_dates){ ?>
					     <ul class="feature-list">
							<?php foreach($recurring_dates as $row){ ?>

							<li class="pricing-feature"><?php echo $row['feature'] ; ?></li>

							<?php } ?>
							 </ul>
						<?php }; ?>
                    </ul>
                    <?php
echo edd_get_purchase_link( array( 'download_id' => $memID,'price' => true, 'class'=> 'btn btn-default btn-lg', 'direct'=> false, 'text' => 'Choose plan') ); ?>

                </div>


			   <?php $i++; endwhile; ?>
			</div>
        </section>
	<?php endif; wp_reset_query();
*/ ?>



<?php endif; ?>



<?php if( is_page(512) ): ?>

	<?php
$args = array(
'post_type' => 'download',
'posts_per_page' => -1,  //show all posts
'orderby' => 'menu_order',
'order' => 'ASC',
'tax_query' => array(
    array(
        'taxonomy' => 'download_category',
        'field' => 'id',
        'terms' => '24',
    )));
$posts = new WP_Query($args);

    if( $posts->have_posts() ):
    $i =1;

    $the_membership = get_term_by('id', 24, 'download_category');
   // mapi_var_dump($the_membership["name"]);
    ?>
        <section class="donation-section">
            <h2><?php echo $the_membership->name; ?></h2>
                 <div class="member-description"><?php echo apply_filters('the_content',$the_membership->description); ?></div>

            <div class="pricing row">
			<?php while( $posts->have_posts() ) : $posts->the_post();
				$memID = get_the_ID();

			?>
                <div class="member-item col-sm-6">
                    <div class="icon"><?php echo file_get_contents(get_template_directory_uri()."/img/level-".$i.".svg"); ?></div>
                    <h3 class="pricing-title"><?php the_title(); ?></h3>
                    <p class="pricing-sentence"><?php echo get_field('sub_title'); ?></p>

	                    <?php $recurring_dates = get_field('feature_list');
					    if($recurring_dates){ ?>
					     <ul class="feature-list">
							<?php foreach($recurring_dates as $row){ ?>

							<li class="pricing-feature"><?php echo $row['feature'] ; ?></li>

							<?php } ?>
							 </ul>
						<?php }; ?>
                    </ul>
                    <?php
echo edd_get_purchase_link( array( 'download_id' => $memID,  'class'=> 'btn btn-default btn-lg', 'price'=> true, 'direct'=> false ) ); ?>

                </div>


			   <?php $i++; endwhile; ?>
			</div>
        </section>
	<?php endif; wp_reset_query(); ?>


<?php endif; ?>



<?php $tool_group = get_field('tool_groups');
		if($tool_group){ ?>
		<div class="the-tools">
						<?php foreach($tool_group as $group){ ?>
<?php foreach($group['tools'] as $tool ){ ?>

<div class="tools" style="    padding: 30px 0 0; overflow:auto;">
<?php echo anagram_resize_image(array('width'=>75, 'height'=>75, 'image_id' =>$tool['image'],'crop'=>true, 'img_class'=>"img-thumbnail img-responsive img-circle pull-left")); ?>
	<div class="tool-info" style="padding-left:85px;">
								<div class="event-cat"><?php echo $group['title'] ; ?></div>
								<div class="event-title"><h4><?php echo $tool['name'] ; ?></h4></div>
								<div class="event-excerpt"><?php echo $tool['description'] ; ?></div>
								<hr/>
	</div>


</div>


<?php } ?>

							<?php } ?>
		</div>

<?php }; ?>






	<?php  if( get_field('gallery') ):
								 echo do_shortcode('[gallery include="'. implode(',',wp_list_pluck( get_field('gallery'), 'ID' )).'"  columns="3" size="post-thumbnail"]');
	endif; ?>


	<?php  if( get_field('member_gallery') ):
								 echo do_shortcode('[gallery include="'. implode(',',wp_list_pluck( get_field('member_gallery'), 'ID' )).'"  columns="3" size="post-thumbnail"]');
	endif; ?>

	<?php // check if the flexible content field has rows of data
if( have_rows('content_types') ):

 	// loop through the rows of data
    while ( have_rows('content_types') ) : the_row();

		// check current row layout
        if( get_row_layout() == 'single_content' ): ?>
		<div class="other-details">
        	 <h2><?php the_sub_field('title'); ?></h2>
        	 <?php the_sub_field('content'); ?>
		</div>

       <?php  elseif( get_row_layout() == '2_column' ):

        	// check if the nested repeater field has rows of data
        	if( have_rows('columns') ): ?>
			<div class="other-details columns row">

			 	<?php // loop through the rows of data
			    while ( have_rows('columns') ) : the_row(); ?>
				<div class="col-sm-6">
					<h2> <?php the_sub_field('title'); ?></h2>
					 <?php the_sub_field('content'); ?>

				</div>
			 <?php 	endwhile; ?>
			</div>

			<?php	endif;

      elseif( get_row_layout() == 'tabbed' ):

        	// check if the nested repeater field has rows of data
        	if( have_rows('tabs') ): ?>
        	 <div class="tabs clearfix">

					  <ul id="navTabs" class="" role="tablist">
					  <?php $t=1;  while ( have_rows('tabs') ) : the_row();
					 $cleantitle= sanitize_title( get_sub_field("title") ); ?>
					   	<li role="presentation" class="<?php if($t == 1){echo ' active';}?>"><a href="#<?php echo $cleantitle; ?>" aria-controls="<?php echo $cleantitle; ?>" role="tab" data-toggle="tab"><?php the_sub_field("title"); ?></a></li>
							<?php $t++;endwhile; ?>
					  </ul>

			 </div>

        	 <div class="holder tab-content">


			 	<?php // loop through the rows of data
			   $z=1; while ( have_rows('tabs') ) : the_row();
			     $cleantitle= sanitize_title( get_sub_field("title") );?>
				<div class="other-details tab-pane  <?php if($z == 1 ){echo ' active';}?>" id="<?php echo $cleantitle; ?>">
					<h2> <?php the_sub_field('title'); ?></h2>
					 <?php the_sub_field('content'); ?>

				</div>
			 <?php 	$z++; endwhile; ?>

        	 </div>

			<?php	endif;
       elseif( get_row_layout() == 'expander' ): ?>
       <div class="holder expand">
			<div class="other-details">
					<h2> <?php the_sub_field('title'); ?>&nbsp;<i class="fa fa-angle-down fa-lg"></i></h2>
					 <div class="inner-text"><?php the_sub_field('content'); ?></div>

			</div>
       </div>
			<?php
        endif;




    endwhile;

else :

    // no layouts found

endif;

?>



		<?php
		// check if the flexible content field has rows of data
		if( have_rows('staff') ): ?>
		<h2><?php the_field('staff_header','options'); ?></h2>

		   <?php  // loop through the rows of data
		    while ( have_rows('staff') ) : the_row();

		        if( get_row_layout() == 'department' ): ?>

		        	<h3><?php the_sub_field('department_title'); ?></h3>

		        <?php elseif( get_row_layout() == 'people' ):

		        	$peoples = get_sub_field('people'); ?>
		        	        <div id="no-more-tables" class="searchable-container clearfix">
		        	<table class="table">


		        	<?php foreach($peoples as $people){ ?>
<tr class="people">
			        	 <td   data-title="Name" width="30%"><?php echo $people['name'];?> <?php if($people['email']) echo '<a href="mailto:'.$people['email'].'" class="pull-right"><i class="fa fa-envelope-o"></i></a>';?></td>
			        	 <td   data-title="Title"  width="30%"><?php echo $people['title'];?>&nbsp;</td>
			        	 <td  data-title="Phone"  width="20%"><?php echo $people['phone'];?>&nbsp;</td>

			        	   </tr>
		        	<?php } ?>

      </table>
		        	        </div>
		       <?php endif;

		    endwhile;

		endif;

		?>


<?php if( is_page(1192) ): ?>

		<?php

$taxonomy = 'sponsor_level';
$term_args=array(
 	//'orderby'    => 'custom_sort',
 	'exclude'           => array(189),
 	'hide_empty' => 0//,
 	//'parent' => 1
);
$i =0;
$terms = get_terms($taxonomy,$term_args);
if ($terms): ?>


	<div class="tabs clearfix">
  <ul id="navTabs" class="" role="tablist">
  <?php $t=1;foreach( $terms as $term ) : ?>
   	<li role="presentation" class="<?php if($t == 1){echo ' active';}?>"><a href="#<?php echo $term->slug; ?>" aria-controls="<?php echo $term->slug; ?>" role="tab" data-toggle="tab"><?php echo $term->name; ?></a></li>
		<?php $t++;endforeach; ?>
  </ul>

 </div>
 <div class="tab-content">
<?php
	$y=1;
  foreach( $terms as $term ) :
    $args=array(
      'sponsor_level' => $term->slug,
      'post_type'=>'sponsor',
      'posts_per_page' => -1,
      'orderby' => 'title',
      'order' => 'ASC',
      'post_status' => 'publish'
      );

    $sponsor_query = null;

    $sponsor_query = new WP_Query($args);?>
<div class="other-details tab-pane <?php if($y === 1  ){echo ' active';}?>" id="<?php echo $term->slug; ?>">
 <h3 class="colored"><?php echo $term->name; ?></h4>
  <p><?php echo wpautop( wptexturize( $term->description ) ); ?></p>

    <?php if( $sponsor_query->have_posts()  ) :
      while ($sponsor_query->have_posts()) : $sponsor_query->the_post();
      $image = get_field('logo');
 ?>
 <?php if($term->slug=='corporate-sponsors'){ ?>
	<div class="other-details row">
					<div class="clearfix border-bottom"></div>
						<div class="<?php if($image ){ ?>col-md-15<?php }else{ ?>col-md-20<?php }; ?>">


							<h4><strong><?php  the_title();  ?></strong></h4>
							<div><?php  echo get_field('description');  ?></div>

						</div>

						<?php if($image ){ ?>
						<div class="col-md-5 image-block">
								<a href="<?php echo get_field('website'); ?>" target="_blank"><?php echo anagram_resize_image(array('image_id'=>$image, 'width'=> 300)); ?></a>
						</div>
						<?php }; ?>
			</div>
			<?php }else{ ?>

			<div class="sq-thumbnail">
								<a href="<?php echo get_field('website'); ?>" target="_blank"><?php echo anagram_resize_image(array('image_id'=>$image, 'width'=> 300)); ?></a>
						</div>
			<?php } ?>
   <?php $i++;  endwhile; ?>



<?php
wp_reset_query();  // Restore global post data stomped by the_post().
 endif; ?>
 </div>
<?php $y++; endforeach; ?>
</div>
<?php endif;
   ?>


<?php endif; ?>



<?php if( is_page(array(3701,3696) ) ): ?>


<?php


    $args=array(
      'sponsor_level' => 'standard',
      'post_type'=>'sponsor',
      'posts_per_page' => -1,
      'orderby' => 'title',
      'order' => 'ASC',
      'post_status' => 'publish'
      );

    $sponsor_query = null;

    $sponsor_query = new WP_Query($args);?>
<div class="other-details">
<h3>O'Keeffe <?php echo get_the_title(); ?></h3>

    <?php if( $sponsor_query->have_posts()  ) :
      while ($sponsor_query->have_posts()) : $sponsor_query->the_post();
      $image = get_field('logo'); ?>
 <div class="other-details row">
					<div class="clearfix border-bottom"></div>
						<div class="<?php if($image ){ ?>col-md-15<?php }else{ ?>col-md-20<?php }; ?>">


							<h4><strong><?php  the_title();  ?></strong></h4>
							<div><?php  echo get_field('description');  ?></div>

						</div>

						<?php if($image ){ ?>
						<div class="col-md-5 image-block">
								<a href="<?php echo get_field('website'); ?>" target="_blank"><?php echo anagram_resize_image(array('image_id'=>$image, 'width'=> 300)); ?></a>
						</div>
						<?php }; ?>
			</div>





   <?php  endwhile; ?>



<?php
wp_reset_query();  // Restore global post data stomped by the_post().
 endif; ?>
 </div>




<?php endif; ?>









