<?php get_header(); ?>
<div class="row">

	<div class="col-md-8 col-md-push-4 has-sidebar">
	<div class="content">
	<?php while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<h1 class="page-title"><?php echo get_custom_taxonomy('event_cat',', ','name'); ?>: <?php the_title(); ?> </h1>
	</header><!-- .entry-header -->

	<div class="row">
		<?php if ( has_post_thumbnail() ) { ?>
				<div class="col-sm-5 col-sm-push-7">
				<?php echo anagram_resize_image(array('width'=>740, 'height'=>740, 'crop' => true, 'upscale'=>true, 'img_class' => 'img-circle')); ?>
				<?php //be_display_image_and_caption('large'); ?>
				</div>
				<div class="event-details col-sm-7 col-sm-pull-5">
		<?php }else{ ?>
			<div class="event-details col-md-12">
		<?php }; ?>


		<?php

//var_dump(strtotime($event_date));

$today = current_time( 'timestamp', '' );
$recurring_dates = get_field('recurring_dates');
usort($recurring_dates, function($a, $b) {
		return $a['date'] - $b['date'];
	});
if($recurring_dates){
	$e = 0;
	$past_only = true;
	$past = false;
	$upcoming = false;
	//$upcoming = array();
	$first = reset($recurring_dates);
	$last = end($recurring_dates);
	foreach($recurring_dates as $row){
		$startdate = strtotime($row['date']);
		$enddate = strtotime($row['end_time']);
		$datelocation = get_term_by('id', $row['location'], 'event_loc');
		//mapi_var_dump(date("Y-m-d g:i a",$row['end_time']).' - '.date("Y-m-d g:i a",$today) );

		if( !($enddate>=$today )){
			$phase = 'past';
			$past = true;
		}else if($e===0){
				$date = date("M, d Y", $startdate);
				$time = date("g:i a", $startdate);
				if($row['end_time']){  $time= date("g:i a", $startdate).' - '.date("g:i a", $enddate ); };
				if(date("mdy", $startdate) !== date("mdy", $enddate )){
					$date = date("M, d Y", $startdate).' - '.date("M, d Y", $enddate );
					$time = 'Multi-day Event';
					$phase = 'upcoming';
				};


				$phase = 'next';
				$currentevent =array(
					'date' => $date,
					'time' => $time,
					//'enddate' => $enddate,
					'notes' => $row['notes'],
					'location' => $datelocation,
					'ticket' => $row['ticket']

				);
				$past_only = false;
				$e++;
			}else{
			$phase = 'upcoming';$upcoming=true;$past_only = false;
		};
		$datelink = date("Y-m-d", $startdate);
		$date = date("M, d Y", $startdate);
		$time = date("g:i a", $startdate);
		if($row['end_time']){  $time= date("g:i a", $startdate).' - '.date("g:i a", $enddate ); };
		if(date("mdy", $startdate) !== date("mdy", $enddate )){
			$date = date("M d, Y", $startdate).' - '.date("M d, Y", $enddate );
			$time = 'Multi-day Event';
		};
		$eventlist[$datelink] = array(
			'phase' => $phase,
			'date' => $date,
			//'enddate' => $enddate,
			'time' => $time,
			'notes' => $row['notes'],
			'location' => $datelocation,
			'ticket' => $row['ticket']

		);

	}


}?>
	<?php $event_date='';if(isset($wp_query->query_vars['event_date']))  {$event_date = $wp_query->query_vars['event_date'];



	$currentevent =array(
		'date' => $eventlist[$event_date]['date'],
		//'enddate' => $eventlist[$event_date]['enddate'],
		'time' => $eventlist[$event_date]['time'],
		'notes' => $eventlist[$event_date]['notes'],
		'location' => $eventlist[$event_date]['location'],
		'ticket' => $eventlist[$event_date]['ticket']
	);
	unset($eventlist[$event_date]);

	$endOfDay = strtotime("midnight", $today);

	if( strtotime($event_date) < $endOfDay ){
		$past_only = true;
	};

} ?>
	<?php  //mapi_var_dump($currentevent['location']);


