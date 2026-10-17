<?php
/**
 * Comments provider switch. This theme supports
 * native WordPress comments or Disqus.
 *
 * @package Oviya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function oviya_comments_provider() {
	return get_theme_mod( 'oviya_comments_provider', 'native' );
}

/**
 * If Disqus is selected, native comments are closed (Disqus replaces the
 * whole thread UI) and comments.php renders the Disqus embed instead.
 */
function oviya_maybe_disable_native_comments( $open, $post_id ) {
	if ( 'disqus' === oviya_comments_provider() ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'oviya_maybe_disable_native_comments', 10, 2 );

/**
 * Enqueues the Disqus embed script and config.
 */
function oviya_enqueue_disqus() {
	if ( ! is_singular() || 'disqus' !== oviya_comments_provider() ) {
		return;
	}
	$shortname = get_theme_mod( 'oviya_disqus_shortname' );
	if ( ! $shortname ) {
		return;
	}

	$page_url = esc_url( get_permalink() );
	$page_id  = wp_make_link_relative( get_permalink() );

	wp_enqueue_script(
		'disqus',
		esc_url( "https://{$shortname}.disqus.com/embed.js" ),
		array(),
		null,
		true
	);

	$inline_config = "var disqus_config = function () {
	this.page.url = '" . esc_url( $page_url ) . "';
	this.page.identifier = " . wp_json_encode( $page_id ) . ";
};
function reloadDisqus(event) {
	if (event.source === window && event.data && event.data.id === (window.Theme ? Theme.eventId : '')) {
		if (typeof DISQUS === 'undefined') { return; }
		if (document.readyState === 'complete') {
			DISQUS.reset({ reload: true, config: disqus_config });
		}
	}
}
if (window.Theme && Theme.isToggleable) {
	addEventListener('message', reloadDisqus);
}";

	wp_add_inline_script( 'disqus', $inline_config, 'before' );
}
add_action( 'wp_enqueue_scripts', 'oviya_enqueue_disqus' );

/**
 * Outputs the Disqus thread container.
 */
function oviya_disqus_embed() {
	$shortname = get_theme_mod( 'oviya_disqus_shortname' );
	if ( ! $shortname ) {
		return;
	}
	oviya_enqueue_disqus();
	?>
	<div id="disqus_thread"></div>
	<?php
}
