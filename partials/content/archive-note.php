<?php
/**
 * Archive partial
 *
 * @package      BE-Delicious
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

echo '<article class="' . be_class( 'post-summary post-summary--note', 'post-summary--private', 'private' === get_post_status() ) . '">';
echo '<h2 class="post-summary__title"><a href="' . get_permalink() . '">Note: ' . get_the_title() . '</a></h2>';
echo '<p class="post-summary__meta">' . get_the_term_list( get_the_ID(), 'post_tag', '', ', ' ) . ' &hellip; ' . get_the_date( 'Y-m-d' ) . '</p>';
echo '</article>';
