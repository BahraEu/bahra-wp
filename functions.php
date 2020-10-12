<?php
/*
 * ==================================
 * Random Helper Functions
 * ==================================
 */
require_once 'inc/src/cors.php';
//Automatically links featured images to their posts

require_once 'inc/src/LinksFeaturedImages.php';
//   svg ai psd
require_once 'inc/src/ImageSupport.php';

// Frontend origin.
require_once 'inc/src/frontend-origin.php';

// ACF commands.
require_once 'classes/class-acf-commands.php';

// Logging functions.
require_once 'inc/src/log.php';
//	Exposing google maps Advanced Custom Fields 

require_once 'inc/src/GoogleMaps.php';

// Admin modifications.
require_once 'inc/src/admin.php';

// Add Menus.
require_once 'inc/src/menus.php';

// Add Headless Settings area.
require_once 'inc/src/acf-options.php';
// SEO
require_once'inc/graphql/types/SEOMetaTag.php';
//Team
require_once 'inc/graphql/types/TeamPostType.php';
//Artist
require_once 'inc/graphql/types/ArtistPostType.php';
//Event
require_once 'inc/graphql/types/EventPostType.php';


add_action("wp_ajax_my_user_like", "my_user_like");
add_action("wp_ajax_nopriv_my_user_like", "please_login");

// define the function to be fired for logged in users
function my_user_like() {
   
   // nonce check for an extra layer of security, the function will exit if it fails
   if ( !wp_verify_nonce( $_REQUEST['nonce'], "my_user_like_nonce")) {
      exit("Woof Woof Woof");
   }   
   
   // fetch like_count for a post, set it to 0 if it's empty, increment by 1 when a click is registered 
   $like_count = get_post_meta($_REQUEST["post_id"], "likes", true);
   $like_count = ($like_count == ’) ? 0 : $like_count;
   $new_like_count = $like_count + 1;
   
   // Update the value of 'likes' meta key for the specified post, creates new meta data for the post if none exists
   $like = update_post_meta($_REQUEST["post_id"], "likes", $new_like_count);
   
   // If above action fails, result type is set to 'error' and like_count set to old value, if success, updated to new_like_count  
   if($like === false) {
      $result['type'] = "error";
      $result['like_count'] = $like_count;
   }
   else {
      $result['type'] = "success";
      $result['like_count'] = $new_like_count;
   }
   
   // Check if action was fired via Ajax call. If yes, JS code will be triggered, else the user is redirected to the post page
   if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      $result = json_encode($result);
      echo $result;
   }
   else {
      header("Location: ".$_SERVER["HTTP_REFERER"]);
   }

   // don't forget to end your scripts with a die() function - very important
   die();
}

// define the function to be fired for logged out users
function please_login() {
   echo "You must log in to like";
   die();
}




// used here only for enabling syntax highlighting. Leave this out if it's already included in your plugin file.

// Fires after WordPress has finished loading, but before any headers are sent.
add_action( 'init', 'script_enqueuer' );

function script_enqueuer() {
   
   // Register the JS file with a unique handle, file location, and an array of dependencies
   wp_register_script( "liker_script", plugin_dir_url(__FILE__).'assets/js/liker_script.js', array('jquery') );
   
   // localize the script to your domain name, so that you can reference the url to admin-ajax.php file easily
   wp_localize_script( 'liker_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   
   // enqueue jQuery library and the script you registered above
   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'liker_script' );
}



























add_filter('xmlrpc_enabled', '__return_false'); //Disables third party featuring of blog for better security

add_theme_support( 'post-thumbnails' );




/**
 * 
 *
 * ARABIC PRODUCT
 * 
 * 
 */

function arabicProductDescription() {

	add_action( 'graphql_register_types', function() {
		register_graphql_field( 'Product', 'arabArtistName', [
		   'type' => 'string',
		   'arabArtistName' => __( 'The meta title of the arabArtistName', 'wp-graphql' ),
		   'resolve' => function( $post ) {
			 $meta_title = get_arabArtistName_meta( $post->ID, '_genesis_title', true );
			 return ! empty( $meta_arabArtistName ) ? $meta_arabArtistName : 'No Title Found';
		   }
		] );
	  } );
}

