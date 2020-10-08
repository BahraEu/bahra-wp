<?php

/**
 * 
 * 
 *
 * 
 *
 * Add artists post type
 * 
 * 
 * 
 * 
 * 
 */
add_action( 'init', function() {
   register_post_type( 'artists', [
      'show_ui' => true,
      'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'),
      'rewrite'=>array('slug'=>'Artists'),
      
      'labels'  => [
      	'menu_name' => __( 'Artists', 'BAHRA' ),
      	'add_new_item'=>'Add New Artist',
      	'edit_item'=>'Add Artist',
      	'all_items'=>'All Artists',
      	'singular_name'=>'Artist'
      ],
      'show_in_graphql' => true,
      'hierarchical' => true,
      'graphql_single_name' => 'artist',
      'graphql_plural_name' => 'artists',
      'menu_icon' => 'dashicons-art',
      'capability_type' => 'artist',
      'map_meta_cap' => true
   ] );
} );
add_filter( 'register_post_type_args', function( $args, $post_type ) {

	if ( 'Artists' === $post_type ) {
		$args['show_in_graphql'] = true;
		$args['graphql_single_name'] = 'artist';
		$args['graphql_plural_name'] = 'artists';
	}

	return $args;

}, 10, 2 );

function add_artist_caps() {
  $role = get_role( 'administrator' );
  $role->add_cap( 'edit_artist' ); 
  $role->add_cap( 'edit_artists' ); 
  $role->add_cap( 'edit_others_artists' ); 
  $role->add_cap( 'publish_artists' ); 
  $role->add_cap( 'read_artist' ); 
  $role->add_cap( 'read_private_artists' ); 
  $role->add_cap( 'delete_artist' ); 
  $role->add_cap( 'edit_published_artists' );   //added
  $role->add_cap( 'delete_published_artists' ); //added
}
add_action( 'admin_init', 'add_artist_caps');




