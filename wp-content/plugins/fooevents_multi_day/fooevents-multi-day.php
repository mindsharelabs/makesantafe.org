<?php
/**
 * Plugin Name: FooEvents Multi-Day
 * Description: Adds Multi-Day Event Functionality to FooEvents
 * Version: 1.1.15
 * Author: FooEvents
 * Plugin URI: https://www.fooevents.com/
 * Author URI: https://www.fooevents.com/
 * Developer: FooEvents
 * Developer URI: https://www.fooevents.com/
 * Text Domain: fooevents-multiday-events
 *
 * Copyright: © 2009-2017 FooEvents.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

require(WP_PLUGIN_DIR.'/fooevents_multi_day/config.php');

class Fooevents_Multiday_Events {
    
    private $Config;
    private $UpdateHelper;
    
    public function __construct() {

        $this->plugin_init();
        
        add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );
        add_action( 'admin_init', array( $this, 'register_scripts' ) );
        
    }
    
    /**
     * Initializes plugin
     * 
     */
    public function plugin_init() {
        
        //Main config
        $this->Config = new Fooevents_Multiday_Events_Config();
        
        //UpdateHelper
        require_once($this->Config->classPath.'updatehelper.php');
        $this->UpdateHelper = new Fooevents_Multiday_Events_Update_Helper($this->Config);
        
    }
    
    /**
     * Register plugin scripts.
     * 
     */
    public function register_scripts() {
        
        if((isset($_GET['action']) && $_GET['action'] == 'edit') || (isset($_GET['post_type']) && $_GET['post_type'] == 'product')) {
            
            global $wp_locale;

            wp_enqueue_script('jquery-ui-datepicker');
            wp_enqueue_script('wp-color-picker');
            wp_enqueue_script('events-multi-day-script', $this->Config->scriptsPath . 'events-multi-day-admin.js', array( 'jquery-ui-datepicker', 'wp-color-picker' ), '1.0.0', true );
            
            
            $dayTerm = '';
            if(!empty($_GET['post'])) {
                
                $dayTerm = get_post_meta($_GET['post'], 'WooCommerceEventsDayOverride', true);
                
            }
            
            if(empty($dayTerm)) {

                $dayTerm = get_option('WooCommerceEventsDayOverride', true);

            }

            if(empty($dayTerm) || $dayTerm == 1) {

                $dayTerm = __('Day', 'fooevents-multiday-events');

            }
            
            
            $localArgs = array(
                'closeText'         => __( 'Done', 'woocommerce-events' ),
                'currentText'       => __( 'Today', 'woocommerce-events' ),
                'monthNames'        => $this->_strip_array_indices( $wp_locale->month ),
                'monthNamesShort'   => $this->_strip_array_indices( $wp_locale->month_abbrev ),
                'monthStatus'       => __( 'Show a different month', 'woocommerce-events' ),
                'dayNames'          => $this->_strip_array_indices( $wp_locale->weekday ),
                'dayNamesShort'     => $this->_strip_array_indices( $wp_locale->weekday_abbrev ),
                'dayNamesMin'       => $this->_strip_array_indices( $wp_locale->weekday_initial ),
                // set the date format to match the WP general date settings
                'dateFormat'        => $this->_date_format_php_to_js( get_option( 'date_format' ) ),
                // get the start of week from WP general setting
                'firstDay'          => get_option( 'start_of_week' ),
                // is Right to left language? default is false
                'isRTL'             => $wp_locale->is_rtl(),
                'dayTerm'           => $dayTerm
            );
            
            wp_localize_script( 'events-multi-day-script', 'localObj', $localArgs );
            
        }
    }
    
    /**
     * Loads text-domain for localization
     * 
     */
    public function load_text_domain() {
        
        $path = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
        $loaded = load_plugin_textdomain( 'fooevents-multiday-events', false, $path);
        
        /*if ( ! $loaded )
        {
            print "File not found: $path"; 
            exit;
        }*/
        
    }
    
    /**
     * Displays event end date option
     * 
     * @param object $post
     * @return string
     */
    public function generate_end_date_option($post) {
        
        ob_start();
        
        $WooCommerceEventsEndDate = get_post_meta($post->ID, 'WooCommerceEventsEndDate', true);

        require($this->Config->templatePath.'end-date-option.php');

        $end_date_option = ob_get_clean();

        return $end_date_option;
        
    }
    
    /**
     * Displays event number of days option
     * 
     * @param object $post
     * @return string
     */
    public function generate_num_days_option($post) {
        
        ob_start();
        
        $WooCommerceEventsNumDays = get_post_meta($post->ID, 'WooCommerceEventsNumDays', true);
        

        require($this->Config->templatePath.'num-days-option.php');

        
        $num_days_option = ob_get_clean();

        return $num_days_option;
        
    }
    
    /**
     * Displays event multiday type option
     * 
     * @param object $post
     * @return string
     */
    public function generate_multiday_type_option($post) {
        
        ob_start();

        $WooCommerceEventsMultiDayType = get_post_meta($post->ID, 'WooCommerceEventsMultiDayType', true);
        $WooCommerceEventsSelectDate = get_post_meta($post->ID, 'WooCommerceEventsSelectDate', true);
        
        $dayTerm = get_post_meta($post->ID, 'WooCommerceEventsDayOverride', true);

        if(empty($dayTerm)) {

            $dayTerm = get_option('WooCommerceEventsDayOverride', true);

        }

        if(empty($dayTerm) || $dayTerm == 1) {

            $dayTerm = __('Day', 'fooevents-multiday-events');

        }
        
        require($this->Config->templatePath.'multiday-type-option.php');
        
        $multiday_type_option = ob_get_clean();
        
        return $multiday_type_option;
        
    }
    
    /**
     * Displays event multiday term options
     * 
     * @param object $post
     * @return string
     */
    public function generate_multiday_term_option($post) {
        
        ob_start();
        
        $WooCommerceEventsDayOverride = get_post_meta($post->ID, 'WooCommerceEventsDayOverride', true);
        
        require($this->Config->templatePath.'multiday-term-option.php');
        
        $multiday_term_option = ob_get_clean();
        
        return $multiday_term_option;
        
    }
    
    /**
     * Gets the multiday status for an event
     * 
     * @param int $ID
     * @return string
     */
    public function get_multiday_status($ID) {
        
        $WooCommerceEventsMultidayStatus = get_post_meta($ID, 'WooCommerceEventsMultidayStatus', true);
        
        /*echo $ID."<pre>";
            print_r($WooCommerceEventsMultidayStatus);
        echo "</pre>";*/
        
        if(!empty($WooCommerceEventsMultidayStatus) && !is_array($WooCommerceEventsMultidayStatus)) {

            $WooCommerceEventsMultidayStatus = json_decode($WooCommerceEventsMultidayStatus, true);
         
        } else {
            
            $WooCommerceEventsMultidayStatus = array();
            
        }       
        
        return $WooCommerceEventsMultidayStatus;
        
    }
    
    /**
     * Displays the multi day meta on the ticket detail screen
     * 
     * @param type $ID
     * @return string
     */
    public function display_multiday_status_ticket_meta_all($ID) {
        
        ob_start();
        
        $WooCommerceEventsMultidayStatus = $this->get_multiday_status($ID);
  
        $WooCommerceEventsProductID = get_post_meta($ID, 'WooCommerceEventsProductID', true);
        $WooCommerceEventsStatus = get_post_meta($ID, 'WooCommerceEventsStatus', true);
        $WooCommerceEventsNumDays = get_post_meta($WooCommerceEventsProductID, 'WooCommerceEventsNumDays', true);
        
        if (empty($WooCommerceEventsNumDays)) {
            
            $WooCommerceEventsNumDays = 1;
            
        }
        
        for($x = 1; $x <= $WooCommerceEventsNumDays; $x++) {
            
            if(empty($WooCommerceEventsMultidayStatus[$x])) {
                
                $WooCommerceEventsMultidayStatus[$x] = 'Not Checked In';
                
            }

        }

        ksort($WooCommerceEventsMultidayStatus);
        
        $dayTerm = get_post_meta($WooCommerceEventsProductID, 'WooCommerceEventsDayOverride', true);

        if(empty($dayTerm)) {

            $dayTerm = get_option('WooCommerceEventsDayOverride', true);

        }

        if(empty($dayTerm)) {

            $dayTerm = __('Day', 'fooevents-multiday-events');

        }
        
        if(!empty($WooCommerceEventsMultidayStatus) && $WooCommerceEventsStatus != 'Unpaid' && $WooCommerceEventsStatus != 'Canceled' && $WooCommerceEventsStatus != 'Cancelled') {
            
            require($this->Config->templatePath.'display-multiday-status-ticket-meta-all.php');
            
        }
        
        $multiday_status = ob_get_clean();

        return $multiday_status;
        
        
    }
    
    /**
     * Gets an array of check-ins, used in the CSV export
     * 
     * @param int $id
     */
    public function get_array_of_check_ins($ID, $WooCommerceEventsNumDays) {
        
        if(empty($WooCommerceEventsNumDays)) {
            
            $WooCommerceEventsNumDays = 1;
            
        }
        
        $WooCommerceEventsMultidayStatus = $this->get_multiday_status($ID);
        
        if(empty($WooCommerceEventsMultidayStatus)) {
            
            for($x = 1; $x <= $WooCommerceEventsNumDays; $x++) {
                
                $WooCommerceEventsMultidayStatus[$x] = 'Not Checked In';
                
            }
            
        }
        
        for($x = 1; $x <= $WooCommerceEventsNumDays; $x++) {
            
            if(empty($WooCommerceEventsMultidayStatus[$x])) {
                
                $WooCommerceEventsMultidayStatus[$x] = 'Not Checked In';
                
            }
            
        }
        
        $WooCommerceEventsMultidayStatusProcessed = array();
        
        foreach($WooCommerceEventsMultidayStatus as $day => $value) {
            
            if($day <= $WooCommerceEventsNumDays) {
                
                $WooCommerceEventsMultidayStatusProcessed[sprintf(__( 'Day %s', 'woocommerce-events' ), $day)] = $value;
                
            }

        }
        
        return $WooCommerceEventsMultidayStatusProcessed;
        
    }
    
    /**
     * Processes muli-day functionality with express check-ins
     * 
     * @param int $ID
     * @param string $multiday
     * @param string $day
     * @return string
     */
    public function display_multiday_status_ticket_meta($ID, $multiday, $day) {
        
        ob_start();
        
        $WooCommerceEventsMultidayStatus = $this->get_multiday_status($ID);
        
        $WooCommerceEventsProductID = get_post_meta($ID, 'WooCommerceEventsProductID', true);
        $WooCommerceEventsStatus = get_post_meta($ID, 'WooCommerceEventsStatus', true);
        $WooCommerceEventsNumDays = get_post_meta($WooCommerceEventsProductID, 'WooCommerceEventsNumDays', true);

        if (empty($WooCommerceEventsNumDays)) {
            
            $WooCommerceEventsNumDays = 1;
            
        }
        
        /*for($x = 1; $x <= $WooCommerceEventsNumDays; $x++) {
            
            if(empty($WooCommerceEventsMultidayStatus[$x])) {
                
                $WooCommerceEventsMultidayStatus[$x] = 'Not Checked In';
                
            }

        }*/
        
        if(empty($WooCommerceEventsMultidayStatus[$day])) {
            
            $WooCommerceEventsMultidayStatus[$day] = 'Not Checked In';
            
        }
        
        ksort($WooCommerceEventsMultidayStatus);
        
        if(!empty($WooCommerceEventsMultidayStatus) && $WooCommerceEventsStatus != 'Unpaid' && $WooCommerceEventsStatus != 'Canceled' && $WooCommerceEventsStatus != 'Cancelled') {
            
            $dayTerm = get_post_meta($WooCommerceEventsProductID, 'WooCommerceEventsDayOverride', true);
            
            if(empty($dayTerm)) {

                $dayTerm = get_option('WooCommerceEventsDayOverride', true);

            }

            if(empty($dayTerm) || $dayTerm == 1) {

                $dayTerm = __('Day', 'fooevents-multiday-events');

            }
            
            require($this->Config->templatePath.'display-multiday-status-ticket-meta.php');
            
        }
        
        $multiday_status = ob_get_clean();

        return $multiday_status;
        
    }
    
    /**
     * Processes muli-day functionality with express check-ins
     * 
     * @param int $ID
     * @param string $multiday
     * @param string $day
     * @return string
     */
    public function display_multiday_status_ticket_meta_day($ID, $multiday, $day) {
        
        $WooCommerceEventsMultidayStatus = $this->get_multiday_status($ID);
        $WooCommerceEventsProductID = get_post_meta($ID, 'WooCommerceEventsProductID', true);
        $WooCommerceEventsStatus = get_post_meta($ID, 'WooCommerceEventsStatus', true);
        $WooCommerceEventsNumDays = get_post_meta($WooCommerceEventsProductID, 'WooCommerceEventsNumDays', true);

        if (empty($WooCommerceEventsNumDays)) {
            
            $WooCommerceEventsNumDays = 1;
            
        }
        
        if(empty($WooCommerceEventsMultidayStatus[$day])) {
            
            $WooCommerceEventsMultidayStatus[$day] = 'Not Checked In';
            
        }
        
        return $WooCommerceEventsMultidayStatus[$day];
        
        
    }
    
    /**
     * Undoes autocompleted check-ins in the express check-in plugin
     * 
     * @param int $ID
     * @param string $multiday
     * @param string $day
     */
    public function undo_express_check_in_status_auto_complete($ID, $multiday, $day) {
        
        $WooCommerceEventsMultidayStatus = get_post_meta($ID, 'WooCommerceEventsMultidayStatus', true);
        $WooCommerceEventsMultidayStatus[$day] = 'Not Checked In';

        update_post_meta($ID, 'WooCommerceEventsMultidayStatus', $WooCommerceEventsMultidayStatus);
        
    }
    
    public function capture_multiday_status_ticket_meta($post_ID) {
        
        if (isset( $_POST ) && isset($_POST['ticket_status']) && $_POST['ticket_status'] == 'true' && isset($_POST['WooCommerceEventsStatusMultidayEvent']) ) {

            $WooCommerceEventsMultidayStatus= json_encode($_POST['WooCommerceEventsStatusMultidayEvent']);
            
            update_post_meta( $post_ID, 'WooCommerceEventsMultidayStatus', $WooCommerceEventsMultidayStatus); 

        }
        
        
    }
    
    /**
     * Displays multi-day settings in the express check-in plugin
     * 
     * @return string
     */
    public function display_multiday_express_check_in_options() {
        
        ob_start();
        
        require($this->Config->templatePath.'display-multiday-express-check-in-options.php');
        
        $multiday_options = ob_get_clean();

        return $multiday_options;
        
    }
    
    /**
     * Processes checkings the express check-in plugin
     * 
     * @param int $ID
     * @param string $update_value
     * @param string $multiday
     * @param string $day
     */
    public function update_express_check_in_status($ID, $update_value, $multiday, $day) {

        if($multiday) {
            
            $WooCommerceEventsMultidayStatus = get_post_meta($ID, "WooCommerceEventsMultidayStatus", true);
            $WooCommerceEventsMultidayStatus[$day] = $update_value;
            
            $WooCommerceEventsMultidayStatus = json_encode($WooCommerceEventsMultidayStatus);
            
            update_post_meta($ID, 'WooCommerceEventsMultidayStatus', $WooCommerceEventsMultidayStatus);
                    
        }        

    }
    
    /**
     * Processes auto check-ins in the express check-in plugin
     * 
     * @param int $ID
     * @param string $update_value
     * @param string $multiday
     * @param string $day
     * @return boolean
     */
    public function update_express_check_in_status_auto_complete($ID, $update_value, $multiday, $day) {
        
        if($multiday) {
            
            $WooCommerceEventsMultidayStatus = get_post_meta($ID, "WooCommerceEventsMultidayStatus", true);

            if(!empty($WooCommerceEventsMultidayStatus[$day])) {
                
                if($WooCommerceEventsMultidayStatus[$day] == 'Checked In') {
                    
                    return false;
                    
                }
                
            }
            
            $WooCommerceEventsMultidayStatus[$day] = $update_value;
            
            update_post_meta($ID, 'WooCommerceEventsMultidayStatus', $WooCommerceEventsMultidayStatus);
            
            return true;
            
        }
        
    }
    
    /**
     * Displays the multi-day form in the ticket status meta box
     * 
     * @param int $ID
     * @return string
     */
    public function display_multiday_status_ticket_form_meta($ID) {
        
        ob_start();

        $WooCommerceEventsMultidayStatus = $this->get_multiday_status($ID);
        
        $WooCommerceEventsProductID = get_post_meta($ID, 'WooCommerceEventsProductID', true);
        $WooCommerceEventsNumDays = get_post_meta($WooCommerceEventsProductID, 'WooCommerceEventsNumDays', true);
        $WooCommerceEventsStatus = '';
        
        if (empty($WooCommerceEventsNumDays)) {
            
            $WooCommerceEventsNumDays = 1;
            
        }
        
        for($x = 1; $x <= $WooCommerceEventsNumDays; $x++) {
            
            if(empty($WooCommerceEventsMultidayStatus[$x])) {
                
                $WooCommerceEventsMultidayStatus[$x] = 'Not Checked In';
                
            }
            
        }
        
        ksort($WooCommerceEventsMultidayStatus);
        
        require($this->Config->templatePath.'display-multiday-selection-form.php');
        
        $display_multiday_selection_form = ob_get_clean();
        
        return $display_multiday_selection_form;
        
    }
    
    /**
     * Returns the event end date
     * 
     * @param in $ID
     * @return string
     */
    public function get_end_date($ID) {
        
        return get_post_meta($ID, 'WooCommerceEventsEndDate', true);
        
    }
    
    
    /**
     * Returns the multi-day type
     * 
     * @param type $ID
     */
    public function get_multi_day_type($ID) {

        return get_post_meta($ID, 'WooCommerceEventsMultiDayType', true);
        
    }
    
    /**
     * Returns the multi-day status
     * 
     * @param type $ID
     * @return type
     */
    public function get_multi_day_selected_dates($ID) {

        return get_post_meta($ID, 'WooCommerceEventsSelectDate', true);

    }
    
    /**
     * Formats the end date for calendar display
     * 
     * @param int $ID
     * @return string
     */
    public function format_end_date($ID) {
        
        $event_end_date = get_post_meta($ID, 'WooCommerceEventsEndDate', true);
        $event_hour = get_post_meta($ID, 'WooCommerceEventsHourEnd', true);
        $event_minutes = get_post_meta($ID, 'WooCommerceEventsMinutesEnd', true);
        $event_end_date = $event_end_date.' '.'23'.':'.'00';

        $event_end_date = str_replace('/', '-', $event_end_date);
        $event_end_date = str_replace(',', '', $event_end_date);
        $event_end_date = date('Y-m-d H:i:s', strtotime($event_end_date));

        $globalFooEventsAllDayEvent = get_option( 'globalFooEventsAllDayEvent' );
        if($globalFooEventsAllDayEvent == 'yes') {

            $event_end_date = date('Y-m-d H:i:s', strtotime($event_end_date . ' +1 day'));

        }
        
        $event_end_date = str_replace(' ', 'T', $event_end_date);
        
        return $event_end_date;
        
    }
    
    /**
    * Format array for the datepicker
    *
    * WordPress stores the locale information in an array with a alphanumeric index, and
    * the datepicker wants a numerical index. This function replaces the index with a number
    */
    private function _strip_array_indices( $ArrayToStrip ) {
        
        foreach( $ArrayToStrip as $objArrayItem) {
            $NewArray[] =  $objArrayItem;
        }

        return( $NewArray );
        
    }
    
    /**
    * Convert the php date format string to a js date format
    */
    private function _date_format_php_to_js( $sFormat ) {
       
        switch( $sFormat ) {
            //Predefined WP date formats
            case 'jS F Y':
            return( 'd MM, yy' );
            break;
            case 'F j, Y':
            return( 'MM dd, yy' );
            break;
            case 'Y/m/d':
            return( 'yy/mm/dd' );
            break;
            case 'm/d/Y':
            return( 'mm/dd/yy' );
            break;
            case 'd/m/Y':
            return( 'dd/mm/yy' );
            break;
        
            case 'Y-m-d':
            return( 'yy-mm-dd' );
            break;
            case 'm-d-Y':
            return( 'mm-dd-yy' );
            break;
            case 'd-m-Y':
            return( 'dd-mm-yy' );
            break;
        
            default:
            return( 'yy-mm-dd' );
        }
        
    }
    
}

$Fooevents_Multiday_Events = new Fooevents_Multiday_Events();