if($past_only){ ?>

	<div><span class=" bold">This is a past event.</span> <br/><!--  <?php foreach($eventlist as $key =>  $event){ if($event['phase']==='past')echo $event['date'].' at <strong>'.$event['time'].'</strong><br/>';}; ?> -->
	</div>
	<?php }else{ ?>
	<div><span class="text-uppercase blue bold">Date:  </span> <?php echo $currentevent['date']; ?>
		<?php if($upcoming){ ?> <span class="showhide pull-right"><?php $recurrence_info = get_field('recurrence_info'); if( ($recurrence_info=='Default' || !$recurrence_info) ){ echo 'Recurring';  }else{ echo $recurrence_info; }; ?> <i class="fa fa-caret-square-o-down"></i></span>
			 <div class="upcoming-dates toshow">
			   <?php foreach($eventlist as $key =>  $event){
			if($event['phase']==='next' && $event_date !=$key)echo $event['date'].' at <strong>'.$event['time'].'</strong> - <a href="'.get_permalink().$key.'/">view</a><br/>';
			if($event['phase']==='upcoming')echo $event['date'].' at <strong>'.$event['time'].'</strong> - <a href="'.get_permalink().$key.'/">view</a><br/>';}; ?>
			 </div>
		<?php } ?>
	</div>

	<div><span class="text-uppercase blue bold">Time: </span> <?php echo $currentevent['time']; ?></div>
	<?php  if($currentevent['location']){ ?><div><span class="text-uppercase blue bold">Location: </span> <?php echo $currentevent['location']->name; ?></div><?php }  ?>
	<?php if($currentevent['notes']){ ?><div><span class="text-uppercase blue bold">Notes: </span> <?php echo $currentevent['notes']; ?></div><?php } ?>

<?php if(!get_field('hide_cost') ){ ?>

	<?php  if( !(edd_has_variable_prices($currentevent['ticket']) || edd_pl_get_file_purchase_limit( $currentevent['ticket'] )===0  ) ){ ?>
	<div><span class="text-uppercase blue bold">Open Spots: </span> <?php if(anagram_get_total_ticket_limit( $currentevent['ticket'] ) ===0 ){ echo '<strong>Registration is full</strong><br/> Please use the "Request more information" form below to be added to the waiting list.';}else{
				echo anagram_get_total_ticket_limit( $currentevent['ticket'] );
				//echo ' out of '.edd_pl_get_file_purchase_limit($currentevent['ticket']).' left';
			}; ?></div>
	<?php }
?>
	<div class="thecost"><span class="text-uppercase blue bold">Cost: </span>
		<?php if($currentevent['ticket']){

			$item_price = edd_get_download_price( $currentevent['ticket'] );
			//var_dump($item_price);


			if(edd_has_variable_prices($currentevent['ticket'])) {
				// if the download has variable prices, show the first one as a starting price
				echo edd_price_range($currentevent['ticket']);
			} else {

				if($item_price==='0.00'){
					echo 'Event is free with registration';
				}else{
					$edd_cat = wp_list_pluck(get_the_terms($currentevent['ticket'], 'download_category', array('include'=> array($currentevent['ticket']),'fields' => 'id=>slug') ), 'slug');
					//mapi_var_dump(wp_get_post_terms($currentevent['ticket'], 'download_category' ));

					if( (in_array("member-discount", $edd_cat ) || in_array("training", $edd_cat ) ) ){
						echo '$'.number_format($item_price*.85, 2, '.', '').' / Non-Members ';
					}
					if( (in_array("member-free", $edd_cat ) ) ){
						echo 'Free for Members / Non-Members ';
					}


					edd_price($currentevent['ticket']);

				};

			 if(get_field('material_costs', $currentevent['ticket']))echo '<br/>plus a $'.get_field('material_costs',$currentevent['ticket']).' materials fee';

			};


?>

	</div>
<div class="thebutton">
		<?php if(edd_has_variable_prices($currentevent['ticket'])){
				echo edd_get_purchase_link( array( 'download_id' => $currentevent['ticket'],'price' => false, 'direct'=> false, 'text' => 'Sign Up', 'class'=>'btn btn-default') );

			}elseif( $item_price!=='0.00'  ){
				echo edd_get_purchase_link( array( 'download_id' => $currentevent['ticket'],'price' => false, 'direct'=> false, 'text' => 'Sign Up', 'class'=>'btn btn-default') );
			}else{
				echo edd_get_purchase_link( array( 'download_id' => $currentevent['ticket'],'price' => false, 'direct'=> false, 'text' => 'RSVP', 'class'=>'btn btn-default') );
			};
?>
			<?php if( !anagram_is_member() && (in_array("member-discount", $edd_cat ) || in_array("training", $edd_cat ) ) ):?>
		<div class="member-notice"><p>Members enjoy <a href="<?php echo get_the_permalink(118); ?>">numerous benefits</a> in addition to discounted classes!</p><a href="<?php echo get_the_permalink(118); ?>" class="btn btn-default btn-sm">Become a member today!</a></div>
<?php endif; ?>
		</div>
		<?php }else{
			//no ticket attached
?>
		<div>Free Event - No registration needed.</div>
		<?php } ?>

<?php }; //hide all cost/ticket info ?>



	<?php  }; //end current event ?>
		<div class="event-info">
		<?php the_content(); ?>

		 <?php if(get_field('about_the_instructor'))echo '<h4>About the Instructor:</h4>'.get_field('about_the_instructor'); ?>
		</div>

			<?php if($past){ ?>

			 <div class="past-dates toshow">
			 <strong>Past Dates</strong><br/>
			    <?php foreach($eventlist as $key =>  $event){ if($event['phase']==='past')echo $event['date'].' at <strong>'.$event['time'].'</strong><br/>';}; ?>

			 </div>

		<?php } ?>



</div>  <!-- end column-->




