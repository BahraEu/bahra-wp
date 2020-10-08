<?php

/**
 * 
 * 
 * 
 * add-team-post
 * 
 * 
 * 
 */

add_action('init', 'create_team_post_type');
function create_team_post_type() {
    register_post_type( 'team',
        array(
            'labels' => array(
                'name' => __('Team'),
                'singular_name' => __('Admin'),
            'add_new_item'       => __( 'Add New Admin' ),
     'edit_item'          => __( 'Edit Admin' ),
     'new_item'           => __( 'New Admin' ),
     'all_items'          => __( 'All Admins' ),     
     'view_item'          => __( 'View Admin' ),
     'search_items'       => __( 'Search Admins' ),
            
            ),
            'public' => true,
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 21,
            'rewrite' => array('slug' => 'admin'),
            'supports' => array('title', 'editor', 'thumbnail'),
            'show_ui' => true,
         'show_in_graphql' => true,
         'graphql_single_name' => 'Admin',
       'graphql_plural_name' => 'team',
       'menu_icon' => 'dashicons-sos',
       'capability_type' => 'team',
       'map_meta_cap' => true
        )
    );
}

function add_team_caps() {
  $role = get_role( 'administrator' );
  $role->add_cap( 'edit_Admin' ); 
  $role->add_cap( 'edit_Admin' ); 
  $role->add_cap( 'edit_others_Admin' ); 
  $role->add_cap( 'publish_Admin' ); 
  $role->add_cap( 'read_Admin' ); 
  $role->add_cap( 'read_private_Admin' ); 
  $role->add_cap( 'delete_Admin' );
}

add_action( 'admin_init', 'add_team_caps');

?>