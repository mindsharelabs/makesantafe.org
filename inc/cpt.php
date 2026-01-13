<?php
/*------------------------------------*\
    Custom Post Types
\*------------------------------------*/

add_action('init', 'create_post_type_mind'); // Add our mind Blank Custom Post Type
add_action( 'init', 'make_create_taxonomies');




function create_post_type_mind(){
        
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

  


}