add_action('init','arabicProductDescription');

function redirectBahraToFrontend() {
	$ourCurrentUser = wp_get_current_user();
	if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'adminstrator') {
	  get_admin_url();
	  exit;
	}
 
 
	if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'admin') {
	  wp_redirect(site_url().'/admin');
	 exit;
	}
 
 
	if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'event') {
	  wp_redirect('/event');
	exit;
	}
 
 
	
	if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'ertist') {
	  wp_redirect('/artist');
	exit;
	}
	if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
	  wp_redirect('/');
	  exit;
	 }
	}
	
 add_action( 'wp_login', 'redirectBahraToFrontend' );


/**
 * Register and Enqueue Scripts.
 */


/**
 * Bahra functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Bahra
 */

/**
 * Table of Contents:
 * Theme Support
 * Required Files
 * Register Styles
 * Register Scripts
 * Register Menus
 * Custom Logo
 * WP Body Open
 * Register Sidebars
 * Enqueue Block Editor Assets
 * Enqueue Classic Editor Styles
 * Block Editor Settings
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bahra_theme_support() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Custom background color.
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f5efe0',
		)
	);

	// Set content-width.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 580;
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Set post thumbnail size.
	set_post_thumbnail_size( 1200, 9999 );

	// Add custom image size used in Cover Template.
	add_image_size( 'bahra-fullscreen', 1980, 9999 );

	// Custom logo.
	$logo_width  = 120;
	$logo_height = 90;

	// If the retina setting is active, double the recommended width and height.
	if ( get_theme_mod( 'retina_logo', false ) ) {
		$logo_width  = floor( $logo_width * 2 );
		$logo_height = floor( $logo_height * 2 );
	}

	add_theme_support(
		'custom-logo',
		array(
			'height'      => $logo_height,
			'width'       => $logo_width,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Twenty Twenty, use a find and replace
	 * to change 'bahra' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'bahra' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	/*
	 * Adds starter content to highlight the theme on fresh sites.
	 * This is done conditionally to avoid loading the starter content on every
	 * page load, as it is a one-off operation only needed once in the customizer.
	 */
	if ( is_customize_preview() ) {
		require get_template_directory() . '/inc/starter-content.php';
		add_theme_support( 'starter-content', bahra_get_starter_content() );
	}

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Adds `async` and `defer` support for scripts registered or enqueued
	 * by the theme.
	 */
	$loader = new bahra_Script_Loader();
	add_filter( 'script_loader_tag', array( $loader, 'filter_script_loader_tag' ), 10, 2 );

}

add_action( 'after_setup_theme', 'bahra_theme_support' );

/**
 * REQUIRED FILES
 * Include required files.
 */
require get_template_directory() . '/inc/template-tags.php';

// Handle SVG icons.
require get_template_directory() . '/classes/class-bahra-svg-icons.php';
require get_template_directory() . '/inc/svg-icons.php';

// Handle Customizer settings.
require get_template_directory() . '/classes/class-bahra-customize.php';

// Require Separator Control class.
require get_template_directory() . '/classes/class-bahra-separator-control.php';

// Custom comment walker.
require get_template_directory() . '/classes/class-bahra-walker-comment.php';

// Custom page walker.
require get_template_directory() . '/classes/class-bahra-walker-page.php';

// Custom script loader class.
require get_template_directory() . '/classes/class-bahra-script-loader.php';

// Non-latin language handling.
require get_template_directory() . '/classes/class-bahra-non-latin-languages.php';

// Custom CSS.
require get_template_directory() . '/inc/custom-css.php';

/**
 * logout
 */
add_action( 'wp_logout','wpdocs_ahir_redirect_after_logout' );
function wpdocs_ahir_redirect_after_logout() {
    wp_safe_redirect( home_url('/login') );
    exit();
}
/**
 * Register and Enqueue Styles.
 */
