<?php
/**
 * Root sidebar.php, present for WordPress coding-standards completeness
 * (get_sidebar() looks for this file). The theme's actual navigation
 * sidebar is rendered directly from header.php via
 * get_template_part('template-parts/sidebar') so it appears in the right
 * place in the document (before #main-wrapper, not inside <main>) —
 * this file simply delegates to that same template part so get_sidebar()
 * also works correctly if a plugin calls it.
 *
 * @package Oviya
 */

get_template_part( 'template-parts/sidebar' );
