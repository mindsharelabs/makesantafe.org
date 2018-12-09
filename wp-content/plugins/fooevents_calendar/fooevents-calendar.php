<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Plugin Name: FooEvents Calendar
 * Description: Adds calendar view to FooEvents
 * Version: 1.3.14
 * Author: FooEvents
 * Plugin URI: https://www.fooevents.com/
 * Author URI: https://www.fooevents.com/
 * Developer: FooEvents
 * Developer URI: https://www.fooevents.com/
 * Text Domain: fooevents-calendar
 *
 * Copyright: © 2009-2017 FooEvents.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */


require(WP_PLUGIN_DIR.'/fooevents_calendar/config.php');

class FooEvents_Calendar{
    
    private $Config;
    private $UpdateHelper;
    
    public function __construct() {
        
        add_shortcode('fooevents_calendar', array( $this, 'display_calendar'));
        add_shortcode('fooevents_events_list', array( $this, 'events_list' ));
        add_shortcode('fooevents_event', array( $this, 'event'));
        add_action('widgets_init', array($this, 'include_widgets'));
        add_action('wp_enqueue_scripts', array($this, 'include_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'include_styles'));
        add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );
        
        add_action( 'woocommerce_settings_tabs_settings_woocommerce_events', array( $this, 'add_settings_tab_settings' ) );
        add_action( 'woocommerce_update_options_settings_woocommerce_events', array( $this, 'update_settings_tab_settings' ) );
        
        $this->plugin_init();
        
    }
    
    /**
     * Include front-end styles
     * 
     */
    public function include_styles() {
        wp_enqueue_style('fooevents-calendar-full-callendar-style', $this->Config->stylesPath.'fullcalendar.css', array(), '1.0.0');
        wp_enqueue_style('fooevents-calendar-full-callendar-print-style', $this->Config->stylesPath.'fullcalendar.print.css', array(), '1.0.0', 'print');
        wp_enqueue_style('fooevents-calendar-full-callendar-styles', $this->Config->stylesPath.'style.css', array(), '1.0.0');
        
    }
    
    /**
     * Include front-end scripts
     * 
     */
    public function include_scripts(){
        
        wp_enqueue_script('jquery');
        wp_enqueue_script('fooevents-calendar-moment',  $this->Config->scriptsPath . 'moment.min.js', array(), '1.0.0');
        wp_enqueue_script('fooevents-calendar-full-callendar',  $this->Config->scriptsPath . 'fullcalendar.min.js', array(), '1.0.0');
        wp_enqueue_script('fooevents-calendar-full-callendar-locale',  $this->Config->scriptsPath . 'locale-all.js', array(), '1.0.0');
        
    }
    
    /**
     * Initializes plugin
     * 
     */
    public function plugin_init() {
        
        //Main config
        $this->Config = new FooEvents_Calendar_Config();
        
        //UpdateHelper
        require_once($this->Config->classPath.'updatehelper.php');
        $this->UpdateHelper = new FooEvents_Calendar_Update_Helper($this->Config);
        
    }
    
    /**
     * Include widget class
     * 
     */
    public function include_widgets() {    
        
        require(WP_PLUGIN_DIR.'/fooevents_calendar/classes/calendarwidget.php');
        
    }  
    
    /**
     * Displays a shortcode event
     * 
     */
    public function event($attributes) {
        
        /*ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);*/
        
        $productID = '';

        if(!empty($attributes['product'])) {
        
            $productID = $attributes['product'];
            
        }
        
        ob_start();
        if(!empty($productID)) {
            
            $event = get_post($productID);

            if(!empty($event)) {

                $thumbnail = get_the_post_thumbnail_url($event->ID);

                //Check theme directory for template first
                if(file_exists($this->Config->templatePathTheme.'event.php') ) {

                     include($this->Config->templatePathTheme.'event.php');

                }else {

                    require($this->Config->templatePath.'event.php');

                }

            }
        
        }
        
        $event_output = ob_get_clean();

        return $event_output;
        
    }
    
    /**
     * Displays a shortcode list of events
     * 
     * @param array $attributes
     */
    public function events_list($attributes) {

        $num_events = '';
        $sort = '';
        $cat = '';
        $include_cats = array();

        if(!empty($attributes['num'])) {
            
            $num_events = $attributes['num'];
            
        } else {
            
            $num_events = 10;
            
        }
        
        if(!empty($attributes['sort'])) {
            
            $sort = strtoupper($attributes['sort']);
            
        } else {
            
            $sort = 'asc';
            
        }
        
        if(!empty($attributes['include_cat'])) {

            $include_cats = explode(',', $attributes['include_cat']);
            
        }
        
        if(!empty($attributes['cat'])) {
            
            $cat = $attributes['cat'];
            
        } else {
            
             $cat = '';
            
        }
        
        $events = $this->get_events($include_cats);
        
        $events = $this->fetch_events($events);
        $events = $this->sort_events_by_date($events, $sort);
        
        if ($sort == 'asc') {
            
            if(!empty($num_events) && is_numeric($num_events)) {

                $events = array_slice($events, -$num_events, $num_events, true);

            }
            
        } else {
            
            if(!empty($num_events) && is_numeric($num_events)) {

                $events = array_slice($events, 0, $num_events, true);

            }
            
        }

        if(empty($attributes['type'])) {
            
            ob_start();
            
        }
        
        if(!empty($events)) {
            
            foreach($events as $key => $event) {
                
                if(empty($event)) {
                    
                    unset($events[$key]);
                    
                }
                
                $ticketTerm = get_post_meta($event['post_id'], 'WooCommerceEventsTicketOverride', true);

                if(empty($ticketTerm)) {

                    $ticketTerm = get_option('globalWooCommerceEventsTicketOverride', true);

                }

                if(empty($ticketTerm) || $ticketTerm == 1) {

                    $ticketTerm = __( 'Book ticket', 'woocommerce-events' );

                }
                
                $events[$key]['ticketTerm'] = $ticketTerm;
                
            }

            //Check theme directory for template first
            if(file_exists($this->Config->templatePathTheme.'list_of_events.php') ) {

                 include($this->Config->templatePathTheme.'list_of_events.php');

            }else {

                require($this->Config->templatePath.'list_of_events.php');

            }
            
        }
        
        if(empty($attributes['type'])) {
            
            $event_list = ob_get_clean();

            return $event_list;
            
        }
        
    }

    /**
     * Outputs calendar to screen
     * 
     * @param array $attributes
     */
    public function display_calendar($attributes) {
        
        $include_cats = array();
        
        if(empty($attributes)) {
            
            $attributes = array();
            
        }

        $calendar_id = 'fooevents_calendar';
        
        if(!empty($attributes['id'])) {
            
            $calendar_id = $attributes['id'].'_fooevents_calendar';
            $attributes['id'] = $attributes['id'].'_fooevents_calendar';
            
            
        } else {
            
            $attributes['id'] = $calendar_id;
            
        }
        
        if(!empty($attributes['include_cat'])) {

            $include_cats = explode(',', $attributes['include_cat']);
            
        }
        
        if(!empty($attributes['cat'])) {
            
            $cat = $attributes['cat'];
            
        } else {
            
             $cat = '';
            
        }
        
        $attributes = $this->process_shortcodes($attributes);
        
        $globalFooEventsTwentyFourHour = get_option('globalFooEventsTwentyFourHour');
        
        if($globalFooEventsTwentyFourHour == 'yes') {
            
            $attributes['timeFormat'] = 'H:mm';
            
        }
        
        $events = $this->get_events($include_cats);
        $events = $this->fetch_events($events, false);
        
        $json_events = array_merge($attributes, $events);
        
        $json_events = addslashes(json_encode($json_events, JSON_HEX_QUOT | JSON_HEX_APOS));

        $localArgs = array("json_events" => $json_events);
        
        if(empty($attributes['type'])) {
            
            ob_start();
            
        }
        
        //Check theme directory for template first
        if(file_exists($this->Config->templatePathTheme.'calendar.php') ) {
            
            include($this->Config->templatePathTheme.'calendar.php');

        } else {

            include($this->Config->templatePath.'calendar.php');

        }

        if(empty($attributes['type'])) {
            
            $calendar = ob_get_clean();

            return $calendar;
            
        }
        
    }
    
    /**
     * Displays event background color event options
     * 
     * @param object $post
     * @return string
     */
    public function generate_event_background_color_option($post) {
        
        ob_start();
        
        $WooCommerceEventsBackgroundColor = get_post_meta($post->ID, 'WooCommerceEventsBackgroundColor', true);

        require($this->Config->templatePath.'background-color-option.php');

        $background_color_option = ob_get_clean();
        
        return $background_color_option;
        
    }
    
    /**
     * Displays event background text options
     * 
     * @param object $post
     * @return string
     */
    public function generate_event_background_text_option($post) {
        
        ob_start();
        
        $WooCommerceEventsTextColor = get_post_meta($post->ID, 'WooCommerceEventsTextColor', true);

        require($this->Config->templatePath.'text-color-option.php');

        $text_color_option = ob_get_clean();
        
        return $text_color_option;
        
    }
    
    
    /**
     * Sorts events either ascending or descending
     * 
     * @param array $events
     * @param string $sort
     * @return array
     */
    public function sort_events_by_date($events, $sort) {
        
        if(!empty($events)) {
            
            $events = $events['events'];

            if(strtolower($sort) == 'asc') {

                usort($events, array($this, 'event_date_compare_asc'));

            } else {

                usort($events, array($this, 'event_date_compare_desc'));

            }

            foreach($events as $key => $event) {

                if(empty($event['title'])) {

                    unset($events[$key]);

                }

            }
        
        }
        return $events;
        
    }
    
    /**
     * Compares two dates in ascending order
     * 
     * @param array $a
     * @param array $b
     * @return array
     */
    public function event_date_compare_asc($a, $b)
    {
        if(empty($a)) {
            
            
            $a = array('start' => '');
            
        }
        
        if(empty($a['start'])) {
            
            
            $a = array('start' => '');
            
        }
        
        if(empty($b)) {
            
           
            $b = array('start' => '');
            
        }
        
        if(empty($b['start'])) {
            
            
            $b = array('start' => '');
            
        }

        $t1 = strtotime($a['start']);
        $t2 = strtotime($b['start']);
        
        return $t1 - $t2;

    }   
    
    /**
     * Compares two dates in descending order
     * 
     * @param array $a
     * @param array $b
     * @return array
     */
    public function event_date_compare_desc($a, $b)
    {
        if(empty($a)) {
            
            
            $a = array('start' => '');
            
        }
        
        if(empty($a['start'])) {
            
            
            $a = array('start' => '');
            
        }
        
        if(empty($b)) {
            
           
            $b = array('start' => '');
            
        }
        
        if(empty($b['start'])) {
            
            
            $b = array('start' => '');
            
        }

        $t2 = strtotime($a['start']);
        $t1 = strtotime($b['start']);
        
        return $t1 - $t2;

    }
    
    /**
     * Get all events 
     *
     * @return array
     */
    public function get_events($include_cats = array()) {

        $args = array (
        'post_type' => 'product',
        'posts_per_page' => -1,
        'meta_query' => array (
            array (
                'key' => 'WooCommerceEventsEvent',
                'value' => 'Event',
                'compare' => '=',
                ),
            ),
        ) ;
        
        if(!empty($include_cats)) {

            $args['tax_query'] = array('relation' => 'OR');
            
            foreach($include_cats as $include_cat) {
                
                $args['tax_query'][] = array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $include_cat
                );
                
            }
            
        }

        $events = new WP_Query ($args) ;
        
        return $events->get_posts();
        
    }
    
