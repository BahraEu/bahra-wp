<?php get_header();
/**
 * Template Name: Product Template
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
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => -1, 
    'orderby' => 'title', 
    'order' => 'ASC',
);

    
$loop = new WP_Query( $args );

$ourCurrentUser = wp_get_current_user();

if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0]
 == 'product'||'adminstrator'||'admin') {
  // var_dump($ourCurrentUser);

while ( $loop->have_posts() ) : $loop->the_post();
get_template_part( 'template-parts/content-product', get_post_type('product') );
the_title();
echo '<div class="entry-content">';
the_content();
echo '</div>';
endwhile;

  exit;
}else{wp_redirect( 'https://bahra.eu');
exit;
}



?>
</main >




