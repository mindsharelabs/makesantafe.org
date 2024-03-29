<?php
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' 	=> 'Theme General Settings',
        'menu_title'	=> 'Theme Settings',
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Header Settings',
        'menu_title'	=> 'Header Settings',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Footer Settings',
        'menu_title'	=> 'Footer',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Member Notice',
        'menu_title'	=> 'Member Notice',
        'parent_slug'	=> 'theme-general-settings',
    ));


    acf_add_options_page(array(
        'page_title' 	=> 'Membership Resources',
        'menu_title'	=> 'Membership Resourcess',
        'menu_slug' 	=> 'make-member-resources',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));

    // acf_add_options_sub_page(array(
    //     'page_title' 	=> 'Theme Header Settings',
    //     'menu_title'	=> 'Header Settings',
    //     'parent_slug'	=> 'theme-general-settings',
    // ));

}