function bahra_register_styles() {

	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'bahra-style', get_stylesheet_uri(), array(), $theme_version );
	wp_style_add_data( 'bahra-style', 'rtl', 'replace' );

	// Add output of Customizer settings as inline style.
	wp_add_inline_style( 'bahra-style', bahra_get_customizer_css( 'front-end' ) );

	// Add print CSS.
	wp_enqueue_style( 'bahra-print-style', get_template_directory_uri() . '/print.css', null, $theme_version, 'print' );

}

add_action( 'wp_enqueue_scripts', 'bahra_register_styles' );

/**
 * Register and Enqueue Scripts.
 */
function bahra_register_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'bahra-js', get_template_directory_uri() . '/assets/js/index.js', array(), $theme_version, false );
    wp_enqueue_script('main', get_stylesheet_directory_uri() . '/assets/js/sorting.js', '', '', true);
	wp_script_add_data( 'bahra-js', 'async', true );

}

add_action( 'wp_enqueue_scripts', 'bahra_register_scripts' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function bahra_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'bahra_skip_link_focus_fix' );

/** Enqueue non-latin language styles
 *
 * @since Bahra
 *
 */
function bahra_non_latin_languages() {
	$custom_css = Bahra_Non_Latin_Languages::get_non_latin_css( 'front-end' );

	if ( $custom_css ) {
		wp_add_inline_style( 'bahra-style', $custom_css );
	}
}

add_action( 'wp_enqueue_scripts', 'bahra_non_latin_languages' );


/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
function bahra_menus() {

	$locations = array(
		'primary'  => __( 'Desktop Horizontal Menu', 'bahra' ),
		'expanded' => __( 'Desktop Expanded Menu', 'bahra' ),
		'mobile'   => __( 'Mobile Menu', 'bahra' ),
		'footer'   => __( 'Footer Menu', 'bahra' ),
		'social'   => __( 'Social Menu', 'bahra' ),
	);

	register_nav_menus( $locations );
}

add_action( 'init', 'bahra_menus' );

/**
 * Get the information about the logo.
 *
 * @param string $html The HTML output from get_custom_logo (core function).
 * @return string
 */
function bahra_get_custom_logo( $html ) {

	$logo_id = get_theme_mod( 'custom_logo' );

	if ( ! $logo_id ) {
		return $html;
	}

	$logo = wp_get_attachment_image_src( $logo_id, 'full' );

	if ( $logo ) {
		// For clarity.
		$logo_width  = esc_attr( $logo[1] );
		$logo_height = esc_attr( $logo[2] );

		// If the retina logo setting is active, reduce the width/height by half.
		if ( get_theme_mod( 'retina_logo', false ) ) {
			$logo_width  = floor( $logo_width / 2 );
			$logo_height = floor( $logo_height / 2 );

			$search = array(
				'/width=\"\d+\"/iU',
				'/height=\"\d+\"/iU',
			);

			$replace = array(
				"width=\"{$logo_width}\"",
				"height=\"{$logo_height}\"",
			);

			// Add a style attribute with the height, or append the height to the style attribute if the style attribute already exists.
			if ( strpos( $html, ' style=' ) === false ) {
				$search[]  = '/(src=)/';
				$replace[] = "style=\"height: {$logo_height}px;\" src=";
			} else {
				$search[]  = '/(style="[^"]*)/';
				$replace[] = "$1 height: {$logo_height}px;";
			}

			$html = preg_replace( $search, $replace, $html );

		}
	}

	return $html;

}

add_filter( 'get_custom_logo', 'bahra_get_custom_logo' );

if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/**
 * Include a skip to content link at the top of the page so that users can bypass the menu.
 */
function bahra_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#site-content">' . __( 'Skip to the content', 'bahra' ) . '</a>';
}

add_action( 'wp_body_open', 'bahra_skip_link', 5 );

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bahra_sidebar_registration() {

	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
		'after_title'   => '</h2>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>',
	);

	// Footer #1.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer #1', 'bahra' ),
				'id'          => 'sidebar-1',
				'description' => __( 'Widgets in this area will be displayed in the first column in the footer.', 'bahra' ),
			)
		)
	);

	// Footer #2.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Footer #2', 'bahra' ),
				'id'          => 'sidebar-2',
				'description' => __( 'Widgets in this area will be displayed in the second column in the footer.', 'bahra' ),
			)
		)
	);

}

