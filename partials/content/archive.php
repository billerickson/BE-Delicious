<?php
/**
 * Archive partial
 *
 * @package      BE-Delicious
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

echo '<article class="' . be_class( 'post-summary', 'post-summary--private', 'private' === get_post_status() ) . '">';
echo '<h2 class="post-summary__title"><a href="' . esc_url( get_post_meta( get_the_ID(), 'be_delicious_url', true ) ) . '" target="_blank" rel="noopener">' . get_the_title() . '</a></h2>';
the_content();
echo '<p class="post-summary__meta">' . get_the_term_list( get_the_ID(), 'post_tag', '', ', ' ) . ' &hellip; ' . get_the_date( 'Y-m-d' ) . '</p>';
echo '</article>';
