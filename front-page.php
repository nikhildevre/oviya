<?php
/**
 * Front page template. Used whether Settings > Reading is set to "your
 * latest posts" or a static page — Oviya's home is always the blog
 * listing, so both configurations render the same card grid.
 *
 * @package Oviya
 */

get_header();
get_template_part( 'template-parts/content-list' );
get_footer();
