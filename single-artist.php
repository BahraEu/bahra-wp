<?php get_header();
/**
 * Template Name: Artist Template
 * Template Post Type: post, page
 *
 * The template for displaying single posts and pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage BAHRA
 * @since bahra
 */
?>
<main id="site-content" role="main">

	<?php
  $args = array(  
    'post_type' => 'artists',
    'post_status' => 'publish',
    'posts_per_page' => -1, 
    'orderby' => 'title', 
    'order' => 'ASC',
    'cat' => 'home',
);

$loop = new WP_Query( $args ); 
    
while ( $loop->have_posts() ) : $loop->the_post(); 
    $featured_img = wp_get_attachment_image_src( $post->ID );
    print the_title();
    the_excerpt(); 
endwhile;

wp_reset_postdata(); 


		
   ?>
</main >




