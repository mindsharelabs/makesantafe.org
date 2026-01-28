<?php
/**
 * Author: Mindshare Labs | @mindsharelabs
 * URL: https://mind.sh/are | @mindblank
 *
 */
define('THEME_VERSION', '4.5.3');
/*------------------------------------*\
    External Modules/Files
\*------------------------------------*/

include 'inc/content-functions.php';
include 'inc/cpt.php';
include 'inc/acf-functions.php';
include 'inc/woocommerce.php';
include 'inc/mindshare-events.php';
include 'inc/gravity-forms.php';

/*------------------------------------*\
    Theme Support
\*------------------------------------*/

if(!function_exists('mapi_write_log')) {
    function mapi_write_log($message) {
        if ( WP_DEBUG === true ) {
            if ( is_array($message) || is_object($message) ) {
                error_log( print_r($message, true) );
            } else {
                error_log( $message );
            }
        }
    }
}

add_filter('wp_img_tag_add_auto_sizes', function() {
    return false;
});

/**
 * Check if WooCommerce is activated
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
    function is_woocommerce_activated() {
        if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
    }
}

if (!isset($content_width)) {
    $content_width = 900;
}

// function make_theme_setup() {
    if (function_exists('add_theme_support')) {

        add_image_size('very-small-square', 100, 100, array('center', 'center'));
        add_image_size('small-square', 400, 400, array('center', 'center'));
        add_image_size('page-header', 1500, 300, array('center', 'center'));
        add_image_size('horz-thumbnail', 300, 150, array('center', 'center'));
        add_image_size('horz-thumbnail-lg', 500, 300, array('center', 'center'));

        //WooCommerce
        add_theme_support( 'woocommerce' );
        // add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');


        //load_theme_textdomain('mindblank', get_template_directory() . '/languages');
        
        // Add Thumbnail Theme Support
        add_theme_support('post-thumbnails');

        // Enables post and comment RSS feed links to head
        add_theme_support('automatic-feed-links');

        // Enable mind support
        add_theme_support('mind', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));

    

    }
// }


// add_action('init',function() {
//      // Localisation Support
//      make_theme_setup();
     
// });

add_filter('mind_staff_cards_image_size', function() {
    return 'small-square';
});
add_filter('mind_staff_card_classes', function() {
    return 'col-12 col-md-6 col-lg-4 d-flex flex-column h-100 justify-content-between px-4';
});
add_filter('mind_staff_cards_image_classes', function() {
    return 'rounded-circle card-img-top p-4';
});
add_filter('mind_staff_card_title_classes', function() {
    return 'staff-name text-center mb-1 mt-2 h4';
});


add_filter('mindevents_calendar_label', function($label) {
    // $id = get_the_ID();
    // $event_type = get_post_meta($id, 'event_type', true);
    // if($event_type == 'single-event') :
    //     return '<h3 class="event-schedule_label">Event Sessions</h3>';
    // else :
    //     return '<h3 class="event-schedule_label">Upcoming Classes</h3>';
    // endif;

    return '';
    
});


add_filter('mindevents_list_label', function($label) {
    // $id = get_the_ID();
    // $event_type = get_post_meta($id, 'event_type', true);
    // if($event_type == 'single-event') :
    //     return '<h3 class="event-schedule_label">Event Sessions</h3>';
    // else :
    //     return '<h3 class="event-schedule_label">Upcoming Classes</h3>';
    // endif;

    return '';
});

function make_param_shortcode( $atts ) {
    extract( shortcode_atts( array(
        'param' => 'param',
    ), $atts ) );
    return $_GET[$param];
}
add_shortcode('urlparam', 'make_param_shortcode');

/*------------------------------------*\
    Functions
\*------------------------------------*/

function mapi_post_edit() {
  $post_type = get_post_type();
  $post_type_obj = get_post_type_object($post_type);
  edit_post_link( 'Edit this ' . $post_type_obj->labels->singular_name, '', '', get_the_id(), 'btn btn-sm btn-info mt-3 mb-3 float-right post-edit-link' );
}


add_action('init', 'make_add_instructor_role');
function make_add_instructor_role(){
    global $wp_roles;
    if ( ! isset( $wp_roles ) )
      $wp_roles = new WP_Roles();

      $cust = $wp_roles->get_role('customer');
      //Adding a 'new_role' with all admin caps
      $wp_roles->add_role('instructor', 'Instructor', $cust->capabilities);
}

