<?php
/*------------------------------------*\
    Custom Post Types
\*------------------------------------*/

add_action('init', 'create_post_type_mind'); // Add our mind Blank Custom Post Type
function create_post_type_mind()
{
    // register_taxonomy_for_object_type('category', 'Tool'); // Register Taxonomies for Category
    // register_taxonomy_for_object_type('post_tag', 'Tool');
    register_post_type('tool', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Tools', 'mindblank'), // Rename these to suit
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
            'has_archive' => 'tool',
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail',
                'author'
            ), // Go to Dashboard Custom mind Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            // 'taxonomies' => array(
            //     'post_tag',
            //     'category'
            // ) // Add Category and Post Tags support
        ));

        register_post_type('team', // Register Custom Post Type
              array(
                  'labels' => array(
                      'name' => __('Team', 'mindblank'), // Rename these to suit
                      'singular_name' => __('Team', 'mindblank'),
                      'add_new' => __('Add New Team Member', 'mindblank'),
                      'add_new_item' => __('Add New Team Member', 'mindblank'),
                      'edit' => __('Edit  Member', 'mindblank'),
                      'edit_item' => __('Edit Team Member', 'mindblank'),
                      'new_item' => __('New Team Member', 'mindblank'),
                      'view' => __('View Team Members', 'mindblank'),
                      'view_item' => __('View Team Member', 'mindblank'),
                      'search_items' => __('Search Team Members', 'mindblank'),
                      'not_found' => __('No Team Members found', 'mindblank'),
                      'not_found_in_trash' => __('No Team Members found in Trash', 'mindblank')
                  ),
                  'public' => true,
                  'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
                  'has_archive' => 'team',
                  'supports' => array(
                      'title',
                      'editor',
                      'excerpt',
                      'thumbnail',
                      'author'
                  ), // Go to Dashboard Custom mind Blank post for supports
                  'can_export' => true, // Allows export in Teams > Export
                  // 'taxonomies' => array(
                  //     'post_tag',
                  //     'category'
                  // ) // Add Category and Post Tags support
              ));
}


// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_staff_taxonomies', 0 );

function create_staff_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Staff Types', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Staff Type', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Staff Types', 'textdomain' ),
		'all_items'         => __( 'All Staff Types', 'textdomain' ),
		'parent_item'       => __( 'Parent Staff Type', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Staff Type:', 'textdomain' ),
		'edit_item'         => __( 'Edit Staff Type', 'textdomain' ),
		'update_item'       => __( 'Update Staff Type', 'textdomain' ),
		'add_new_item'      => __( 'Add New Staff Type', 'textdomain' ),
		'new_item_name'     => __( 'New Staff Type Name', 'textdomain' ),
		'menu_name'         => __( 'Staff Type', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'type' ),
	);

	register_taxonomy( 'role', array( 'team' ), $args );


}
