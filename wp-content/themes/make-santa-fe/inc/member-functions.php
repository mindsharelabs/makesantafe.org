<?php

/**
 * Add certifications to the EDD Customer Interface
 * *
 * @since       3.2
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Add the certifications tab to the customer interface if the customer has certifications
 *
 * @since  3.2
 * @param  array $tabs The tabs currently added to the customer view
 * @return array       Updated tabs array
 */
function eddc_customer_tab( $tabs ) {

	$customer_id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : false;
	$customer    = new EDD_Customer( $customer_id );
	$downloads = edd_get_users_purchased_products( $customer->user_id );

	// Check for both certifications OR if they have downloads associated with them for certifications
	if ( $customer->user_id &&  ! empty( $downloads )  ) {

		// This makes it so former commission recievers get the tab and new commission users with no sales see it
		$tabs['certifications'] = array( 'dashicon' => 'dashicons-money', 'title' => __( 'Certifications', 'eddc' ) );

	}


	return $tabs;
}
add_filter( 'edd_customer_tabs', 'eddc_customer_tab', 10, 1 );

/**
 * Register the certifications view for the customer interface
 *
 * @since  3.2
 * @param  array $tabs The tabs currently added to the customer views
 * @return array       Updated tabs array
 */
function eddc_customer_view( $views ) {

	$customer_id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : false;
	$customer    = new EDD_Customer( $customer_id );

	//if ( $customer->user_id && eddc_user_has_certifications( $customer->user_id ) ) {

		$views['certifications'] = 'eddc_customer_certifications_view';

	//}

	return $views;
}
add_filter( 'edd_customer_views', 'eddc_customer_view', 10, 1 );

/**
 * Display the certifications area for the customer view
 *
 * @since  3.2
 * @param  object $customer The Customer being displayed
 * @return void
 */
function eddc_customer_certifications_view( $customer ) {

	?>
	<div class="edd-item-notes-header">
		<?php echo get_avatar( $customer->email, 30 ); ?> <span><?php echo $customer->name; ?></span>
	</div>

<!--
	<div id="edd-item-stats-wrapper" class="customer-section">
		<ul>
			<li>
				<span class="dashicons dashicons-chart-area"></span>
				<?php /*
echo edd_currency_filter( edd_format_amount( eddc_get_paid_totals( $customer->user_id ) ) ); ?> <?php _e( 'Paid certifications', 'eddc' ); ?>
				<?php $paid_sales = eddc_count_user_certifications( $customer->user_id, 'paid' ); ?>
				<?php if ( ! empty( $paid_sales ) ) : ?>
				<br />
				<a title="<?php _e( 'View All Paid certifications', 'edd' ); ?>" href="<?php echo admin_url( 'edit.php?post_type=download&page=edd-certifications&view=paid&user=' . $customer->user_id ); ?>">
					<?php printf( _n( 'via %d sale', 'via %d sales', $paid_sales, 'eddc' ), $paid_sales  ); ?>
				</a>
				<?php endif; ?>
			</li>
			<li>
				<span class="dashicons dashicons-chart-area"></span>
				<?php echo edd_currency_filter( edd_format_amount( eddc_get_unpaid_totals( $customer->user_id ) ) ); ?> <?php _e( 'Unpaid certifications', 'eddc' ); ?>
				<?php $unpaid_sales = eddc_count_user_certifications( $customer->user_id, 'unpaid' ); ?>
				<?php if ( ! empty( $unpaid_sales ) ) : ?>
				<br />
				<a title="<?php _e( 'View All Unpaid certifications', 'edd' ); ?>" href="<?php echo admin_url( 'edit.php?post_type=download&page=edd-certifications&view=unpaid&user=' . $customer->user_id ); ?>">
					<?php printf( _n( 'via %d sale', 'via %d sales', $unpaid_sales, 'eddc' ), $unpaid_sales  ); ?>
				</a>
				<?php endif;
*/ ?>
			</li>
		</ul>
	</div>
-->

	<?php 	$certifications = get_field('certification_levels', 'user_'.$customer->user_id );  ?>
	<?php if ( false !== $certifications ) : ?>
	<div id="edd-item-tables-wrapper" class="customer-section">
		<h3>Certifications</h3>

		<table class="wp-list-table widefat striped downloads">
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
	<?php endif; ?>


	<?php
}
