<?php

	function get_event_summery( $event_data ) {

			    global $post;
						 $ret = '<div>';
						 $end='';
						$ret .= '<div class="event-cat">'.$event_data['cat'].'</div>';
						$ret .= '<div class="event-date">';
						//$ret .= '<strong>'.$event_data['time_info'].'</strong><br/>';
						$ret .= $event_data['day'];
						$ret .= '</div>';
			            $ret .= '<h5 class=" nomargin"><a href="'.$event_data['url'].'">'. $event_data['title'] .'</a></h5>';
			            $ret .= '<hr/></div>';

			    return $ret;

			}

  $today = current_time( 'timestamp', '' );

		$args = array (
		    'post_type' => 'event',
		    'tax_query' => array(
				array(
					'taxonomy' => 'event_cat',
					'field'    => 'slug',
					'terms'    => 'workshop',
				),
			),
		   'posts_per_page' => -1,
		   'post__not_in' => array($post->ID),
		    'meta_query' => array(
				array(
			        'key'		=> 'recurring_dates_%_date',
			        'compare'	=> '>=',
			        'value'		=> $today,
			    )
		    ),
		);

$eventArray =array();


    $my_query = null;
	$my_query = new WP_Query($args);

    if ($my_query->have_posts() ) :  while ($my_query->have_posts()) : $my_query->the_post();


							$recurring_dates = get_field('recurring_dates');
							$cat = get_custom_taxonomy('event_cat',', ','name');

							$event_ids[] = get_the_ID();
							if($recurring_dates){
								foreach($recurring_dates as $recurring){
									$startdate = strtotime($recurring['date']);
									$enddate = strtotime($recurring['end_time']);
									if( !($startdate>=$today ))continue;

										//var_dump($startdate );

										$date = date("M, d Y", $startdate);
										$time = date("g:i a", $startdate);
										if($recurring['end_time']){  $time= date("g:i a", $startdate).' - '.date("g:i a", $enddate); };
										if(date("mdy", $startdate) !== date("mdy", $enddate)){
											$date = date("M d, Y", $startdate).' - '.date("M d, Y", $enddate);
											$time = 'Multi-day Event';
										};

										$thedate = date("Y-m-d",  $startdate);

									$eventArray[] = array(
										  'sort_date' => $startdate,
										  'date' => $thedate,
										  'end' => $thedate,
										  'day' => $date,
										  'time' => date("g:i a",$startdate ),
										  'end_time' => date("g:ia", $enddate),
										  'time_info' => $time,
										  'event_notes' => $recurring['notes'],
										  'title' => get_the_title(),
										  'url' => get_permalink().''.$thedate.'/',
										  'cat' => $cat,
								  );
								}

							}



				 endwhile;endif;wp_reset_postdata();

				 usort($eventArray, function($a, $b) {
					    return $a['sort_date'] - $b['sort_date'];
					});
					$events = array_slice($eventArray, 0, 2);


				if ( $events ) :



					 ?>
					<aside class="widget"><div class="widget-header"><h3 class="widget-title">Upcoming Workshops</h3>
							 <?php echo file_get_contents(get_template_directory_uri()."/img/title-side-bg.svg"); ?></div>
								<div class="widget-content">
			 			<?php  foreach($events as $eventdata){
							echo get_event_summery($eventdata);
						}; ?>

						<a href="<?php echo get_the_permalink(106); ?>" class="btn btn-default btn-sm">View more</a>
					  </div>
				</aside>
		 <?php endif; ?>