add_action( 'widgets_init', 'bahra_sidebar_registration' );

/**
 * Enqueue supplemental block editor styles.
 */
function bahra_block_editor_styles() {

	// Enqueue the editor styles.
	wp_enqueue_style( 'bahra-block-editor-styles', get_theme_file_uri( '/assets/css/editor-style-block.css' ), array(), wp_get_theme()->get( 'Version' ), 'all' );
	wp_style_add_data( 'bahra-block-editor-styles', 'rtl', 'replace' );

	// Add inline style from the Customizer.
	wp_add_inline_style( 'bahra-block-editor-styles', bahra_get_customizer_css( 'block-editor' ) );

	// Add inline style for non-latin fonts.
	wp_add_inline_style( 'bahra-block-editor-styles', bahra_Non_Latin_Languages::get_non_latin_css( 'block-editor' ) );

	// Enqueue the editor script.
	wp_enqueue_script( 'bahra-block-editor-script', get_theme_file_uri( '/assets/js/editor-script-block.js' ), array( 'wp-blocks', 'wp-dom' ), wp_get_theme()->get( 'Version' ), true );
}

add_action( 'enqueue_block_editor_assets', 'bahra_block_editor_styles', 1, 1 );

/**
 * Enqueue classic editor styles.
 */
function bahra_classic_editor_styles() {

	$classic_editor_styles = array(
		'/assets/css/editor-style-classic.css',
	);

	add_editor_style( $classic_editor_styles );

}

add_action( 'init', 'bahra_classic_editor_styles' );

/**
 * Output Customizer settings in the classic editor.
 * Adds styles to the head of the TinyMCE iframe. Kudos to @Otto42 for the original solution.
 *
 * @param array $mce_init TinyMCE styles.
 * @return array TinyMCE styles.
 */
function bahra_add_classic_editor_customizer_styles( $mce_init ) {

	$styles = bahra_get_customizer_css( 'classic-editor' );

	if ( ! isset( $mce_init['content_style'] ) ) {
		$mce_init['content_style'] = $styles . ' ';
	} else {
		$mce_init['content_style'] .= ' ' . $styles . ' ';
	}

	return $mce_init;

}

add_filter( 'tiny_mce_before_init', 'bahra_add_classic_editor_customizer_styles' );

/**
 * Output non-latin font styles in the classic editor.
 * Adds styles to the head of the TinyMCE iframe. Kudos to @Otto42 for the original solution.
 *
 * @param array $mce_init TinyMCE styles.
 * @return array TinyMCE styles.
 */
function bahra_add_classic_editor_non_latin_styles( $mce_init ) {

	$styles = bahra_Non_Latin_Languages::get_non_latin_css( 'classic-editor' );

	// Return if there are no styles to add.
	if ( ! $styles ) {
		return $mce_init;
	}

	if ( ! isset( $mce_init['content_style'] ) ) {
		$mce_init['content_style'] = $styles . ' ';
	} else {
		$mce_init['content_style'] .= ' ' . $styles . ' ';
	}

	return $mce_init;

}

add_filter( 'tiny_mce_before_init', 'bahra_add_classic_editor_non_latin_styles' );

/*
 * Block Editor Settings.
 * Add custom colors and font sizes to the block editor.
 */
