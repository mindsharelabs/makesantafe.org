<?php
/*------------------------------------*\
    Custom Post Types
\*------------------------------------*/

add_action('init', 'create_post_type_mind'); // Add our mind Blank Custom Post Type
function create_post_type_mind()
{
    register_taxonomy_for_object_type('category', 'podcast'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'podcast');
    register_post_type('podcast', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('Podcasts', 'mindblank'), // Rename these to suit
                'singular_name' => __('Podcast', 'mindblank'),
                'add_new' => __('Add New', 'mindblank'),
                'add_new_item' => __('Add New Podcast', 'mindblank'),
                'edit' => __('Edit Podcast', 'mindblank'),
                'edit_item' => __('Edit Podcast', 'mindblank'),
                'new_item' => __('New Podcast', 'mindblank'),
                'view' => __('View Podcast', 'mindblank'),
                'view_item' => __('View Podcast', 'mindblank'),
                'search_items' => __('Search Podcasts', 'mindblank'),
                'not_found' => __('No Podcasts found', 'mindblank'),
                'not_found_in_trash' => __('NoPodcasts found in Trash', 'mindblank')
            ),
            'public' => true,
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => 'podcast',
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
                'category'
            ) // Add Category and Post Tags support
        ));
}