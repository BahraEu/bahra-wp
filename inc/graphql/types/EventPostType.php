<?php
/**
 * 
 * 
 *
 * Add events post type
 * 
 * 
 * 
 */
add_action( 'init', function() {
   register_post_type( 'events', [
     
		'supports'=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'),
		'rewrite'=>array('slug'=>'Events'),
      'show_ui' => true,
      'labels'  => [
      	'menu_name' => __( 'Events', 'BAHRA' ),//@see https://developer.wordpress.org/themes/functionality/internationalization/
      	'add_new_item'=>'Add New Event',
      	'edit_item'=>'Add Event',
      	'all_items'=>'All Events',
      	'singular_name'=>'Event'
      	
      	
      ],
      'show_in_graphql' => true,
      'hierarchical' => true,
      'graphql_single_name' => 'event',
      'graphql_plural_name' => 'events',
      'menu_icon' => 'dashicons-calendar',
      'capability_type' => 'event',
      'map_meta_cap' => true
   ] );
} );
function add_event_caps() {
  $role = get_role( 'administrator' );
  $role->add_cap( 'edit_event' ); 
  $role->add_cap( 'edit_events' ); 
  $role->add_cap( 'edit_others_events' ); 
  $role->add_cap( 'publish_events' ); 
  $role->add_cap( 'read_event' ); 
  $role->add_cap( 'read_private_events' ); 
  $role->add_cap( 'delete_event' ); 
  $role->add_cap( 'edit_published_events' );   //added
  $role->add_cap( 'delete_published_events' ); //added
}
add_action( 'admin_init', 'add_event_caps');