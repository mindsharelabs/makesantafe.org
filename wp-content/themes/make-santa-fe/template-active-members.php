<?php /*Template Name: Active Members

*/
get_header(); ?>
		<div class="content">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="page-header">
				<h1 class="page-title"><?php the_title(); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">

			<?php
				$theusers = array();
				$the_roles = array('member','member-other','volunteer' );
				foreach ($the_roles as $role) :
					$args = array(

						'role' => $role,
						'orderby' => 'display_name',
						'number' => 400
						//'include' => $user_ids
					);
					// The Query
					$user_query = new WP_User_Query( $args );

					// User Loop
					if ( ! empty( $user_query->results ) ) {
						foreach ( $user_query->results as $user ):
							$theusers[] = array('ID'=>$user->ID,'first_name'=>$user->first_name,'last_name'=>$user->last_name,'email'=>$user->user_email,'status'=>$role);
						endforeach; //users
					 };
				endforeach;//roles ?>

			<?php
				function cmp($a, $b){
					if ($a["first_name"] == $b["first_name"]){
						return 0;
					}
						return ($a["first_name"] < $b["first_name"]) ? -1 : 1;
				}
				usort($theusers, "cmp");
				$member_count = count($theusers); ?>

 <span class="loading" ><i class="fa fa-spinner fa-spin fa-3x fa-fw margin-bottom"></i></span>

	<div id="stacked-tables" style="display:none;">
				<div class="text-center clearfix">
 	 				<ul class="filter ">
                        <li class="btn btn-info btn-sm" id="filter-none">Show all</li>
                        <li class="btn btn-info btn-sm" id="filter-member">Member</li>
                        <li class="btn btn-info btn-sm" id="filter-member-other">Member - Other</li>
                        <li class="btn btn-info btn-sm" id="filter-volunteer">Volunteer</li>
                    </ul>
		</div>
	  <input class="search list-search" placeholder="Search Members" />
	  <div class="pull-right member-count" style="font-weight: bold;padding: 10px 0px;"><span><?php echo $member_count; ?></span> Active Members</div>

	<table class="table">
		<thead> <tr> <th><a class="sort" data-sort="name">Maker</a></th> <th><a class="sort" data-sort="type">Type/Notes</a></th> <th><a class="sort" data-sort="dates">Dates</a></th><th>Billing</th> <th><a class="sort" data-sort="certs">Certs</a></th> <th><a class="sort" data-sort="sub_id">Sub ID</a></th> <th><a class="sort" data-sort="status">Status</a></th>  </tr> </thead>
		<tfoot> <tr> <th colspan="7" class="text-right member-count"> <span><?php echo $member_count; ?></span>  Active Members</th> </tr> </tfoot>
		<tbody  class="list">
				<?php foreach ( $theusers as $theuser ):
						$subscriber    = new EDD_Recurring_Subscriber( $theuser['ID'], true ); //

						if ( empty( $subscriber  ) )continue;
						//$has_access = $subscriber->has_active_subscription();
						$subscriptions = $subscriber->get_subscriptions( 0, array( 'active', 'expired', 'cancelled', 'failing' ) );
						//mapi_var_dump($subscriptions);
						$subscription  = $frequency  = $sort_date = $renewal_date = $sub_id = $status = $billing= $amount = $billed  = $initial   = $signup = $sub_name = $sub_link = '';
						if($subscriptions && $theuser['status']=='member'){
							//sort so oldest is last.
							usort(
						    $subscriptions,
						    function($a, $b) {
						        return strnatcmp($a->id, $b->id);
						    }
						);

							$subscription = end($subscriptions);
							//mapi_var_dump($subscription);

							//foreach ( $subscriptions as $subscription ) :



									$frequency    = EDD_Recurring()->get_pretty_subscription_frequency( $subscription->period );
									$amount   = edd_currency_filter( edd_format_amount( $subscription->recurring_amount ), edd_get_payment_currency_code( $subscription->parent_payment_id ) );
									$sort_date = strtotime( $subscription->expiration );
									$renew_date = ! empty( $subscription->expiration ) ? date_i18n( get_option( 'date_format' ), strtotime( $subscription->expiration ) ) : __( 'N/A', 'edd-recurring' );
									$renewal_date = '<br/><strong>Renewal:</strong> '.$renew_date;
									//$billing   = edd_currency_filter( edd_format_amount( $subscription->recurring_amount ), edd_get_payment_currency_code( $subscription->parent_payment_id ) ) . ' / ' . $frequency;
									// //printf( _x( '%s then %s', 'Inital subscription amount then billing cycle and amount', 'edd-recurring' ), $initial, $billing );
									$billed   = $subscription->get_total_payments() . ' / ' . ( ( $subscription->bill_times == 0 ) ? __( 'Until cancelled', 'edd-recurring' ) : $subscription->bill_times );
									$initial   = edd_currency_filter( edd_format_amount( $subscription->initial_amount ), edd_get_payment_currency_code( $subscription->parent_payment_id ) );
									$signup = '<strong>Joined:</strong> '.date_i18n( get_option( 'date_format' ), strtotime( $subscription->created, current_time( 'timestamp' ) ) );
									$sub_name =  get_the_title( $subscription->product_id );

									$sub_id = $subscription->id;

									if($subscription->status != 'active'){
										 $frequency = ucfirst($subscription->status);
										 $amount = $initial = $billed = '';
										 $renewal_date = '<br/><strong>Expires:</strong> '.$renew_date;

										 //Membership is expired AND end date is passed
										if(strtotime($renew_date) < strtotime('now')){
											//mapi_var_dump($subscription);
											//mapi_var_dump($theuser);
											wp_update_user(array('ID' => $theuser['ID'],'role' => 'subscriber'));
											continue;
										};

									};


							//endforeach;
						};
						//Use below if displaying past members.
						//if($theuser['status']=='subscriber' && empty($subscriptions) )continue;
						//Use/fix below to hide fieldsw in cancled member
						//if($subscriptions && $theuser['status'] == 'member' && $status !='active' ) $sub_name   =   'bob';


