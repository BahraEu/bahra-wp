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
<main id="site-content" >

	<?php
  $args = array(  
    'post_type' => 'artists',
    'post_status' => 'publish',
    'posts_per_page' => -1, 
    'orderby' => 'title', 
    'order' => 'ASC',
);

    
$loop = new WP_Query( $args );

$ourCurrentUser = wp_get_current_user();

if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0]
 == 'artist'||'adminstrator'||'admin') {
  // var_dump($ourCurrentUser);

while ( $loop->have_posts() ) : $loop->the_post();
get_template_part( 'template-parts/content-artist', get_post_type('artists') );
the_title();
echo '<div class="entry-content">';
the_content();
echo '</div>';
endwhile;

$fields = get_field("group_5e4d47ec4ded8");
   var_dump($fields);


  exit;
}else{wp_redirect( 'https://bahra.eu');
exit;
}



?>
</main >




