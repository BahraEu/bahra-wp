<?php
/**
 * Customizer Separator Control settings for this theme.
 *
 * @package WordPress
 * 
 * @since Bahra
 */

if ( class_exists( 'WP_Customize_Control' ) ) {

	if ( ! class_exists( 'Bahra_Separator_Control' ) ) {
		/**
		 * Separator Control.
		 */
		class Bahra_Separator_Control extends WP_Customize_Control {
			/**
			 * Render the hr.
			 */
			public function render_content() {
				echo '<hr/>';
			}

		}
	}
}
