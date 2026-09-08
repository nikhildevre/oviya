<?php
/**
 * Asset registration & conditional enqueueing.
 *
 * @package Oviya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function oviya_get_layout() {
	if ( is_singular( 'post' ) ) {
		return 'post';
	}
	if ( is_page_template( 'page-templates/page-archives.php' ) ) {
		return 'archives';
	}
	if ( is_category() ) {
		return 'category';
	}
	if ( is_tag() ) {
		return 'tag';
	}
	if ( is_page_template( 'page-templates/page-categories.php' ) ) {
		return 'categories';
	}
	if ( is_page() ) {
		return 'page';
	}
	if ( is_home() || is_front_page() ) {
		return 'home';
	}
	if ( is_search() || is_archive() || is_404() ) {
		return 'misc';
	}
	return 'commons';
}

function oviya_toc_enabled() {
	if ( ! is_singular() ) {
		return false;
	}
	if ( ! get_theme_mod( 'oviya_toc_enabled', true ) ) {
		return false;
	}
	if ( '0' === get_post_meta( get_the_ID(), '_oviya_toc', true ) ) {
		return false;
	}
	$content = get_post_field( 'post_content', get_the_ID() );
	return ( false !== strpos( $content, '<h2' ) || false !== strpos( $content, '<h3' )
		|| false !== strpos( $content, '<!-- wp:heading' ) );
}

function oviya_mermaid_enabled() {
	return is_singular() && '1' === get_post_meta( get_the_ID(), '_oviya_mermaid', true );
}

function oviya_math_enabled() {
	return is_singular() && '1' === get_post_meta( get_the_ID(), '_oviya_math', true );
}

function oviya_assets() {
	$layout = oviya_get_layout();

	// ---- Bootstrap 5 first (CSS + bundled JS) — Oviya's own stylesheet
	// depends on it and overrides several of its rules, so load order here
	// matters: Bootstrap MUST print before oviya-style in the cascade. ----
	wp_enqueue_style( 'bootstrap', OVIYA_URI . '/assets/css/bootstrap/bootstrap.min.css', array(), '5' );
	wp_enqueue_script( 'bootstrap', OVIYA_URI . '/assets/js/bootstrap/bootstrap.bundle.min.js', array(), '5', true );

	// ---- Theme stylesheet (compiled from Oviya's SCSS) ----
	// Declared as depending on 'bootstrap' so WordPress guarantees it is
	// printed after Bootstrap's CSS even if enqueue order is ever changed.
	wp_enqueue_style( 'oviya-style', OVIYA_URI . '/assets/css/oviya.css', array( 'bootstrap' ), OVIYA_VERSION );

	// ---- Web fonts (Lato + Source Sans Pro, same families as upstream) ----
	wp_enqueue_style(
		'oviya-webfonts',
		OVIYA_URI . '/assets/css/fonts.css',
		array( 'oviya-style' ),
		null
	);

	// ---- Font Awesome ----
	wp_enqueue_style(
		'oviya-fontawesome',
		OVIYA_URI . '/assets/css/fontawesome-free/all.min.css',
		array( 'oviya-webfonts' ),
		'7'
	);

	// ---- TOC (tocbot) ----
	if ( oviya_toc_enabled() ) {
		wp_enqueue_style( 'tocbot', OVIYA_URI . '/assets/css/tocbot/tocbot.min.css', array( 'oviya-fontawesome' ), '4' );
		wp_enqueue_script( 'tocbot', OVIYA_URI . '/assets/js/tocbot/tocbot.min.js', array(), '4', true );
	}

	// ---- Lazy-load polyfill + GLightbox + clipboard.js on post/page/home ----
	if ( in_array( $layout, array( 'post', 'page', 'home' ), true ) ) {
		wp_enqueue_style( 'lazy-polyfill', OVIYA_URI . '/assets/css/lazy-polyfill/loading-attribute-polyfill.min.css', array( 'oviya-fontawesome' ), '2' );
		wp_enqueue_script( 'lazy-polyfill', OVIYA_URI . '/assets/js/lazy-polyfill/loading-attribute-polyfill.umd.min.js', array(), '2', true );

		if ( 'home' !== $layout ) {
			wp_enqueue_style( 'glightbox', OVIYA_URI . '/assets/css/glightbox/glightbox.min.css', array( 'oviya-fontawesome' ), '3' );
			wp_enqueue_script( 'glightbox', OVIYA_URI . '/assets/js/glightbox/glightbox.min.js', array(), '3', true );
			wp_enqueue_script( 'clipboard', OVIYA_URI . '/assets/js/clipboard/clipboard.min.js', array(), '2', true );
		}
	}

	// ---- dayjs (relative/localized date formatting) ----
	if ( in_array( $layout, array( 'home', 'post', 'archives', 'category', 'tag' ), true ) ) {
		$locale = substr( str_replace( '_', '-', get_locale() ), 0, 2 );
		wp_enqueue_script( 'dayjs', OVIYA_URI . '/assets/js/dayjs/dayjs.min.js', array(), '1', true );
		wp_enqueue_script( 'dayjs-locale', OVIYA_URI . "/assets/js/dayjs/dayjs-locale.js", array( 'dayjs' ), '1', true );
		wp_enqueue_script( 'dayjs-relativeTime', OVIYA_URI . '/assets/js/dayjs/dayjs-relativeTime.js', array( 'dayjs' ), '1', true );
		wp_enqueue_script( 'dayjs-localizedFormat', OVIYA_URI . '/assets/js/dayjs/dayjs-localizedFormat.js', array( 'dayjs' ), '1', true );
	}

	// ---- Mermaid diagrams (per-post opt-in) ----
	if ( oviya_mermaid_enabled() ) {
		wp_enqueue_script( 'mermaid', OVIYA_URI . '/assets/js/mermaid/mermaid.min.js', array(), '11', true );
	}

	// ---- MathJax (per-post opt-in) ----
	if ( oviya_math_enabled() ) {
		wp_enqueue_script( 'mathjax', OVIYA_URI . '/assets/js/mathjax/tex-mml-chtml.js', array(), '4', true );
	}

	// ---- Theme's own JS ----
	wp_enqueue_script( 'oviya-theme-core', OVIYA_URI . '/assets/js/theme-core.js', array(), OVIYA_VERSION, false );
	wp_enqueue_script( 'oviya-app', OVIYA_URI . '/assets/js/oviya-app.js', array( 'bootstrap' ), OVIYA_VERSION, true );
	wp_script_add_data( 'oviya-app', 'strategy', 'defer' );

	wp_localize_script(
		'oviya-app',
		'OviyaSettings',
		array(
			'layout'   => $layout,
			'toc'      => oviya_toc_enabled(),
			'mermaid'  => oviya_mermaid_enabled(),
			'copySucceed' => esc_html__( 'Copied!', 'oviya' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'oviya_assets' );

function oviya_enqueue_comments_reply() {
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'oviya_enqueue_comments_reply' );

function oviya_add_defer_attribute( $tag, $handle ) {
	if ( 'defer' === wp_scripts()->get_data( $handle, 'strategy' ) ) {
		if ( false === strpos( $tag, ' defer' ) ) {
			$tag = str_replace( ' src=', ' defer src=', $tag );
		}
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'oviya_add_defer_attribute', 10, 2 );