/*
	$subscriber = new EDD_Recurring_Subscriber( $object_id, true );
	$has_access = $subscriber->has_active_subscription();
	$this_user = get_user_by('id', $object_id);
	if($has_access){
			if(in_array("subscriber", $this_user->roles)){
				wp_update_user(array('ID' => $object_id,'role' => 'member'));
			};
			update_user_meta($object_id, 'active_member', 1);
			//update_field('field_57a294b20da0d', '1', $id);

		}else{
			if(in_array("member", $this_user->roles)){
				wp_update_user(array('ID' => $object_id,'role' => 'subscriber'));
			};
			update_user_meta($object_id, 'active_member', 0);
		}

    }
*/




						$customer = EDD()->customers->get_customer_by( 'user_id', $theuser['ID'] );
						if($customer){
							$member_link = esc_url( admin_url( 'edit.php?post_type=download&page=edd-customers&view=overview&id=' . $customer->id ) );
						}else{
							$member_link = esc_url( admin_url( 'user-edit.php?user_id=' . $theuser['ID'] ) );
						};

						if($sub_id && !get_field('member_other_type','user_'. $theuser['ID'] )){
							$current_status = 'Member';
							$sub_link = '<a href="' . add_query_arg( 'id', $sub_id, admin_url( 'edit.php?post_type=download&page=edd-subscriptions&id=' ) ) . '">' . $sub_id . '</a>';

						}else{
							$current_status =  $theuser['status'];
							$sort_date = 0;
							$renewal_date ='';
							$sub_name = get_field('member_other_type','user_'. $theuser['ID'] );
							if(get_field('member_till_date','user_'. $theuser['ID']))$signup = '<strong>Ends:</strong> '.get_field('member_till_date','user_'. $theuser['ID']);
							$frequency = get_field('membership_notes','user_'. $theuser['ID']);

						};




				?>



				<?php
					$certs = array();
					$certifications = get_field('certification_levels', 'user_'.$theuser['ID'] );
					if ( ! empty( $certifications ) ) :


					foreach ( $certifications as $certification ):

							$certs[] = get_field('abbreviation', $certification["certification"]);


						endforeach;
					 endif; ?>

					<tr>

						<td data-title="Maker"><a href="<?php echo $member_link; ?>" class="name" ><img src="<?php echo get_wp_user_avatar_src( $theuser['ID'], 'thumbnail' ); ?>" width="40" height="40" class="pull-left" style="margin-right:10px;"/><?php echo $theuser['first_name'].' '.$theuser['last_name']; ?></a><br/><a href="mailto:<?php echo $theuser['email']; ?>" class="email"><?php echo $theuser['email']; ?></a></td>

						<td data-title="Type"  class="type"><strong><?php echo $sub_name; ?></strong><br/><?php echo $frequency; ?> </td>
						<td data-title="Dates" class="dates"><span style="display:none"><?php echo $sort_date; ?></span><?php echo $signup; ?><?php echo $renewal_date; ?></td>
						<td data-title="Billing">
						<?php echo $amount; ?> <br/>

						<span class="edd_subscriptiontimes_billed"><?php echo $billed; ?></span>
						</td>
						<td data-title="Certs" class="certs"><?php echo implode(', ', $certs); ?></td>
						<td data-title="Sub ID" class="sub_id"><?php echo $sub_link; ?></td>
						<td data-title="Status" class="status"><?php echo ucfirst($current_status); ?></td>

					</tr>

				<?php endforeach; //users ?>
					</tbody>

	</table>


			</div><!-- .entry-content -->
		</article><!-- #post-## -->