    /**
     * Process fetched events
     * 
     * @param array $events
     * @return array
     */
    public function fetch_events($events, $include_desc = true) {

        $json_events = array();

        $x = 0;
        foreach($events as $event) {
            
            $Fooevents_Multiday_Events = '';
            $multi_day_type = '';
            
            if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
                require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
            }
            
            if ($this->is_plugin_active('fooevents_multi_day/fooevents-multi-day.php') || is_plugin_active_for_network('fooevents_multi_day/fooevents-multi-day.php')) {
                
                $Fooevents_Multiday_Events = new Fooevents_Multiday_Events();
                $multi_day_type = $Fooevents_Multiday_Events->get_multi_day_type($event->ID);
            }
            
            $event_date_unformated = get_post_meta($event->ID, 'WooCommerceEventsDate', true);
            $event_hour = get_post_meta($event->ID, 'WooCommerceEventsHour', true);
            $event_minutes = get_post_meta($event->ID, 'WooCommerceEventsMinutes', true);
            $event_period = get_post_meta($event->ID, 'WooCommerceEventsPeriod', true);
            $event_background_color = get_post_meta($event->ID, 'WooCommerceEventsBackgroundColor', true);
            $event_text_color = get_post_meta($event->ID, 'WooCommerceEventsTextColor', true);
            
            if(empty($event_date_unformated)) {
                
                if($multi_day_type != 'select') {
                 
                    continue;
                
                }
                
            }
            
            $event_date = $event_date_unformated.' '.$event_hour.':'.$event_minutes.$event_period;
     
            $event_date = str_replace('/', '-', $event_date);
            $event_date = str_replace(',', '', $event_date);
            $event_date = date('Y-m-d H:i:s', strtotime($event_date));
            $event_date = str_replace(' ', 'T', $event_date);

            $all_day_event = false;
            $globalFooEventsAllDayEvent = get_option( 'globalFooEventsAllDayEvent' );
            
            if($globalFooEventsAllDayEvent == 'yes') {
                
                $all_day_event = true;
                
            }

            $json_events['events'][$x]= array(
                'title' => $event->post_title,
                'allDay' => $all_day_event,
                'start' => $event_date,
                'unformated_date' => $event_date_unformated,
                'url' => get_permalink($event->ID),
                'post_id' => $event->ID
            );
            
            if(!empty($event_background_color)) {
                
                $json_events['events'][$x]['color'] = $event_background_color;
                
            }
            
            if(!empty($event_text_color)) {
                
                $json_events['events'][$x]['textColor'] = $event_text_color;
                
            }
            
            if($include_desc) {
                
                $json_events['events'][$x]['desc'] = $event->post_excerpt;
                
            }
            
            if($multi_day_type == 'select') {
                
                unset($json_events['events'][$x]);
                $x--;
                
            }
            
            if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
                require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
            }
            