function bahra_block_editor_settings() {

	// Block Editor Palette.
	$editor_color_palette = array(
		array(
			'name'  => __( 'Accent Color', 'bahra' ),
			'slug'  => 'accent',
			'color' => bahra_get_color_for_area( 'content', 'accent' ),
		),
		array(
			'name'  => __( 'Primary', 'bahra' ),
			'slug'  => 'primary',
			'color' => bahra_get_color_for_area( 'content', 'text' ),
		),
		array(
			'name'  => __( 'Secondary', 'bahra' ),
			'slug'  => 'secondary',
			'color' => bahra_get_color_for_area( 'content', 'secondary' ),
		),
		array(
			'name'  => __( 'Subtle Background', 'bahra' ),
			'slug'  => 'subtle-background',
			'color' => bahra_get_color_for_area( 'content', 'borders' ),
		),
	);

	// Add the background option.
	$background_color = get_theme_mod( 'background_color' );
	if ( ! $background_color ) {
		$background_color_arr = get_theme_support( 'custom-background' );
		$background_color     = $background_color_arr[0]['default-color'];
	}
	$editor_color_palette[] = array(
		'name'  => __( 'Background Color', 'bahra' ),
		'slug'  => 'background',
		'color' => '#' . $background_color,
	);

	// If we have accent colors, add them to the block editor palette.
	if ( $editor_color_palette ) {
		add_theme_support( 'editor-color-palette', $editor_color_palette );
	}

	// Block Editor Font Sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => _x( 'Small', 'Name of the small font size in the block editor', 'bahra' ),
				'shortName' => _x( 'S', 'Short name of the small font size in the block editor.', 'bahra' ),
				'size'      => 18,
				'slug'      => 'small',
			),
			array(
				'name'      => _x( 'Regular', 'Name of the regular font size in the block editor', 'bahra' ),
				'shortName' => _x( 'M', 'Short name of the regular font size in the block editor.', 'bahra' ),
				'size'      => 21,
				'slug'      => 'normal',
			),
			array(
				'name'      => _x( 'Large', 'Name of the large font size in the block editor', 'bahra' ),
				'shortName' => _x( 'L', 'Short name of the large font size in the block editor.', 'bahra' ),
				'size'      => 26.25,
				'slug'      => 'large',
			),
			array(
				'name'      => _x( 'Larger', 'Name of the larger font size in the block editor', 'bahra' ),
				'shortName' => _x( 'XL', 'Short name of the larger font size in the block editor.', 'bahra' ),
				'size'      => 32,
				'slug'      => 'larger',
			),
		)
	);

	add_theme_support( 'editor-styles' );

	// If we have a dark background color then add support for dark editor style.
	// We can determine if the background color is dark by checking if the text-color is white.
	if ( '#ffffff' === strtolower( bahra_get_color_for_area( 'content', 'text' ) ) ) {
		add_theme_support( 'dark-editor-style' );
	}

}

add_action( 'after_setup_theme', 'bahra_block_editor_settings' );

/**
 * Overwrite default more tag with styling and screen reader markup.
 *
 * @param string $html The default output HTML for the more tag.
 * @return string
 */
function bahra_read_more_tag( $html ) {
	return preg_replace( '/<a(.*)>(.*)<\/a>/iU', sprintf( '<div class="read-more-button-wrap"><a$1><span class="faux-button">$2</span> <span class="screen-reader-text">"%1$s"</span></a></div>', get_the_title( get_the_ID() ) ), $html );
}

add_filter( 'the_content_more_link', 'bahra_read_more_tag' );

/**
 * Enqueues scripts for customizer controls & settings.
 *
 * @since Bahra
 *
 * @return void
 */
function bahra_customize_controls_enqueue_scripts() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// Add main customizer js file.
	wp_enqueue_script( 'bahra-customize', get_template_directory_uri() . '/assets/js/customize.js', array( 'jquery' ), $theme_version, false );

	// Add script for color calculations.
	wp_enqueue_script( 'bahra-color-calculations', get_template_directory_uri() . '/assets/js/color-calculations.js', array( 'wp-color-picker' ), $theme_version, false );

	// Add script for controls.
	wp_enqueue_script( 'bahra-customize-controls', get_template_directory_uri() . '/assets/js/customize-controls.js', array( 'bahra-color-calculations', 'customize-controls', 'underscore', 'jquery' ), $theme_version, false );
	wp_localize_script( 'bahra-customize-controls', 'bahraBgColors', bahra_get_customizer_color_vars() );
}

add_action( 'customize_controls_enqueue_scripts', 'bahra_customize_controls_enqueue_scripts' );

/**
 * Enqueue scripts for the customizer preview.
 *
 * @since Bahra
 *
 * @return void
 */
