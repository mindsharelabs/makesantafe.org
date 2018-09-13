<?php 	/*
		Template Name: Event Page
		*/

		get_header(); ?>

		 <?php

  $today = current_time( 'timestamp', '' );
 // mapi_var_dump( date('l, F jS g:ia',current_time( 'timestamp', '' )) );
$eventArray = array();
		$args = array (
		    'post_type' => 'event',
		    'posts_per_page' => -1,
/*
		    'meta_query' => array(
			    'relation'		=> 'OR',
				array(
			        'key'		=> 'recurring_dates_%_date',
			        'compare'	=> '>=',
			        'value'		=> $today,
			    )
		    ),
*/
		);
    $my_query = null;
	$my_query = new WP_Query($args);

    if ($my_query->have_posts() ) :  while ($my_query->have_posts()) : $my_query->the_post();
			///var_dump(get_field('start_date'));
							$recurring_dates = get_field('recurring_dates');
							$venue = get_field('venue');
							$type = get_custom_taxonomy('event_cat',', ','name');
							$type_slug = get_custom_taxonomy('event_cat',', ','slug');

							if($recurring_dates){
								foreach($recurring_dates as $row){
									$past = '';
									$startdate = strtotime($row['date']);
									$enddate = strtotime($row['end_time']);
									if( !($startdate>=$today )) $past = 'past';//continue;
										//var_dump(date("g:ia",$startdate ));
										if( $past !== 'past')$event_ids[] = get_the_ID();

									$timeinfo = !empty($row['end_time']) ? date("g:ia",$startdate ).'-'.date("g:ia",$enddate) : date("g:ia",$startdate );

									$theday = (date('Y', $today)==date("Y", $startdate )) ? date("D, F jS",$startdate ) : date("D, F jS, Y",$startdate );
									if(date("mdy", $startdate) !== date("mdy", $enddate)){
											$theday = date("M d, Y", $startdate).' - '.date("M d, Y", $enddate);
											$timeinfo = 'Multi-day Event';
									};

									$thedate = date("Y-m-d",  $startdate);
									$theenddate = date("Y-m-d",  $enddate);

									$sortdate = $past !== 'past' ? $startdate :'-'.$startdate;

									$eventArray[] = array(
										  'sort_date' => $sortdate,
										  'date' => $thedate,
										  'end' => $theenddate,
										  'day' => $theday,
										  'time' => date("g:i a",$startdate ),
										  'end_time' => date("g:ia",$enddate),
										  'time_info' => $timeinfo,
										  //'event_notes' => $row['notes'],
										   'event_notes' => '',
										  'title' => get_the_title(),
										  'past' => $past,
										  'url' => get_permalink().$thedate.'/',
										  'cat' => $type,
										  'cat_slug' => $type_slug,
										  'artists' => ''
								  );
								}

							}


				 endwhile;endif;wp_reset_postdata();


   //echo '<pre>';var_dump($eventArray);echo '</pre>';
				 usort($eventArray, function($a, $b) {
					    return $a['sort_date'] - $b['sort_date'];
					});
				 ?>



<?php
				   $catargs = array(
											    'orderby'       => 'name',
											    'order'         => 'ASC',
											    //'fields' => 'all_with_object_id' //for returning all, duplicates for count
											);
              $thetypes = wp_get_object_terms( $event_ids, 'event_cat', $catargs );

	?>


