 <?php

	     /*CHECK on event query
		     http://www.advancedcustomfields.com/resources/querying-the-database-for-repeater-sub-field-values/

	     */
  $today = current_time( 'timestamp', '' );
 // mapi_var_dump( date('l, F jS g:ia',current_time( 'timestamp', '' )) );

		$args = array (
		    'post_type' => 'event',
		    'posts_per_page' => -1,
/*
		    'tax_query' => array(
				array(
					'taxonomy' => 'event_cat',
					'field'    => 'slug',
					'terms'    => 'look-closer',
				),
			),
*/
		    'meta_query' => array(
			    'relation'		=> 'OR',
				array(
			        'key'		=> 'event_schedule_%_date',
			        'compare'	=> '>=',
			        'value'		=> $today,
			    ),
			    array(
	                'key' => 'start_date',
					'value' => $today,
					'compare' => '>='
	            )

			     //array(
			     //   'key'		=> 'event_schedule_%_end_date',
			     //   'compare'	=> '>=',
			     //   'value'		=> $today,
			    //)
		    ),
		);
    $my_query = null;
	$my_query = new WP_Query($args);

    if ($my_query->have_posts() ) :  while ($my_query->have_posts()) : $my_query->the_post();
			///var_dump(get_field('start_date'));
							$event_schedule = get_field('event_schedule');
							$venue = get_field('venue');
							$type = get_custom_taxonomy('event_cat',', ','name');
							$type_slug = get_custom_taxonomy('event_cat',', ','slug');

							$event_ids[] = get_the_ID();
							if($event_schedule){
								foreach($event_schedule as $row){
									$startdate = strtotime($row['date']);
									$enddate = strtotime($row['end_time']);
									if( !($startdate>=$today ))continue;
										//var_dump(date("g:ia",$startdate ));

									$timeinfo = !empty($row['end_time']) ? date("g:ia",$startdate ).'-'.date("g:ia",strtotime($enddate)) : date("g:ia",$startdate );
									$theday = (date('Y', $today)==date("Y", $startdate )) ? date("l, F jS",$startdate ) : date("l, F jS, Y",$startdate );
									$thedate = date("Y-m-d",  $startdate);
									$eventArray[] = array(
										  'sort_date' => $startdate,
										  'date' => $thedate,
										  'end' => $thedate,
										  'day' => $theday,
										  'time' => date("g:i a",$startdate ),
										  'end_time' => date("g:ia",$enddate),
										  'time_info' => $timeinfo,
										  'event_text' => get_field('power_paragraph'),
										  'sub_title' => get_field('sub_title'),
										  'event_notes' => $row['notes'],
										  'title' => get_the_title(),
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










 <span class="loading" ><i class="fa fa-spinner fa-spin fa-3x fa-fw margin-bottom"></i></span>

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















	</div>
	<div class="col-sm-4  sidebar-right">

<h3 class="underline">Filter Events</h3>
	<ul class="filter-list list-unstyled mobilehide"  data-filter-group="category">
							<?php
							//var_dump($the_terms);
						   		 echo '<li role="presentation"><a  href="/" data-filter="all" class="filterit">Show All</a></li>';
								foreach($thetypes as $type){
								      echo '<li class="'.$type->slug .'"><a  href="'.get_the_permalink().'type/'.$type->slug.'/"  data-filter="'.$type->slug .'"   class="filterit" >'. esc_html( $type->name )  .'</a></li>';
								    } ?>
											</ul>



 <div id="full-clndr" class=" clearfix">
        <script type="text/template" id="full-clndr-template">

      <div class="clndr-holder ">


                <div class="clndr-controls">
                	<div class="clndr-previous-button"><i class="fa fa-angle-left"></i></div>
                    <div class="month"><%= month %> <%= year %></div>
                    <div class="clndr-next-button"><i class="fa fa-angle-right"></i></div>
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


<?php $current_slug='';if(isset($wp_query->query_vars['cat_name']))  {$current_slug = $wp_query->query_vars['cat_name']; } ?>



<script>

var defaultURL = '<?php echo get_permalink( $post->ID ); ?>';

var current_slug = '<?php echo $current_slug; ?>';


var today = '<?php echo date("Y-m-d" ); ?>';
var events = <?php echo json_encode($eventArray);?>;

</script>