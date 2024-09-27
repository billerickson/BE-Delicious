<?php
/**
 * Template Name: Publish
 *
 * @package      BE-Delicious
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

// Redirect people who can't publish content
if ( ! is_user_logged_in() && current_user_can( 'publish_posts' ) ) {
	wp_redirect( wp_login_url( get_permalink() ) );
	exit;
}

/**
 * Publish Form
 */
function be_publish_form() {
	be_display_form_location( 'publish' );
}
add_action( 'tha_entry_content_after', 'be_publish_form' );

// Build the page.
require get_template_directory() . '/index.php';