<div class="row">

	<div class="col-sm-8 col-md-push-4  has-sidebar">
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




		 <span class="loading" ><i class="fa fa-spinner fa-spin fa-3x fa-fw margin-bottom"></i></span>
			 <div id="full-clndr" class=" clearfix">
			        <script type="text/template" id="full-clndr-template">
						<div class="clndr-holder ">
			                <div class="clndr-controls">
			                	<div class="clndr-previous-button"><i class="fa fa-angle-left fa-3x"></i> <span class="hidden-xs">Previous Mouth</span></div>
			                    <div id="list-title" class="month">Events in <%= month %> <%= year %></div>
			                    <div class="clndr-next-button"><span class="hidden-xs">Next Month</span> <i class="fa fa-angle-right fa-3x"></i></div>
			                </div>
			                 <div class="clndr-grid">
			                  <div class="days-of-the-week">
								  <% _.each(daysOfTheWeek, function(day) { %>
								  	<div class="header-day"><%= day %></div>
								  <% }); %>
			                </div>
			                 	<div class="days">
							 		<% _.each(days, function(day) {
							 					if(moment(extras.firstDate).format('X')==day.date.format('X') || moment(extras.lastDate).format('X')==day.date.format('X')){ day.classes+=' selected';};
							 					if(moment(extras.firstDate).format('X')<=day.date.format('X') && moment(extras.lastDate).format('X') >= day.date.format('X') && extras.lastDate!=''){ day.classes+=' in-range';//console.log(day.classes);
							 				 }; %>
							 				<div  id="<%= day.id %>" rel="<%= day.id %>" class="<%= day.classes %>">
			                                <%= day.day %>
												<% if (day.events.length !== 0) { %>
												   <div class="event-indicator" ng-show="day.events.length"><%= day.events.length  %></div>
												<% } %>

			                              </div>
			                <% }); %>
							</div>

						</div>
			        </script>
			</div><!-- end clndr template -->

		            <div class="clndr-list-content">
		                <div class="clndr-event-list">

		                <!--  <% _.each(eventsThisMonth, function(event) { %>
		                   <div id="" class="<%= event.type %>" data-day="<%= event.day %>" data-date="<%= event.sort_date %>">
		                   <div class="event-title"><h5><a href="<%= event.url %>"><%= event.title %></a></h5></div>
		                    <div class="event-date"><strong><%= event.day %><small><%= event.time %></small></strong><div class="event-info"><%= event.time_info %></div></div>
		                    <div class="clndr-event-desc">
		                    <div class="event-artist"><%= event.artists %></div>
		                    <div class="event-location"><strong><%= event.location %></strong></div>
		                    <div class="event-cat"><%= event.type_link %></div>
							</div>
		                  </div>
		                <% }); %> -->
		                </div>
		            </div>


			</div><!-- .entry-content -->
		</article><!-- #post-## -->
			<?php endwhile; // end of the loop. ?>



					<?php include('content/sub-content.php'); ?>
		</div>
	</div>
	<div class="col-sm-4 col-md-pull-8  left-bg">
		<div class="sidebar">
		<aside class="widget"><div class="widget-header"><h3 class="widget-title">Filter Events</h3>
		 <?php echo file_get_contents(get_template_directory_uri()."/img/title-side-bg.svg"); ?></div>
			<div class="widget-content">
			<ul class="filter-list list-unstyled mobilehide"  data-filter-group="category">
									<?php
									//var_dump($the_terms);
								   		 echo '<li role="presentation"><a  href="/" data-filter="all" class="filterit">Show All Upcoming</a></li>';
										foreach($thetypes as $type){
										      echo '<li class="'.$type->slug .'"><a  href="'.get_the_permalink().'type/'.$type->slug.'/"  data-filter="'.$type->slug .'"   class="filterit" >'. esc_html( $type->name )  .'</a></li>';
										    } ?>

										   <li class="past"><a  href="<?php echo get_the_permalink(); ?>'type/past/"  data-filter="past"   class="filterit" >Past Events</a></li>
													</ul>
			</div>
	</aside>

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




		</div>

	</div>
</div>


<?php $current_slug='';if(isset($wp_query->query_vars['cat_name']))  {$current_slug = $wp_query->query_vars['cat_name']; } ?>



<script>

var defaultURL = '<?php echo get_permalink( $post->ID ); ?>';

var current_slug = '<?php echo $current_slug; ?>';


var today = '<?php echo date("Y-m-d" ); ?>';
var events = <?php echo json_encode($eventArray);?>;

</script>

<?php get_footer(); ?>