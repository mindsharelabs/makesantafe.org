<?php

// Define the version so we can easily replace it throughout the theme
define( 'anagram_version', 1.0 );

add_action( 'wp_login', 'my_function', 99 );
function my_function( $login ) {

  $user = get_user_by('login',$login);
  $user_ID = $user->ID;
  return $user_ID;
}

if ( ! function_exists( 'anagram_setup' ) ) :
/**
 * Set up theme defaults and register support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function anagram_setup() {
    global $cap, $content_width;


		if ( ! isset( $content_width ) ) {
			$content_width = 906;
		}


	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );


       add_editor_style('/css/editor-styles.css');

    if ( function_exists( 'add_theme_support' ) ) {

		/**
		 * Add default posts and comments RSS feed links to head
		*/
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for Post Thumbnails on posts and pages
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		*/
		add_theme_support( 'post-thumbnails' );

			//set_post_thumbnail_size( 250, 160, true );
			//add_image_size( 'tiny', 75, '', false );
			//add_image_size( 'block-image', 300, 170, true );

		add_filter( 'image_size_names_choose', 'anagram_custom_sizes' );

			function anagram_custom_sizes( $sizes ) {
			    return array_merge( $sizes, array(
			        'post-thumbnail' => __('Post Thumbnail'),
			    ) );
			}

		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
    }


	/**
	 * This theme uses wp_nav_menu() in one location.
	*/
    register_nav_menus( array(
        'header'  => __( 'Header Menu', 'anagram' ),
        'primary'  => __( 'Main Menu', 'anagram' ),
        'footer'  => __( 'Footer Menu', 'anagram' ),
    ) );

}
endif; // anagram_setup
add_action( 'after_setup_theme', 'anagram_setup' );


/*Custom Tiny MCS buttons*/
add_filter( 'mce_buttons', 'anagram_mce_buttons' );
function anagram_mce_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
function anagram_tinymce_buttons($buttons)
 {
	//Remove the format dropdown select and text color selector
	$remove = array('formatselect');

	return array_diff($buttons,$remove);
 }
add_filter('mce_buttons_2','anagram_tinymce_buttons');

add_filter( 'tiny_mce_before_init', 'anagram_mce_before_init' );
function anagram_mce_before_init( $settings ) {
	//$settings['theme_advanced_blockformats'] = 'p,a,div,span,h1,h2,h3,h4,h5,h6,tr,';
	$settings['theme_advanced_disable'] = 'formatselect';

    $style_formats = array(
    	array(
    		'title' => 'Button',
    		'selector' => 'a',
    		'classes' => 'btn btn-default'
    	),
    	array(
    		'title' => 'Main Header',
    		'block' => 'h2'
    	),
    	array(
    		'title' => 'Sub Header',
    		'block' => 'h3'
    	),
    	array(
    		'title' => 'Small Header',
    		'block' => 'h4'
    	),
    	array(
    		'title' => 'Block Color',
    		'block' => 'div',
    		'classes' => 'bg-color'
    	)/*,
        array(
        	'title' => 'Bold Red Text',
        	'inline' => 'span',
        	'styles' => array(
        		'color' => '#f00',
        		'fontWeight' => 'bold'
        	)
        )*/
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}






/**
 * Register widgetized area and update sidebar with default widgets
 */
function anagram_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'anagram' ),
		'id'            => 'sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="widget-header"><h3 class="widget-title">',
		'after_title'   => '</h3>'.anagramLoadFile(get_template_directory_uri()."/img/title-side-bg.svg").'</div>',
	) );
}
add_action( 'widgets_init', 'anagram_widgets_init' );

/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/

