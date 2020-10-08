<?php
/*
	This function exposes all SEO meta data to the GraphQl server. This only works with the SEO Framework plugin because
	of the specific data values that have to be found and loaded.
	_genesis_title = The title that will show in the search results of the page
	_genesis_description = The description of the page that will show in search results
	robot_rules = The meta data for allowing bots to crawl the page
*/
function exposeSEOMeta() {

	add_action( 'graphql_register_types', function() {
		register_graphql_field( 'Page', 'seoTitle', [
		   'type' => 'string',
		   'description' => __( 'The meta title of the post', 'wp-graphql' ),
		   'resolve' => function( $post ) {
			 $meta_title = get_post_meta( $post->ID, '_genesis_title', true );
			 return ! empty( $meta_title ) ? $meta_title : 'No Title Found';
		   }
		] );
	  } );

	  add_action( 'graphql_register_types', function() {
		register_graphql_field( 'Page', 'seoDescription', [
		   'type' => 'String',
		   'description' => __( 'The meta description of the post', 'wp-graphql' ),
		   'resolve' => function( $post ) {
			 $meta_desc = get_post_meta( $post->ID, '_genesis_description', true );
			 return ! empty( $meta_desc ) ? $meta_desc : 'No Description Found';
		   }
		] );
	  } );

	add_action( 'graphql_register_types', function() {
		register_graphql_field( 'Post', 'seoTitle', [
		   'type' => 'String',
		   'description' => __( 'The meta title of the post', 'wp-graphql' ),
		   'resolve' => function( $post ) {
			 $meta_title = get_post_meta( $post->ID, '_genesis_title', true );
			 return ! empty( $meta_title ) ? $meta_title : 'No Title Found';
		   }
		] );
	  } );

	  add_action( 'graphql_register_types', function() {
		register_graphql_field( 'Post', 'seoDescription', [
		   'type' => 'String',
		   'description' => __( 'The meta description of the post', 'wp-graphql' ),
		   'resolve' => function( $post ) {
			 $meta_desc = get_post_meta( $post->ID, '_genesis_description', true );
			 return ! empty( $meta_desc ) ? $meta_desc : 'No Description Found';
		   }
		] );
	  } );
		
		add_action( 'graphql_register_types', function() {
			register_graphql_field( 'Fruit', 'seoTitle', [
				 'type' => 'String',
				 'description' => __( 'The meta title of the post', 'wp-graphql' ),
				 'resolve' => function( $post ) {
				 $meta_title = get_post_meta( $post->ID, '_genesis_title', true );
				 return ! empty( $meta_title ) ? $meta_title : 'No Title Found';
				 }
			] );
			} );
	
			add_action( 'graphql_register_types', function() {
			register_graphql_field( 'Fruit', 'seoDescription', [
				 'type' => 'String',
				 'description' => __( 'The meta description of the post', 'wp-graphql' ),
				 'resolve' => function( $post ) {
				 $meta_desc = get_post_meta( $post->ID, '_genesis_description', true );
				 return ! empty( $meta_desc ) ? $meta_desc : 'No Description Found';
				 }
			] );
			} );
}

add_action('init','exposeSEOMeta');