function bahra_customize_preview_init() {
	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_script( 'bahra-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview', 'customize-selective-refresh', 'jquery' ), $theme_version, true );
	wp_localize_script( 'bahra-customize-preview', 'bahraBgColors', bahra_get_customizer_color_vars() );
	wp_localize_script( 'bahra-customize-preview', 'bahraPreviewEls', bahra_get_elements_array() );

	wp_add_inline_script(
		'bahra-customize-preview',
		sprintf(
			'wp.customize.selectiveRefresh.partialConstructor[ %1$s ].prototype.attrs = %2$s;',
			wp_json_encode( 'cover_opacity' ),
			wp_json_encode( bahra_customize_opacity_range() )
		)
	);
}

add_action( 'customize_preview_init', 'bahra_customize_preview_init' );

/**
 * Get accessible color for an area.
 *
 * @since Bahra
 *
 * @param string $area The area we want to get the colors for.
 * @param string $context Can be 'text' or 'accent'.
 * @return string Returns a HEX color.
 */
function bahra_get_color_for_area( $area = 'content', $context = 'text' ) {

	// Get the value from the theme-mod.
	$settings = get_theme_mod(
		'accent_accessible_colors',
		array(
			'content'       => array(
				'text'      => '#000000',
				'accent'    => '#3185fc',
				'secondary' => '#545e75',
				'borders'   => '#ff9500',
			),
			'header-footer' => array(
				'text'      => '#000000',
				'accent'    => '#3185fc',
				'secondary' => '#545e75',
				'borders'   => '#ff9500',
			),
		)
	);

	// If we have a value return it.
	if ( isset( $settings[ $area ] ) && isset( $settings[ $area ][ $context ] ) ) {
		return $settings[ $area ][ $context ];
	}

	// Return false if the option doesn't exist.
	return false;
}

/**
 * Returns an array of variables for the customizer preview.
 *
 * @since Bahra
 *
 * @return array
 */
function bahra_get_customizer_color_vars() {
	$colors = array(
		'content'       => array(
			'setting' => 'background_color',
		),
		'header-footer' => array(
			'setting' => 'header_footer_background_color',
		),
	);
	return $colors;
}

/**
 * Get an array of elements.
 *
 * @since Bahra
 *
 * @return array
 */
