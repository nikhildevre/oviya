<?php
/**
 * Generic fallback template (also used for any query WordPress can't
 * match to a more specific template file). Renders the same post-card
 * list as the blog index.
 *
 * @package Oviya
 */

get_header();
get_template_part( 'template-parts/content-list' );
get_footer();