<script>
	jQuery(function($) {

		jQuery('.loading').hide();
		jQuery('#stacked-tables').show();
		var options = {
		  valueNames: [ 'name', 'status', 'dates', 'type', 'email', 'sub_id' ]
		};

		var userList = new List('stacked-tables', options);

			userList.on("updated", function(){

			    jQuery('.member-count span').text(jQuery('.list tr').length );
			});

		$('#filter-member').click(function() {
			$('.filter li').removeClass('active');
			$(this).addClass('active');
		    userList.filter(function(item) {
		        if (item.values().status == "Member") {
		            return true;
		        } else {
		            return false;
		        }

		    });
		    jQuery('.member-count').html('<span>'+jQuery('.list tr').length+'</span> Paid Members');
		    return false;
		});

		$('#filter-member-other').click(function() {
			 $('.filter li').removeClass('active');
			 $(this).addClass('active');
		    userList.filter(function(item) {

		        if (item.values().status == "Member-other") {
		            return true;
		        } else {
		            return false;
		        }

		    });
		    jQuery('.member-count').html('<span>'+jQuery('.list tr').length+'</span> Other Members');
		    return false;
		});
		$('#filter-volunteer').click(function() {
			 $('.filter li').removeClass('active');
			 $(this).addClass('active');
		    userList.filter(function(item) {
		        if (item.values().status  == "Volunteer") {
		            return true;
		        } else {
		            return false;
		        }
		    });
		    jQuery('.member-count').html('<span>'+jQuery('.list tr').length+'</span> Volunteers');
		    return false;
		});
		$('#filter-none').click(function() {
		    $('.list-search').val('');
		    userList.search();
		    userList.filter();
		    $('.filter li').removeClass('active');

		    jQuery('.member-count').html('<span>'+jQuery('.list tr').length+'</span> Active Members');
		    return false;
		});

		if(window.location.hash) {
			  showsearch(/^#(.*)/.exec(window.location.hash)[1]);
			}

			function showsearch(hash) {
			  //search.value = hash;

			   userList.filter(function(item) {
			        if (item.values().status  == hash) {
			            return true;
			        } else {
			            return false;
			        }
			    });

			}

	});
	</script>

	<style>

		.list-search{
			border: solid 1px #ccc;
		    border-radius: 5px;
		    padding: 7px 14px;
		    margin-bottom: 10px;
		}
		.sort {
		  cursor: pointer;
		}
		.sort:hover {
		  text-decoration: none;
		}
		.sort:focus {
		  outline:none;
		}
		.sort:after {
		  display:inline-block;
		  width: 0;
		  height: 0;
		  border-left: 5px solid transparent;
		  border-right: 5px solid transparent;
		  border-bottom: 5px solid transparent;
		  content:"";
		  position: relative;
		  top:-10px;
		  right:-5px;
		}
		.sort.asc:after {
		  width: 0;
		  height: 0;
		  border-left: 5px solid transparent;
		  border-right: 5px solid transparent;
		  border-top: 5px solid #36383e;
		  content:"";
		  position: relative;
		  top:4px;
		  right:-5px;
		}
		.sort.desc:after {
		  width: 0;
		  height: 0;
		  border-left: 5px solid transparent;
		  border-right: 5px solid transparent;
		  border-bottom: 5px solid #36383e;
		  content:"";
		  position: relative;
		  top:-4px;
		  right:-5px;
		}
		</style>

		</div>
<?php get_footer(); ?>