            if ($this->is_plugin_active('fooevents_multi_day/fooevents-multi-day.php') || is_plugin_active_for_network('fooevents_multi_day/fooevents-multi-day.php')) {
      
                $event_end_date = $Fooevents_Multiday_Events->get_end_date($event->ID);
                $globalFooEventsStartDay = get_option('globalFooEventsStartDay');
                
                if($multi_day_type == 'select') {

                    $multi_day_dates= $Fooevents_Multiday_Events->get_multi_day_selected_dates($event->ID);

                    $y = 0;
                    foreach($multi_day_dates as $date) {
                        
                        if($y > 0 && $globalFooEventsStartDay == 'yes') {
                            
                            continue;
                            
                        }
                        
                        $x++;

                        $event_date = $date.' '.$event_hour.':'.$event_minutes;
                        $event_date = str_replace('/', '-', $event_date);
                        $event_date = str_replace(',', '', $event_date);
                        $event_date = date('Y-m-d H:i:s', strtotime($event_date));
                        $event_date = str_replace(' ', 'T', $event_date);
                        
                        $json_events['events'][$x]= array(
                            'title' => $event->post_title,
                            'allDay' => $all_day_event,
                            'start' => $event_date,
                            'unformated_date' => $date,
                            'url' => get_permalink($event->ID),
                            'post_id' => $event->ID
                        );
                        
                        if(!empty($event_background_color)) {

                            $json_events['events'][$x]['color'] = $event_background_color;

                        }

                        if(!empty($event_text_color)) {

                            $json_events['events'][$x]['textColor'] = $event_text_color;

                        }
                        
                        $y++;
                        
                    }
                
                } else {
                    
                    if(!empty($event_end_date)) {

                        $event_end_date = $Fooevents_Multiday_Events->format_end_date($event->ID);
                        
                        if($globalFooEventsStartDay != 'yes') {
                        
                            $json_events['events'][$x]['end'] = $event_end_date;
                        
                        }

                    }
                    
                }
                
            }
            $x++;
        }
    
        return $json_events;
        
    }
    
    /**
     * Process shortcodes
     * 
     * @param array $attributes
     * @return array
     * 
     */
    public function process_shortcodes($attributes) {
        
        $processed_attributes = array();

        if(empty($attributes['locale'])) {
            
            $attributes['locale'] = get_locale();
            
        } 
        
        foreach($attributes as $key => $attribute) {
            
            if (strpos($attribute, ':') !== false) {
                
                $att_ret = array();
                $parts = explode(';', $attribute);
                
                foreach($parts as $part) {
                    
                    if (strpos($part, '{') !== false) {
                        
                        $att_ret_sub = array();
                        
                        $start  = strpos($part, '{');
                        $end    = strpos($part, '}', $start + 1);
                        $length = $end - $start;
                        $att_sub = substr($part, $start + 1, $length - 1);
                        
                        $atts = explode(':', $part);
                        $att_key = trim($atts[0]);
                        
                        $atts = explode(':', $att_sub);
                        
                        $att_sub_key = trim($atts[0]);
                        $atts[1] = str_replace("'", "", $atts[1]);
                        $att_att = trim($atts[1]);
                        
                        $att_ret_sub[$this->process_key($att_sub_key)] = $att_att;
                        
                        $att_ret[$this->process_key($att_key)] = $att_ret_sub;
                        
                    } else {
                    
                        $atts = explode(':', $part);

                        $att_key = trim($atts[0]);
                        $atts[1] = str_replace("'", "", $atts[1]);
                        $att_att = trim($atts[1]);

                        $att_ret[$this->process_key($att_key)] = $att_att;

                    }

                }
                
                $processed_attributes[$this->process_key($key)] = $att_ret;
                
            } else {
            
                $processed_attributes[$this->process_key($key)] = $attribute;
            
            }
            
        }

        return $processed_attributes;
        
    }
    
    /**
     * Adds the WooCommerce tab settings
     * 
     */
    public function add_settings_tab_settings() {
        
        woocommerce_admin_fields( $this->get_tab_settings() );
        
    }
    
    /**
     * Saves the WooCommerce tab settings
     * 
     */
    public function update_settings_tab_settings() {

        woocommerce_update_options( $this->get_tab_settings() );

    }
    
    /**
     * Adds global calendar options to the WooCommerce Event settings panel 
     * 
     * @return array
     */
    public function get_tab_settings() {
        
        $settings = array('section_title' => array(
                'name'      => __( 'Calendar Settings', 'fooevents-calendar' ),
                'type'      => 'title',
                'desc'      => '',
                'id'        => 'wc_settings_fooevents_pdf_tickets_settings_title'
            ),
            'globalFooEventsTwentyFourHour' => array(
                'name'  => __( 'Enable 24 hour time format', 'fooevents-calendar' ),
                'type'  => 'checkbox',
                'id'    => 'globalFooEventsTwentyFourHour',
                'value' => 'yes',
                'desc'  => __( 'Uses 24 hour time format on the calendar.', 'fooevents-calendar' ),
                'class' => 'text uploadfield'
            )
            ,
            'globalFooEventsStartDay' => array(
                'name'  => __( 'Only display start day', 'fooevents-calendar' ),
                'type'  => 'checkbox',
                'id'    => 'globalFooEventsStartDay',
                'value' => 'yes',
                'desc'  => __( 'When multi-day plugin is active only display the event start day', 'fooevents-calendar' ),
                'class' => 'text uploadfield'
            ),
            'globalFooEventsAllDayEvent' => array(
                'name'  => __( 'Enable full day events', 'fooevents-calendar' ),
                'type'  => 'checkbox',
                'id'    => 'globalFooEventsAllDayEvent',
                'value' => 'yes',
                'desc'  => __( 'Removes event time from calendar entry titles.', 'fooevents-calendar' ),
                'class' => 'text uploadfield'
            ));
        
        $settings['section_end'] = array(
            'type' => 'sectionend',
            'id' => 'wc_settings_fooevents_pdf_tickets_settings_end'
        );
        
        return $settings;
        
    }
    
    /**
     * Process keys and bride FullCalendar js
     * 
     * @param array $key
     * @return array
     */
    public function process_key($key) {

        $check_key = $this->check_general($key);
        if($check_key !== $key) {

            return $check_key;
            
        }
        
        $check_key = $this->check_views($key);
        if($check_key !== $key) {

            return $check_key;
            
        }
        
        $check_key = $this->check_agenda($key);
        if($check_key !== $key) {

            return $check_key;
            
        }
        
        $check_key = $this->check_listview($key);
        if($check_key !== $key) {

            return $check_key;
            
        }
        
        $check_key = $this->check_currentdate($key);
        if($check_key !== $key) {

            return $check_key;
            
        }
        
        $check_key = $this->check_texttimecust($key);
        if($check_key !== $key) {

            return $check_key;
            
        }
        
        $check_key = $this->check_clickinghovering($key);
        if($check_key !== $key) {

            return $check_key;
            
        }
        
        $check_key = $this->check_selection($key);
        if($check_key !== $key) {

            return $check_key;
            
        }
        
        $check_key = $this->check_eventdata($key);
        if($check_key !== $key) {

            return $check_key;
            
        }
        
        $check_key = $this->check_eventrendering($key);
        if($check_key !== $key) {

            return $check_key;
            
        }
        
        $check_key = $this->check_timelineview($key);
        if($check_key !== $key) {

            return $check_key;
            
        }
        
        return $key;
        
    }
    
    /**
     * Check generals options
     * 
     * @param string $key
     * @return string
     */
    public function check_general($key) {
        
        switch ($key) {
            case "defaultview":
                return "defaultView";
                break;
            case "defaultdate":
                return "defaultDate";
                break;
            case "custombuttons":
                return "customButtons";
                break;
            case "buttonicons":
                return "buttonIcons";
                break;
            case "themebuttonicons":
                return "themeButtonIcons";
                break;
            case "firstday":
                return "firstDay";
                break;
            case "isrtl":
                return "isRTL";
                break;
            case "hiddendays":
                return "hiddenDays";
                break;
            case "fixedweekcount":
                return "fixedWeekCount";
                break;
            case "weeknumbers":
                return "weekNumbers";
                break;
            case "weeknumberswithindays":
                return "weekNumbersWithinDays";
                break;
            case "weeknumbercalculation":
                return "weekNumberCalculation";
                break;
            case "businesshours":
                return "businessHours";
                break;
            case "contentheight":
                return "contentHeight";
                break;
            case "aspectratio":
                return "aspectRatio";
                break;
            case "handlewindowresize":
                return "handleWindowResize";
                break;
            case "windowresizedelay":
                return "windowResizeDelay";
                break;
            case "eventlimit":
                return "eventLimit";
                break;
            case "eventlimitclick":
                return "eventLimitClick";
                break;
            case "viewrender":
                return "viewRender";
                break;
            case "viewdestroy":
                return "viewDestroy";
                break;
            case "dayrender":
                return "dayRender";
                break;
            case "windowresize":
                return "windowResize";
                break;
        }
        
        return $key;
        
    }
    
    /**
     * Check view options
     * 
     * @param string $key
     * @return string
     */
    public function check_views($key) {
        
        switch ($key) {
            case "defaultview":
                return "defaultView";
                break;
            case "getview":
                return "getView";
                break;
            case "changeview":
                return "changeView";
                break;
        }   
        
        return $key;
        
    }
    
    /**
     * Check agenda options
     * 
     * @param string $key
     * @return string
     */
    public function check_agenda($key) {
        
        switch ($key) {
            case "alldayslot":
                return "allDaySlot";
                break;
            case "alldaytext":
                return "allDayText";
                break;
            case "slotduration":
                return "slotDuration";
                break;
            case "slotlabelformat":
                return "slotLabelFormat";
                break;
            case "slotlabelinterval":
                return "slotLabelInterval";
                break;
            case "snapduration":
                return "snapDuration";
                break;
            case "scrolltime":
                return "scrollTime";
                break;
            case "mintime":
                return "minTime";
                break;
            case "maxtime":
                return "maxTime";
                break;
            case "sloteventoverlap":
                return "slotEventOverlap";
                break;
        }   
        
        return $key;
        
    }
    
    /**
     * Check listview options
     * 
     * @param string $key
     * @return string
     */
    public function check_listview($key) {
        
        switch ($key) {
            case "listdayformat":
                return "listDayFormat";
                break;
            case "listdayaltformat":
                return "listDayAltFormat";
                break;
            case "noeventsmessage":
                return "noEventsMessage";
                break;
        }
        
        return $key;
        
    }
    
    /**
     * Check currentdate options
     * 
     * @param string $key
     * @return string
     */
    public function check_currentdate($key) {
        
        switch ($key) {
            case "defaultdate":
                return "defaultDate";
                break;
            case "nowindicator":
                return "nowIndicator";
                break;
        }
        
        return $key;
        
    }
    
    /**
     * Check text time custom options
     * 
     * @param string $key
     * @return string
     */
    public function check_texttimecust($key) {
        
        switch ($key) {
            case "timeformat":
                return "timeFormat";
                break;
            case "columnformat":
                return "columnFormat";
                break;
            case "titleformat":
                return "titleFormat";
                break;
            case "columnformat":
                return "columnFormat";
                break;
            case "titleformat":
                return "titleFormat";
                break;
            case "buttontext":
                return "buttonText";
                break;
            case "monthnames":
                return "monthNames";
                break;
            case "monthnamesshort":
                return "monthNamesShort";
                break;
            case "daynames":
                return "dayNames";
                break;
            case "daynamesshort":
                return "dayNamesShort";
                break;
            case "weeknumbertitle":
                return "weekNumberTitle";
                break;
            case "displayeventtime":
                return "displayEventTime";
                break;
            case "displayeventend":
                return "displayEventEnd";
                break;
            case "eventlimittext":
                return "eventLimitText";
                break;
            case "daypopoverformat":
                return "dayPopoverFormat";
                break;
        }
        
        return $key;
        
    }
    
    /**
     * Check clicking hovering options
     * 
     * @param string $key
     * @return string
     */
    public function check_clickinghovering($key) {
        
        switch ($key) {
            case "navlinks":
                return "navLinks";
                break;
        }
        
        return $key;
        
    }
    
    /**
     * Check selection options
     * 
     * @param string $key
     * @return string
     */
    public function check_selection($key) {
        
        switch ($key) {
            case "selecthelper":
                return "selectHelper";
                break;
            case "unselectauto":
                return "unselectAuto";
                break;
            case "unselectcancel":
                return "unselectCancel";
                break;
            case "selectoverlap":
                return "selectOverlap";
                break;
            case "selectconstraint":
                return "selectConstraint";
                break;
            case "selectallow":
                return "selectAllow";
                break;
        }
        
        return $key;
        
    }
    
    /**
     * Check event data options
     * 
     * @param string $key
     * @return string
     */
    public function check_eventdata($key) {
        
        switch ($key) {
            case "eventsources":
                return "eventSources";
                break;
            case "alldaydefault":
                return "allDayDefault";
                break;
            case "unselectcancel":
                return "unselectCancel";
                break;
            case "startparam":
                return "startParam";
                break;
            case "endparam":
                return "endParam";
                break;
            case "timezoneparam":
                return "timezoneParam";
                break;
            case "lazyfetching":
                return "lazyFetching";
                break;
            case "defaulttimedeventduration":
                return "defaultTimedEventDuration";
                break;
            case "defaultalldayeventduration":
                return "defaultAllDayEventDuration";
                break;
            case "forceeventduration":
                return "forceEventDuration";
                break;
        }
        
        return $key;
        
    }
    
    /**
     * Check event rendering options
     * 
     * @param string $key
     * @return string
     */
    public function check_eventrendering($key) {
        
        switch ($key) {
            case "eventcolor":
                return "eventColor";
                break;
            case "eventbackgroundcolor":
                return "eventBackgroundColor";
                break;
            case "eventbordercolor":
                return "eventBorderColor";
                break;
            case "eventtextcolor":
                return "eventTextColor";
                break;
            case "nextdaythreshold":
                return "nextDayThreshold";
                break;
            case "eventorder":
                return "eventOrder";
                break;
        }
        
        return $key;
        
    }
    
    /**
     * Check timeline view options
     * 
     * @param string $key
     * @return string
     */
    public function check_timelineview($key) {
        
        switch ($key) {
            case "resourceareawidth":
                return "resourceAreaWidth";
                break;
            case "resourcelabeltext":
                return "resourceLabelText";
                break;
            case "resourcecolumns":
                return "resourceColumns";
                break;
            case "slotwidth":
                return "slotWidth";
                break;
            case "slotduration":
                return "slotDuration";
                break;
            case "slotlabelformat":
                return "slotLabelFormat";
                break;
            case "slotlabelinterval":
                return "slotLabelInterval";
                break;
            case "slotlabelinterval":
                return "slotLabelInterval";
                break;
            case "snapduration":
                return "snapDuration";
                break;
            case "snapduration":
                return "snapDuration";
                break;
            case "scrolltime":
                return "scrollTime";
                break;
        }
        
        return $key;
        
    }
    
    /**
     * Loads text-domain for localization
     * 
     */
    public function load_text_domain() {

        $path = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
        $loaded = load_plugin_textdomain( 'fooevents-calendar', false, $path);
        
        /*if ( ! $loaded )
        {
            print "File not found: $path"; 
            exit;
        }*/
        
    }

    /**
    * Checks if a plugin is active.
    * 
    * @param string $plugin
    * @return boolean
    */
    private function is_plugin_active( $plugin ) {

        return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );

    }
    
}

$FooEvents_Calendar = new FooEvents_Calendar();

function uninstallFooEventsCalendar() {
    
    delete_option('globalFooEventsAllDayEvent');
    delete_option('globalFooEventsTwentyFourHour');
    
}

register_uninstall_hook(__FILE__, 'uninstallFooEventsCalendar');