function anagram_scripts()  {

	// load bootstrap
	//wp_enqueue_style( 'anagram-bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css' );

	// get the theme directory style.css and link to it in the header
	wp_enqueue_style( 'anagram-style', get_stylesheet_directory_uri().'/style.css', array(), filemtime( get_stylesheet_directory().'/style.css') );

	//Load google fonts
	$anagram_google_fonts = array(
	    'family' => 'Open+Sans:400,300,300italic,400italic,600,600italic,700italic,700|Ubuntu:300,300italic,700,700italic'
	);
    wp_enqueue_style('anagram-google-fonts', add_query_arg( $anagram_google_fonts, "https://fonts.googleapis.com/css" ), array(), null );

	// load awesome font
	wp_enqueue_style( 'anagram-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css' );

  wp_enqueue_script('anagram-modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', array('jquery') );

	wp_register_script('anagram-moment', (get_template_directory_uri()."/js/moment.min.js"),'jquery',filemtime( get_stylesheet_directory().'/js/moment.min.js'),true);

	wp_register_script('anagram-clndr', (get_template_directory_uri()."/js/clndr.js"),'jquery',filemtime( get_stylesheet_directory().'/js/clndr.js'),true);

		wp_register_script('anagram-event-code', (get_template_directory_uri()."/js/event-code.js"),array('jquery'),filemtime( get_stylesheet_directory().'/js/event-code.js'),true);



	if( is_page( array('learn'))   ) {


				wp_enqueue_script('underscore');
				wp_enqueue_script('anagram-moment');

				wp_enqueue_script('anagram-clndr');
				wp_enqueue_script('anagram-event-code');


	}


	if( is_page( array('checkout')) && edd_get_cart_total()   ) {
			//wp_enqueue_script('anagram_googlemaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyASc64VwvKRrj2QRV91pD6I1no2Rg9YGPI&libraries=places',false);
		//wp_enqueue_script('anagram-edd-address', (get_template_directory_uri()."/js/address-edd.js"),'jquery',filemtime( get_stylesheet_directory().'/js/address-edd.js'),true);

		wp_enqueue_script('anagram_cardjs', (get_template_directory_uri()."/js/card.js"),'jquery',filemtime( get_stylesheet_directory().'/js/card.js'),true);

		wp_enqueue_script('anagram-edd-card', (get_template_directory_uri()."/js/card-edd.js"),'jquery',filemtime( get_stylesheet_directory().'/js/card-edd.js'),true);

		}

    // load bootstrap js
    wp_enqueue_script('anagram-bootstrapjs', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array('jquery') );

			wp_register_script( 'anagram-masonry', get_stylesheet_directory_uri() . '/js/masonry.pkgd.min.js',  array('jquery'), '', false );

			wp_register_script( 'anagram-imagesloaded', get_stylesheet_directory_uri() . '/js/imagesloaded.pkgd.min.js', array('jquery'), '', false );

			wp_enqueue_script( 'anagram-masonry' );
			wp_enqueue_script( 'anagram-imagesloaded' );

	// load plugins
	wp_enqueue_script('anagram-plugins', (get_template_directory_uri()."/js/theme-plugins.js"),array('jquery'),filemtime( get_stylesheet_directory().'/js/theme-plugins.js'),true);

	// add theme scripts
	wp_enqueue_script('anagram-scripts', (get_template_directory_uri()."/js/theme-scripts.js"),array('jquery'),filemtime( get_stylesheet_directory().'/js/theme-scripts.js'),true);


		// load plugins
	wp_enqueue_script('anagram-svg', (get_template_directory_uri()."/js/svg.js"),array('jquery'),filemtime( get_stylesheet_directory().'/js/svg.js'),true);

	// add theme scripts
	if( is_front_page()  ) {
		wp_enqueue_script('anagram-svg-intro', (get_template_directory_uri()."/js/svg-intro.js"),array('jquery'),filemtime( get_stylesheet_directory().'/js/svg-intro.js'),true);
		}


	if( is_page( array(2,106,118,512))   ) {
		wp_enqueue_script('anagram-svg-intro', (get_template_directory_uri()."/js/svg-pages.js"),array('jquery'),filemtime( get_stylesheet_directory().'/js/svg-pages.js'),true);
	}
	if( is_page( array(2539))   ) {
		wp_enqueue_script('anagram-list', (get_template_directory_uri()."/js/list.js"),array('jquery'),filemtime( get_stylesheet_directory().'/js/list.js'),true);
	}

}
add_action( 'wp_enqueue_scripts', 'anagram_scripts' ); // Register this fxn and allow Wordpress to call it automatcally in the header





/**
 * Custom Theme functions
 */

	include_once('inc/anagram-customs.php');

/**
 * Load custom WordPress nav walker.
 */

include_once('inc/bootstrap-wp-navwalker.php');


include_once('gravityview/anagram-voting.php');


/**
 * Load custom Gallery
 */
include_once('inc/edd-custom.php');
/**
 * Load custom Gallery
 */
include_once('inc/member-functions.php');

/**
 * Load custom Gallery
 */
include_once('inc/anagram-gallery.php');

include_once('inc/php_gravity_forms_bootstrap.php');


/*Load default settings on theme activation*/
add_action('after_switch_theme', 'anagram_defaults_settings');

function anagram_defaults_settings() {
    global $wpdb, $wp_rewrite, $table_prefix;

    /* * ANAGRAM ADDITIONS * Customize Some Options */

    //Disable Avatar Call
	update_option( 'show_avatars', 0 );
	update_option( 'avatar_default', 'blank' );

	//Dsiable pings
	update_option( 'default_ping_status', 'closed' );


	//Set default lang
	update_option( 'WPLANG', '' );


	//Add purchase keys to default plugins
	update_option( 'cpupdate_cac-pro', '99e74138-8a53-4c16-abe0-87cbd181f597' );
	update_option( 'acf_pro_license', 'YToyOntzOjM6ImtleSI7czo3MjoiYjNKa1pYSmZhV1E5TXpJNU56QjhkSGx3WlQxa1pYWmxiRzl3WlhKOFpHRjBaVDB5TURFMExUQTNMVEEzSURFMk9qQTBPalU1IjtzOjM6InVybCI7czozMjoiaHR0cDovL2Rldi4xOTIuMTY4LjIyMi41MC54aXAuaW8iO30=' );
	update_option( 'rg_gforms_key', '38fd93100c2666e5ecd12efa6ced7e8d' );
	update_option( 'rg_gforms_enable_html5', '1' );

    // Set Timezone
    $timezone = "America/Denver";
    update_option( 'timezone_string', $timezone );


    // Start of the Week
    // 0 is Sunday, 1 is Monday and so on
    update_option( 'start_of_week', 0 );

    // Disable Smilies
    update_option( 'use_smilies', 0 );

	//Set default Default file insert to none instead of attachment page
	update_option( 'image_default_link_type', 'none' );

    // Don't Organize Uploads by Date
    update_option('uploads_use_yearmonth_folders',1);


    update_option( 'thumbnail_size_w', 125 );
	update_option( 'thumbnail_size_h', 125 );
	update_option( 'thumbnail_crop', '1' );

	update_option( 'medium_size_w', 750 );
	update_option( 'medium_size_h', 9999 );

	update_option( 'large_size_w', 1140 );
	update_option( 'large_size_h', 9999 );

    // Update Permalinks
    update_option( 'selection','custom' );
    update_option( 'permalink_structure','/%postname%/' );
    $wp_rewrite->init();
    $wp_rewrite->flush_rules();

}

function mapi_var_dump($var){
  if(current_user_can('administrator')) {
    echo '<pre>';
      var_dump($var);
    echo '</pre>';
  }
}