add_action( 'pre_get_posts', 'make_post_type_archive' );
function make_post_type_archive( $query ) {
    if( $query->is_main_query() && !is_admin() && is_post_type_archive( 'team' ) ) {
  		$query->set( 'posts_per_page', -1 );
  		$query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
  	} elseif( $query->is_main_query() && !is_admin() && is_post_type_archive( 'make_track' ) ) {
        $query->set( 'posts_per_page', -1 );
        $query->set( 'order', 'ASC' );
        $query->set( 'orderby', 'title' );
    } elseif ( $query->is_main_query() && !is_admin() && is_post_type_archive( 'certs' )) {
        $query->set( 'posts_per_page', -1 );
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
    }
}

function make_add_query_vars( $vars ) {
  $vars[] = "maker_id";
  return $vars;
}
add_filter( 'query_vars', 'make_add_query_vars' );



// mind Blank navigation
function mindblank_nav($menu)
{
    wp_nav_menu(
        array(
            'theme_location' => $menu,
            'menu' => '',
            'container' => 'div',
            'container_class' => 'menu-{menu slug}-container',
            'container_id' => '',
            'menu_class' => 'menu',
            'menu_id' => '',
            'echo' => true,
            'fallback_cb' => 'wp_page_menu',
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'items_wrap' => '<ul>%3$s</ul>',
            'depth' => 0,
            'walker' => ''
        )
    );
}

// Register mind Blank Navigation
function register_mind_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'mindblank'), // Main Navigation
        'mobile-menu' => __('Mobile Menu', 'mindblank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'mindblank'), // Sidebar Navigation
        'footer-menu' => __('Footer Menu', 'mindblank'), // Sidebar Navigation
    ));
}


function make_color_luminance( $hex, $percent ) {
	
	// validate hex string
	
	$hex = preg_replace( '/[^0-9a-f]/i', '', $hex );
	$new_hex = '#';
	
	if ( strlen( $hex ) < 6 ) {
		$hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
	}
	
	// convert to decimal and change luminosity
	for ($i = 0; $i < 3; $i++) {
		$dec = hexdec( substr( $hex, $i*2, 2 ) );
		$dec = min( max( 0, $dec + $dec * $percent ), 255 ); 
		$new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
	}		
	
	return $new_hex;
}

function shadeColor ($color, $percent) {

  $color = str_replace("#",'',$color);

  $r = Hexdec(Substr($color,0,2));
  $g = Hexdec(Substr($color,2,2));
  $b = Hexdec(Substr($color,4,2));

  $r = (Int)($r*(100+$percent)/100);
  $g = (Int)($g*(100+$percent)/100);
  $b = (Int)($b*(100+$percent)/100);

  $r = Trim(Dechex(($r<255)?$r:255));
  $g = Trim(Dechex(($g<255)?$g:255));
  $b = Trim(Dechex(($b<255)?$b:255));

  $r = ((Strlen($r)==1)?"0{$r}":$r);
  $g = ((Strlen($g)==1)?"0{$g}":$g);
  $b = ((Strlen($b)==1)?"0{$b}":$b);

  return (String)("#{$r}{$g}{$b}");
}

// Load mind Blank scripts (header.php)
function mindblank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {


        wp_register_script('mindblankscripts-min', get_template_directory_uri() . '/js/scripts.js', array('jquery'), THEME_VERSION, true);
        wp_enqueue_script('mindblankscripts-min');
        wp_localize_script( 'mindblankscripts-min', 'settings', array(
            'ajax_url' => admin_url( 'admin-ajax.php' )
          ));

        wp_register_script('bootstrap-min', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array(), THEME_VERSION, true);
        wp_enqueue_script('bootstrap-min');

        


        wp_register_script('fontawesome', 'https://kit.fontawesome.com/5bcc5329ee.js', array(), THEME_VERSION, true);
        wp_enqueue_script('fontawesome');
        add_action('wp_head', function() {
          echo '<link rel="preconnect" href="https://kit-pro.fontawesome.com">';
        });





    }
}

/*
 * Add async attributes to enqueued scripts where needed.
 * The ability to filter script tags was added in WordPress 4.1 for this purpose.
 */

add_filter( 'script_loader_tag', function ( $tag, $handle, $src ) {
    // the handles of the enqueued scripts we want to async
    $scripts = array( 'fontawesome');

    if ( in_array( $handle, $scripts ) ) {
        return '<script type="text/javascript" src="' . $src . '" data-search-pseudo-elements></script>';
    }

    return $tag;
}, 10, 3 );


