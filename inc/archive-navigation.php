<?php
/**
 * Navigation
 *
 * @package      BE-Delicious
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

/**
 * Archive Navigation
 */
function be_archive_nav() {

	if ( is_singular() ) {
		return;
	}

	$links[] = get_previous_posts_link( '&laquo; earlier' );
	$links[] = get_next_posts_link( 'later &raquo;' );
	$links = array_filter( $links );
	echo '<p class="archive-navigation">' . join( ' | ', $links ) . '</p>';
}
//add_action( 'tha_content_while_before', 'be_archive_nav' );
add_action( 'tha_content_while_after', 'be_archive_nav' );
