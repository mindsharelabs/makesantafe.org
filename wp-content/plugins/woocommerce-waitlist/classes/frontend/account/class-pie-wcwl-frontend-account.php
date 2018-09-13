<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'Pie_WCWL_Frontend_Account' ) ) {
	/**
	 * Handles the user account for displaying their personal waitlist items
	 *
	 * @package  WooCommerce Waitlist
	 */
	class Pie_WCWL_Frontend_Account extends Pie_WCWL_Frontend_User_Waitlist {

		/**
		 * Pie_WCWL_Frontend_Account constructor.
		 */
		public function __construct() {
			parent::__construct();
			$this->endpoint = apply_filters( 'wcwl_waitlist_endpoint', 'woocommerce-waitlist' );
			$this->setup_account_tab();
		}

		/**
		 * Setup our custom waitlist account tab
		 */
		private function setup_account_tab() {
			add_filter( 'woocommerce_account_menu_items', array( $this, 'add_waitlist_menu_item' ) );
			add_action( "woocommerce_account_{$this->endpoint}_endpoint", array( $this, 'display_users_waitlists' ) );
		}

		/**
		 * Insert the new endpoint into the My Account menu.
		 *
		 * @param array $items
		 *
		 * @return array
		 */
		public function add_waitlist_menu_item( $items ) {
			$logout = $items['customer-logout'];
			unset( $items['customer-logout'] );
			$items[$this->endpoint] = $this->waitlist_tab_title;
			$items['customer-logout']      = $logout;

			return $items;
		}
	}
}