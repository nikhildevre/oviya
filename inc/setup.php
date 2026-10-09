<?php
/**
 * Core theme setup: add_theme_support, menus, widget areas, image sizes.
 *
 * @package Oviya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function oviya_setup() {
	load_theme_textdomain( 'oviya', OVIYA_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 630, true );
	add_image_size( 'oviya-card', 400, 400, true ); // home page card preview crop

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 112,
			'width'       => 112,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_theme_support( 'automatic-feed-links' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' )
	);

	// Native WordPress comments provide the "native" comment option
	// alongside Disqus.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/oviya.css' );
	add_theme_support( 'responsive-embeds' );

	// Add support for wide and full-width alignment in the block editor.
    add_theme_support( 'align-wide' );

    // Add default front-end styles for Gutenberg blocks.
    add_theme_support( 'wp-block-styles' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );

	/**
	 * Register navigation menus.
	 */
	register_nav_menus(
		array(
			'primary' => __( 'Sidebar Navigation (Tabs)', 'oviya' ),
		)
	);
}
add_action( 'after_setup_theme', 'oviya_setup' );

/**
 * Registers widget areas (panel sidebar + optional footer widgets).
 */
function oviya_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Panel (below Trending Tags)', 'oviya' ),
			'id'            => 'panel-widgets',
			'description'   => __( 'Extra widgets shown in the right-hand panel, below the recently-updated and trending-tags lists.', 'oviya' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="panel-heading">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'oviya_widgets_init' );

/**
 * Register a custom block pattern for the Oviya theme.
 */
function oviya_register_block_patterns() {
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    register_block_pattern(
        'oviya/technical-insight',
        array(
            'title'       => __( 'Oviya Technical Insight Box', 'oviya' ),
            'description' => __( 'A styled callout box for technical notes, code tips, or summaries.', 'oviya' ),
            'categories'  => array( 'text' ),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"20px","right":"20px","bottom":"20px","left":"20px"}}},"border":{"width":"1px"},"layout":{"type":"default"}} --><div class="wp-block-group" style="border-width:1px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px"><!-- wp:heading {"level":4} --><h4>Technical Insight</h4><!-- /wp:heading --><!-- wp:paragraph --><p>Write your core takeaway, code tip, or technical note here.</p><!-- /wp:paragraph --></div><!-- /wp:group -->',
        )
    );
}
add_action( 'init', 'oviya_register_block_patterns' );

/**
 * Register custom block styles for the Oviya theme.
 */
function oviya_register_block_styles() {
    if ( ! function_exists( 'register_block_style' ) ) {
        return;
    }

    // Add a custom style to the core paragraph block
    register_block_style(
        'core/paragraph',
        array(
            'name'         => 'oviya-highlight',
            'label'        => __( 'Highlighted Tech Note', 'oviya' ),
            'inline_style' => '.is-style-oviya-highlight { background-color: #f4f6f8; border-left: 4px solid #2563eb; padding: 12px 16px; border-radius: 4px; }',
        )
    );
}
add_action( 'init', 'oviya_register_block_styles' );

function oviya_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'oviya_content_width', 850 );
}
add_action( 'after_setup_theme', 'oviya_content_width', 0 );

function oviya_is_pinned( $post_id = null ) {
	return is_sticky( $post_id );
}

/**
 * Remove 'tag' from body_class on tag archives to prevent CSS collisions with .tag elements.
 */
add_filter( 'body_class', function( $classes ) {
    if ( is_tag() ) {
        $classes = array_diff( $classes, array( 'tag' ) );
    }
    return $classes;
});