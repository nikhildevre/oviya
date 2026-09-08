<?php
/**
 * Post-processes rendered post/page HTML.
 * @package Oviya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function oviya_content_filters( $content ) {
	if ( ! is_singular() || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	// Safety net: if anything below unexpectedly returns empty/null, fall
	// back to the original content rather than showing a blank post body.
	$original = $content;

	$content = oviya_wrap_tables( $content );
	$content = oviya_wrap_code_blocks( $content );
	$content = oviya_add_heading_anchors( $content );
	$content = oviya_wrap_images( $content );

	if ( null === $content || '' === trim( (string) $content ) ) {
		return $original;
	}

	return $content;
}
add_filter( 'the_content', 'oviya_content_filters', 20 );

/**
 * Wraps every <table> so wide tables can scroll horizontally instead of
 * breaking the layout.
 */
function oviya_wrap_tables( $content ) {
	if ( false === strpos( $content, '<table' ) ) {
		return $content;
	}
	$content = preg_replace( '/<table/', '<div class="table-wrapper"><table', $content );
	$content = preg_replace( '/<\/table>/', '</table></div>', $content );
	return $content;
}

function oviya_wrap_code_blocks( $content ) {
	if ( false === strpos( $content, '<pre' ) ) {
		return $content;
	}

	$result = preg_replace_callback(
		'#<pre([^>]*)><code([^>]*)>(.*?)</code></pre>#s',
		function ( $m ) {
			list( , $pre_attrs, $code_attrs, $code_body ) = $m;

			$label_text = '';
			$label_icon = 'fas fa-code fa-fw small';

			if ( preg_match( '/language-([a-zA-Z0-9_+-]+)/', $code_attrs, $lang_match ) ) {
				$label_text = strtoupper( $lang_match[1] );
			} elseif ( preg_match( '/class="[^"]*wp-block-code[^"]*"/', $pre_attrs ) ) {
				$label_text = __( 'CODE', 'oviya' );
			}

			$copy_succeed = esc_attr__( 'Copied!', 'oviya' );

			$header  = '<div class="code-header">';
			$header .= '<span data-label-text="' . esc_attr( $label_text ) . '"><i class="' . esc_attr( $label_icon ) . '"></i></span>';
			$header .= '<button aria-label="copy" data-title-succeed="' . $copy_succeed . '"><i class="far fa-clipboard"></i></button>';
			$header .= '</div>';

			// Wrap the raw code text in a span.rouge-code so clipboard.js's
			// existing target selector (`.rouge-code`) keeps working.
			$code_body = '<span class="rouge-code">' . $code_body . '</span>';

			return $header . '<pre' . $pre_attrs . '><code' . $code_attrs . '>' . $code_body . '</code></pre>';
		},
		$content
	);

	return null === $result ? $content : $result;
}

function oviya_add_heading_anchors( $content ) {
	if ( ! preg_match( '/<h[2-5]/', $content ) ) {
		return $content;
	}

	$result = preg_replace_callback(
		'#<(h[2-5])([^>]*)>(.*?)</\1>#s',
		function ( $m ) {
			list( , $tag, $attrs, $inner ) = $m;

			if ( preg_match( '/\sid="([^"]+)"/', $attrs, $id_match ) ) {
				$id = $id_match[1];
			} else {
				$id     = sanitize_title( wp_strip_all_tags( $inner ) );
				$attrs .= ' id="' . esc_attr( $id ) . '"';
			}

			$anchor = ' <a href="#' . esc_attr( $id ) . '" class="anchor text-muted" data-toc-skip><i class="fas fa-hashtag"></i></a>';

			return '<' . $tag . $attrs . '>' . $inner . $anchor . '</' . $tag . '>';
		},
		$content
	);

	return null === $result ? $content : $result;
}

function oviya_wrap_images( $content ) {
	if ( false === strpos( $content, '<img' ) ) {
		return $content;
	}

	$result = preg_replace_callback(
		'#<a\b[^>]*>.*?</a>|<img\s[^>]*>#s',
		function ( $m ) {
			$match = $m[0];

			// Whole anchor block (may or may not contain an <img>) — leave as is.
			if ( 0 === strpos( $match, '<a' ) ) {
				return $match;
			}

			$img = $match;
			if ( false === strpos( $img, 'loading=' ) ) {
				$img = str_replace( '<img', '<img loading="lazy"', $img );
			}

			preg_match( '/\ssrc="([^"]*)"/', $img, $src_match );
			$src = $src_match[1] ?? '#';

			return '<a href="' . esc_url( $src ) . '" class="popup img-link" target="_blank" rel="noopener">' . $img . '</a>';
		},
		$content
	);

	// If the regex engine failed for any reason, fail safe and return the
	// original content rather than silently discarding the post body.
	return null === $result ? $content : $result;
}

/**
 * Limit WordPress search to blog posts only.
 */
function oviya_search_filter_posts_only( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
		$query->set( 'post_type', 'post' );
	}
	return $query;
}
add_action( 'pre_get_posts', 'oviya_search_filter_posts_only' );