add_action('wp', 'localize_header_svg_script');
function localize_header_svg_script() {

    wp_register_script('snapsvg-js', get_template_directory_uri() . '/js/svg.js', array(), THEME_VERSION);
    wp_enqueue_script('snapsvg-js');

    wp_register_script('svgintro-js', get_template_directory_uri() . '/js/svg-intro.js', array('snapsvg-js'), '', true);
    wp_enqueue_script('svgintro-js');

    wp_localize_script( 'svgintro-js', 'svgvars', array(
        'title' => strtoupper(make_get_title()),
        'home' => (is_front_page(  ) ? true : false),
        'logo' => (is_front_page(  ) ? get_template_directory_uri() . "/img/make-santa-fe.svg" : get_template_directory_uri() . "/img/make-santa-fe-sub-page.svg"),
        )
    );

}





function make_get_title() {
    if(is_home()) :
        $title = get_bloginfo('description');
    elseif(class_exists('WC')) :
        if(is_product_category()) :
            $title = single_term_title('', false);
        elseif(is_product()) :
            $title = get_the_title();
        endif;
    elseif(is_archive(  )) :
        $title = get_the_archive_title();
    elseif(is_single()) :
        $title = get_the_title();

    else :
        $title = get_the_title();
    endif;


  return $title;
}

function make_header_text_color() {
  if(is_home()){
    $color = '#555555';
  } else {
    $color = '#ffffff';
  }
  return $color;
}




add_filter( 'get_the_archive_title_prefix', '__return_empty_string');


function make_user_has_badge($badgeID) {
    $badges = get_user_meta(get_current_user_id(), 'certifications', true);
    if($badges) :
        if(in_array($badgeID, $badges)) :
            return true;
        else :
            return false;
        endif;
    else :
        return false;
    endif;
}


// Load mind Blank conditional scripts
function mindblank_conditional_scripts(){
    if (is_archive('certs')) :
        // wp_register_script('orgchart-js', get_template_directory_uri() . '/js/orgchart.js', false, THEME_VERSION, true);
        // wp_enqueue_script('orgchart-js');

        // wp_register_script('orgchart-init', get_template_directory_uri() . '/js/gojs-init.js', array('orgchart-js'), THEME_VERSION, true);
        // wp_enqueue_script('orgchart-init');
        // wp_localize_script( 'orgchart-init', 'badgeSettings', array(
        //     'ajax_url' => admin_url( 'admin-ajax.php' ),
        //     'badgeJSON' => json_encode(get_badge_data(), JSON_UNESCAPED_SLASHES)
        // ));
    endif;    
    if ( is_page_template( 'template-makers.php' ) ) :
        // wp_register_script('listjs-min', get_template_directory_uri() . '/js/list.min.js', array('jquery'), THEME_VERSION, true);
        // wp_enqueue_script('listjs-min');
        // // wp_localize_script( 'listjs-min', 'settings', array(
        // //     'ajax_url' => admin_url( 'admin-ajax.php' )
        // // ));

        // wp_register_script('list-js-init', get_template_directory_uri() . '/js/list-js-init.js', array('jquery', 'listjs-min'), THEME_VERSION, true);
        // wp_enqueue_script('list-js-init');
    endif;
      
}

// Load mind Blank styles
function mindblank_styles(){
    wp_register_style('mindblankcssmin', get_template_directory_uri() . '/css/style.css', array(), THEME_VERSION);
    wp_enqueue_style('mindblankcssmin');

    wp_register_style('google-fonts', 'https://fonts.googleapis.com/css?family=Montserrat:300i,400,500i,600,800&display=swap', array(), THEME_VERSION);
    wp_enqueue_style('google-fonts');


}



function make_widget_title( $title, $instance, $id_base ) {
    $new_title = '<h3 class="fancy">' . $title;
    ob_start();
    include get_template_directory() . '/inc/header-back.php';
    $new_title .= '</h3>' . ob_get_clean();
    return $new_title;
}
add_filter( 'widget_title', 'make_widget_title', 10, 3 );


// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// Remove the width and height attributes from inserted images
function remove_width_attribute($html)
{
    $html = preg_replace('/(width|height)="\d*"\s/', "", $html);
    return $html;
}