<?php if( current_user_can('publish_posts')  && !empty($currentevent['ticket'])) { ?>
<div class="col-md-12">
<div class="panel panel-default clear">
	<div class="panel-heading"><strong>Signed up Makers</strong> - This list is only visible to Admins and Editors</div>
<!-- 	<div class="panel-body"> <p>This list is only visible to Admins and Editors</p> </div> -->
	<div id="no-more-tables">
	<table class="table"> <thead> <tr> <th>#</th> <th>Maker</th> <th>Email</th> <th>Payment ID</th> </tr> </thead>
		<tbody>
		<?php

	global  $edd_logs;


	$sales = $edd_logs->get_logs( $currentevent['ticket'], 'sale', $page );


	if (  $sales ) {
		$i=1;
		foreach ( $sales as $log ) {
			$payment_id = get_post_meta( $log->ID, '_edd_log_payment_id', true );
			$user_info = edd_get_payment_meta_user_info( $payment_id );

			if ( $user_info['id'] != 0) {
				$user_data = get_userdata( $user_info['id'] );
				$name = $user_data->display_name;
				$email = $user_data->user_email;
			} else {
				$name = $user_info['first_name'] . ' ' . $user_info['last_name'];
			}

			echo '<tr>';
			echo '<td  data-title="Order">'.$i.'</td>';
			echo '<td data-title="Maker">'.$name.'</td>';
			echo '<td data-title="Eamil"><a href="mailto:' . $email . '">'.$email.'</a></td>';
			echo '<td data-title="Payment ID"><a href="' . admin_url('edit.php?post_type=download&page=edd-payment-history&view=view-order-details&id=' . $payment_id ) . '">' . $payment_id . '</a></td>';
			echo '</tr>';

			$i++;
		} // Endforeach

	} else {

		echo '<tr><td colspan="4">No registrations yet </td></tr>';

	}
?>
		</tbody>
	</table>
	</div>
</div>
</div>



	<?php  }else{ //show map  ?>


<div class="col-md-12">

<?php  if($currentevent['location'] && get_field('location',$currentevent['location'])){ ?>
	<div>
		<h2 class="underline text-uppercase blue bold">Location</h2>
		<strong><?php  echo  $currentevent['location']->name; ?></strong>
	</div>
			<?php if(get_field('location',$currentevent['location'])){ ?>
			<div>
				<?php $location = get_field('location',$currentevent['location']); echo $location['address']; ?>
			</div>
			<?php } ?>
		<?php } ?>
	 <?php if( !empty($location) ): ?>

	 <?php  echo do_shortcode( '[anagram_map name="'.$currentevent['location']->name.'" address="'.$location['address'].'" lat="' .$location['lat'] . '" lng="' .$location['lng'] . '" ]' );?>
	<?php endif; ?>

</div>

	 <?php } //end show map  ?>



		<?php endwhile; // end of the loop. ?>

				</div><!-- End row -->

	</article><!-- #post-## -->
	</div>
	</div>
		<div class="col-md-4 col-md-pull-8 left-bg">
	<div class="sidebar">
			<?php  $people = get_field('people');
$guests = get_field('special_guests');

if($people || $guests){ ?>
			<aside class="widget">
		<div class="widget-header">
			<h3 class="widget-title">Instructors</h3>
			 <?php echo file_get_contents(get_template_directory_uri()."/img/title-side-bg.svg"); ?></div>
				<div class="widget-content">
		<?php
	if($people ){
		foreach($people as $person):
			//var_dump($person); ?>
			<div class="person clearfix">
						<a href="<?php echo get_author_posts_url( $person['ID'] ); ?>"><img src="<?php echo get_wp_user_avatar_src( $person['ID'], 'thumbnail' ); ?>" width="65" height="65" class="alignleft img-thumbnail img-responsive img-circle" /></a>
							<h5 class="nomargin-bottom"><a href="<?php echo get_author_posts_url( $person['ID'] ); ?>"><?php echo $person['display_name']; ?></a></h5>
							<?php echo get_the_author_meta( 'title', $person['ID'] ); ?>

					</div>
		<?php endforeach; }; ?>


			<?php if( $guests ){
		foreach($guests  as $guest):
			//var_dump($person); ?>
			<div class="person  clearfix">
					<?php if($guest['photo']){ ?>	<img src="<?php echo anagram_resize_image(array('image_id' => $guest['photo'],'width'=>75, 'height'=>75, 'crop'=>true, 'url' => true)); ?>"width="65" height="65" class="alignleft img-thumbnail img-responsive img-circle"  /><?php  }; ?>
			<h5 class="nomargin-bottom"><?php echo $guest['display_name']; ?></h5>
			<?php if($guest['credentials']){ echo $guest['credentials']; }; ?>
				<p><?php echo $guest['bio']; ?></p>
				</div>
				<?php endforeach;  }; ?>

				</div>
			</aside>
		<?php } ?>







		<aside class="widget">
			<div class="widget-header">
				<h3 class="widget-title">Share This</h3>
				 <?php echo file_get_contents(get_template_directory_uri()."/img/title-side-bg.svg"); ?></div>
					<div class="widget-content">
				<?php echo get_share_icons(get_permalink(), get_the_title(), ''); ?>
			</div>
		</aside>


		<?php get_sidebar(); ?>


<?php if(get_field('sidebar_blocks',106) ):?>
		    		<?php while(has_sub_field('sidebar_blocks',106)): ?>
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
<?php get_footer(); ?>