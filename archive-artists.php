<?php get_header();
/**
 * Template Name: Artists Template
 * Template Post Type: post, page
 *
 * @package WordPress
 * @subpackage BAHRA
 * @since Bahra
 */

?>
<main id="site-content" role="main">

	<?php
 $args = array( 'post_type' => 'artists', 'posts_per_page' => 10 );
 $loop = new WP_Query( $args );
 while ( $loop->have_posts() ) : $loop->the_post();
 get_template_part( 'template-parts/content-artist', get_post_type('artists') );
 the_title();
 echo '<div class="entry-content">';
 the_content();
 echo '</div>';
 endwhile;


	?>
</main >