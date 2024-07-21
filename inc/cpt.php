<?php
/*------------------------------------*\
    Custom Post Types
\*------------------------------------*/

add_action('init', 'create_post_type_mind'); // Add our mind Blank Custom Post Type
add_action( 'init', 'make_create_taxonomies');




function create_post_type_mind(){
    register_post_type('tool', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Make Tools', 'mindblank'), // Rename these to suit
                'singular_name' => __('Tool', 'mindblank'),
                'add_new' => __('Add New', 'mindblank'),
                'add_new_item' => __('Add New Tool', 'mindblank'),
                'edit' => __('Edit Tool', 'mindblank'),
                'edit_item' => __('Edit Tool', 'mindblank'),
                'new_item' => __('New Tool', 'mindblank'),
                'view' => __('View Tool', 'mindblank'),
                'view_item' => __('View Tool', 'mindblank'),
                'search_items' => __('Search Tools', 'mindblank'),
                'not_found' => __('No Tools found', 'mindblank'),
                'not_found_in_trash' => __('NoTools found in Trash', 'mindblank')
            ),
            'public' => true,
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => 'tools-and-equipment',
            'show_in_rest' => true,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail',
                'author'
            ), // Go to Dashboard Custom mind Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            'taxonomies' => array(
                'post_tag',
                // 'category'
            ) // Add Category and Post Tags support
        ));

        
     register_post_type('certs', // Register Custom Post Type
      array(
          'labels' => array(
              'name' => __('Badges', 'mindblank'), // Rename these to suit
              'singular_name' => __('Badge', 'mindblank'),
              'add_new' => __('Add New Badge', 'mindblank'),
              'add_new_item' => __('Add New Badge', 'mindblank'),
              'edit' => __('Edit Badge', 'mindblank'),
              'edit_item' => __('Edit Badge', 'mindblank'),
              'new_item' => __('New Badge', 'mindblank'),
              'view' => __('View Badges', 'mindblank'),
              'view_item' => __('View Badge', 'mindblank'),
              'search_items' => __('Search Badges', 'mindblank'),
              'not_found' => __('No Badges found', 'mindblank'),
              'not_found_in_trash' => __('No Badges found in Trash', 'mindblank')
          ),
          'public' => true,
          'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
          'has_archive' => 'badge',
          'show_in_rest' => true,
          'supports' => array(
              'title',
              'editor',
              'excerpt',
              'thumbnail',
              'author',
              'page-attributes' 
          ), // Go to Dashboard Custom mind Blank post for supports
          'can_export' => true, // Allows export in Teams > Export
          // 'taxonomies' => array(
          //     'post_tag',
          //     'category'
          // ) // Add Category and Post Tags support
      ));

}


// hook into the init action and call create_book_taxonomies when it fires

function make_create_taxonomies() {

  $tool_type_labels = array(
		'name'              => _x( 'Our Shop Spaces', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Shop Space', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Shop Spaces', 'textdomain' ),
		'all_items'         => __( 'All Shop Spaces', 'textdomain' ),
		'parent_item'       => __( 'Parent Shop Space', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Shop Space:', 'textdomain' ),
		'edit_item'         => __( 'Edit Shop Space', 'textdomain' ),
		'update_item'       => __( 'Update Shop Space', 'textdomain' ),
		'add_new_item'      => __( 'Add New Shop Space', 'textdomain' ),
		'new_item_name'     => __( 'New Shop Space Name', 'textdomain' ),
		'menu_name'         => __( 'Shop Space', 'textdomain' ),
	);

	$tool_type_args = array(
		'hierarchical'      => true,
		'labels'            => $tool_type_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'tool-type' ),
	);



    register_taxonomy( 'tool_type', array( 'tool' ), $tool_type_args );


}
