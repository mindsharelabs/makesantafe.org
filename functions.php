<?php
/**
 * Author: Mindshare Labs | @mindsharelabs
 * URL: https://mind.sh/are | @mindblank
 *
 */
define('THEME_VERSION', '2.2.3');
/*------------------------------------*\
    External Modules/Files
\*------------------------------------*/

include_once 'inc/content-functions.php';
include_once 'inc/cpt.php';
include_once 'inc/acf-functions.php';
include_once 'inc/aq_resize.php';
include_once 'inc/woocommerce.php';
include_once 'inc/gravity-forms.php';

/*------------------------------------*\
    Theme Support
\*------------------------------------*/

if (!isset($content_width)) {
    $content_width = 900;
}

if (function_exists('add_theme_support')) {

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Enable mind support
    add_theme_support('mind', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));

    // Localisation Support
    load_theme_textdomain('mindblank', get_template_directory() . '/languages');



}

/*------------------------------------*\
    Functions
\*------------------------------------*/

function mapi_post_edit() {
  $post_type = get_post_type();
  $post_type_obj = get_post_type_object($post_type);
  edit_post_link( 'Edit this ' . $post_type_obj->labels->singular_name, '', '', get_the_id(), 'btn btn-sm btn-info mt-3 mb-3 float-right post-edit-link' );
}

add_action('init', 'make_add_instructor_role');

function make_add_instructor_role()
{
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
  	}



  if ( $query->is_main_query() && !is_admin() && is_post_type_archive( 'certs' )) {

      $query->set( 'posts_per_page', -1 );
  		$query->set( 'orderby', 'title' );
      $query->set( 'order', 'ASC' );
  }

  if ( $query->is_main_query() && !is_admin() && $query->is_tax('product_cat')) {
      $query->set( 'post_status', 'publish' );
      $query->set('meta_key', 'make_event_date_timestamp' );
      $query->set('orderby', 'meta_value date title');
      $query->set('order', 'ASC' );
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
        'sidebar-menu' => __('Sidebar Menu', 'mindblank'), // Sidebar Navigation
        'member-menu' => __('Member Menu', 'mindblank'), // Sidebar Navigation
        'footer-menu' => __('Footer Menu', 'mindblank'), // Sidebar Navigation
    ));
}




function shadeColor ($color, $percent) {

  $color = str_replace("#",Null,$color);

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

        // wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), THEME_VERSION); // Conditionizr
        // wp_enqueue_script('conditionizr'); // Enqueue it!
        //
        // wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), THEME_VERSION); // Modernizr
        // wp_enqueue_script('modernizr'); // Enqueue it!


        wp_register_script('mindblankscripts-min', get_template_directory_uri() . '/js/scripts.js', array('bootstrap', 'slick-slider'), THEME_VERSION, true);
        wp_enqueue_script('mindblankscripts-min');

        wp_localize_script( 'mindblankscripts-min', 'settings', array(
          'ajax_url' => admin_url( 'admin-ajax.php' )
        ));

        wp_register_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array('jquery'), THEME_VERSION);
        wp_enqueue_script('popper');

        wp_register_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array('jquery', 'popper'), THEME_VERSION);
        wp_enqueue_script('bootstrap');


        wp_register_script('slideout-js', get_template_directory_uri() . '/js/slideout.min.js', array(), THEME_VERSION);
        wp_enqueue_script('slideout-js');

        wp_register_script('snapsvg-js', get_template_directory_uri() . '/js/svg.js', array(), THEME_VERSION);
        wp_enqueue_script('snapsvg-js');


        wp_register_script('slick-slider', get_template_directory_uri() . '/js/slick.min.js', array(), THEME_VERSION);
        wp_enqueue_script('slick-slider');

        wp_register_script('cookie-js', 'https://cdn.jsdelivr.net/npm/js-cookie@beta/dist/js.cookie.min.js', array(), THEME_VERSION);
        wp_enqueue_script('cookie-js');


    }
}


add_action('wp', 'localize_header_svg_script');
function localize_header_svg_script() {
  wp_register_script('svgintro-js', get_template_directory_uri() . '/js/svg-intro.js', array('snapsvg-js'), '', true);
  wp_enqueue_script('svgintro-js');

  wp_localize_script( 'svgintro-js', 'svgvars', array(
    'words' => strtoupper(make_get_title()),
    'color' => make_header_text_color(),
    'litcolor' => shadeColor('#36383E', 20),
    'home' => false,
    'logo' => get_template_directory_uri()."/img/make-santa-fe.svg",
    'intro' => get_template_directory_uri()."/img/banner.svg",
    'circuit' => get_template_directory_uri()."/img/circuit.svg" )
  );

}

function make_get_title() {
  if(is_home()) :
    $title = get_bloginfo('description');
  elseif(is_product_category()) :
    $title = single_term_title('', false);
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

// Load mind Blank conditional scripts
function mindblank_conditional_scripts()
{
    // if (is_page_template('template-allscores.php')) {
    //     // Conditional script(s)
    //
    // }
}

// Load mind Blank styles
function mindblank_styles()
{
    wp_register_style('mindblankcssmin', get_template_directory_uri() . '/css/style.css', array(), THEME_VERSION);
    wp_enqueue_style('mindblankcssmin');

    wp_register_style('google-fonts', 'https://fonts.googleapis.com/css?family=Courier+Prime:400,700|Montserrat:300i,400,500i,600,800&display=swap', array(), THEME_VERSION);
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
        'before_widget' => '<div id="%1$s" class="%2$s col-xs-12 col-md-3">',
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


// Create the Custom Excerpts callback
function mindwp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', 40);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

function lobob_excerpt_length($length)
{
    return 20;
}

add_filter('excerpt_length', 'lobob_excerpt_length', 999);





// Custom View Article link to Post
function mind_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'mindblank') . '</a>';
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