function bahra_get_elements_array() {

	// The array is formatted like this:
	// [key-in-saved-setting][sub-key-in-setting][css-property] = [elements].
	$elements = array(
		'content'       => array(
			'accent'     => array(
				'color'            => array( '.color-accent', '.color-accent-hover:hover', '.color-accent-hover:focus', ':root .has-accent-color', '.has-drop-cap:not(:focus):first-letter', '.wp-block-button.is-style-outline', 'a' ),
				'border-color'     => array( 'blockquote', '.border-color-accent', '.border-color-accent-hover:hover', '.border-color-accent-hover:focus' ),
				'background-color' => array( 'button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file .wp-block-file__button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.bg-accent', '.bg-accent-hover:hover', '.bg-accent-hover:focus', ':root .has-accent-background-color', '.comment-reply-link' ),
				'fill'             => array( '.fill-children-accent', '.fill-children-accent *' ),
			),
			'background' => array(
				'color'            => array( ':root .has-background-color', 'button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file__button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.wp-block-button', '.comment-reply-link', '.has-background.has-primary-background-color:not(.has-text-color)', '.has-background.has-primary-background-color *:not(.has-text-color)', '.has-background.has-accent-background-color:not(.has-text-color)', '.has-background.has-accent-background-color *:not(.has-text-color)' ),
				'background-color' => array( ':root .has-background-background-color' ),
			),
			'text'       => array(
				'color'            => array( 'body', '.entry-title a', ':root .has-primary-color' ),
				'background-color' => array( ':root .has-primary-background-color' ),
			),
			'secondary'  => array(
				'color'            => array( 'cite', 'figcaption', '.wp-caption-text', '.post-meta', '.entry-content .wp-block-archives li', '.entry-content .wp-block-categories li', '.entry-content .wp-block-latest-posts li', '.wp-block-latest-comments__comment-date', '.wp-block-latest-posts__post-date', '.wp-block-embed figcaption', '.wp-block-image figcaption', '.wp-block-pullquote cite', '.comment-metadata', '.comment-respond .comment-notes', '.comment-respond .logged-in-as', '.pagination .dots', '.entry-content hr:not(.has-background)', 'hr.styled-separator', ':root .has-secondary-color' ),
				'background-color' => array( ':root .has-secondary-background-color' ),
			),
			'borders'    => array(
				'border-color'        => array( 'pre', 'fieldset', 'input', 'textarea', 'table', 'table *', 'hr' ),
				'background-color'    => array( 'caption', 'code', 'code', 'kbd', 'samp', '.wp-block-table.is-style-stripes tbody tr:nth-child(odd)', ':root .has-subtle-background-background-color' ),
				'border-bottom-color' => array( '.wp-block-table.is-style-stripes' ),
				'border-top-color'    => array( '.wp-block-latest-posts.is-grid li' ),
				'color'               => array( ':root .has-subtle-background-color' ),
			),
		),
		'header-footer' => array(
			'accent'     => array(
				'color'            => array( 'body:not(.overlay-header) .primary-menu > li > a', 'body:not(.overlay-header) .primary-menu > li > .icon', '.modal-menu a', '.footer-menu a, .footer-widgets a', '#site-footer .wp-block-button.is-style-outline', '.wp-block-pullquote:before', '.singular:not(.overlay-header) .entry-header a', '.archive-header a', '.header-footer-group .color-accent', '.header-footer-group .color-accent-hover:hover' ),
				'background-color' => array( '.social-icons a', '#site-footer button:not(.toggle)', '#site-footer .button', '#site-footer .faux-button', '#site-footer .wp-block-button__link', '#site-footer .wp-block-file__button', '#site-footer input[type="button"]', '#site-footer input[type="reset"]', '#site-footer input[type="submit"]' ),
			),
			'background' => array(
				'color'            => array( '.social-icons a', 'body:not(.overlay-header) .primary-menu ul', '.header-footer-group button', '.header-footer-group .button', '.header-footer-group .faux-button', '.header-footer-group .wp-block-button:not(.is-style-outline) .wp-block-button__link', '.header-footer-group .wp-block-file__button', '.header-footer-group input[type="button"]', '.header-footer-group input[type="reset"]', '.header-footer-group input[type="submit"]' ),
				'background-color' => array( '#site-header', '.footer-nav-widgets-wrapper', '#site-footer', '.menu-modal', '.menu-modal-inner', '.search-modal-inner', '.archive-header', '.singular .entry-header', '.singular .featured-media:before', '.wp-block-pullquote:before' ),
			),
			'text'       => array(
				'color'               => array( '.header-footer-group', 'body:not(.overlay-header) #site-header .toggle', '.menu-modal .toggle' ),
				'background-color'    => array( 'body:not(.overlay-header) .primary-menu ul' ),
				'border-bottom-color' => array( 'body:not(.overlay-header) .primary-menu > li > ul:after' ),
				'border-left-color'   => array( 'body:not(.overlay-header) .primary-menu ul ul:after' ),
			),
			'secondary'  => array(
				'color' => array( '.site-description', 'body:not(.overlay-header) .toggle-inner .toggle-text', '.widget .post-date', '.widget .rss-date', '.widget_archive li', '.widget_categories li', '.widget cite', '.widget_pages li', '.widget_meta li', '.widget_nav_menu li', '.powered-by-wordpress', '.to-the-top', '.singular .entry-header .post-meta', '.singular:not(.overlay-header) .entry-header .post-meta a' ),
			),
			'borders'    => array(
				'border-color'     => array( '.header-footer-group pre', '.header-footer-group fieldset', '.header-footer-group input', '.header-footer-group textarea', '.header-footer-group table', '.header-footer-group table *', '.footer-nav-widgets-wrapper', '#site-footer', '.menu-modal nav *', '.footer-widgets-outer-wrapper', '.footer-top' ),
				'background-color' => array( '.header-footer-group table caption', 'body:not(.overlay-header) .header-inner .toggle-wrapper::before' ),
			),
		),
	);

	/**
	* Filters theme elements
	*
	* @since Bahra
	*
	* @param array Array of elements
	*/
	return apply_filters( 'bahra_get_elements_array', $elements );
}