// If Dynamic Sidebar Exists
if (function_exists('register_sidebar')) {
    // Define Sidebar Widget Area 1

    register_sidebar(array(
        'name' => __('Widget Area 1', 'mindblank'),
        'description' => __('Widgets on all sub-pages', 'mindblank'),
        'id' => 'page-sidebar',
        'before_widget' => '<div id="%1$s" class="%2$s widget-container">',
        'after_widget' => '</div>',
        'before_title' => '',
        'after_title' => ''
    ));
    register_sidebar(array(
        'name' => __('Footer Widgets', 'mindblank'),
        'description' => __('Widgets in the footer', 'mindblank'),
        'id' => 'footer-widgets',
        'before_widget' => '<div id="%1$s" class="%2$s col-12 col-md-3">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;

    if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
        remove_action('wp_head', array(
            $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
            'recent_comments_style'
        ));
    }
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function mindwp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'next_text' => '<i class="fas fa-angle-double-right"></i>',
        'prev_text' => '<i class="fas fa-angle-double-left"></i>',

    ));
}




add_filter('excerpt_length', function ($length){
    if(is_post_type_archive('make_track')) :
        return 80;
    else :
        return 40;
    endif;
}, 999);





//Disable emojis in WordPress
add_action( 'init', 'make_disable_emojis' );

function make_disable_emojis() {
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'tiny_mce_plugins', 'make_disable_emojis_tinymce' );
}

function make_disable_emojis_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}


// Custom View Article link to Post
function mind_blank_view_article($more)
{
    global $post;
    //if post type is product
    if(get_post_type($post) == 'product') :
        // return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Product', 'mindblank') . '</a>';
    elseif(get_post_type($post) == 'make_track') :
        return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Track', 'mindblank') . '</a>';
    elseif(get_post_type($post) == 'post'):
        return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'mindblank') . '</a>';    
    endif;
}


// Remove 'text/css' from our enqueued stylesheet
function mind_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions($html)
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function mindblankgravatar($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}



/*------------------------------------*\
    Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_filter('wp_img_tag_add_auto_sizes', '__return_false'); // Disable inline image size attributes
add_action('init', 'mindblank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'mindblank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'mindblank_styles'); // Add Theme Stylesheet
add_action('init', 'register_mind_menu'); // Add mind Blank Menu

add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'mindwp_pagination'); // Add our mind Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'mindblankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'mind_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('style_loader_tag', 'mind_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('post_thumbnail_html', 'remove_width_attribute', 10); // Remove width and height dynamic attributes to post images
add_filter('image_send_to_editor', 'remove_width_attribute', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('mind_shortcode_demo', 'mind_shortcode_demo'); // You can place [mind_shortcode_demo] in Pages, Posts now.
add_shortcode('mind_shortcode_demo_2', 'mind_shortcode_demo_2'); // Place [mind_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [mind_shortcode_demo] [mind_shortcode_demo_2] Here's the page title! [/mind_shortcode_demo_2] [/mind_shortcode_demo]

add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

//WooCommerce Shity Notices
add_filter( 'woocommerce_helper_suppress_admin_notices', '__return_true' );
add_filter( 'jetpack_just_in_time_msgs', '_return_false' );


/*  Add responsive container to embeds
/* ------------------------------------ */
function make_embed_html( $html ) {
    return '<div class="embed-container">' . $html . '</div>';
}

add_filter( 'embed_oembed_html', 'make_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'make_embed_html' ); // Jetpack




// Registering custom post status
function make_custom_post_status(){
    register_post_status('expired', array(
        'label'                     => _x( 'Expired', 'post' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>' ),
    ) );
}
add_action( 'init', 'make_custom_post_status' );

// Using jQuery to add it to post status dropdown
add_action('admin_footer-post.php', 'make_append_post_status_list');
function make_append_post_status_list(){
  global $post;
  $complete = '';
  $label = '';
  if($post->post_type == 'product'){
    if($post->post_status == 'expired'){
      $complete = ' selected="selected"';
      $label = '<span id="post-status-display"> Expired</span>';
    }
    echo '<script>
    jQuery(document).ready(function($){
    $("select#post_status").append("<option value=\"expired\" '.$complete.'>Expired</option>");
    $(".misc-pub-section label").append("'.$label.'");
    });
    </script>
    ';
  }
}



add_action('init', 'make_author_base');
function make_author_base() {
    global $wp_rewrite;
    $author_slug = 'maker'; // change slug name
    $wp_rewrite->author_base = $author_slug;
}


add_filter('mo_oauth_server_authorize_dialog_template_path', function( $template ) {
    return get_template_directory() . '/inc/miniorange-authscreen.php';
});